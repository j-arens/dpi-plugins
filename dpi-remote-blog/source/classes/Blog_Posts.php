<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

class Blog_Posts {

    private $cptName;
    private $postsEndpoint;
    private $eventHook;

    /**
    * Set the custom post type name
    */
    public function setCptName($str) {
        if (gettype($str) === 'string') {
            $this->cptName = $str;
        } else {
            throw new \Exception('DPI_BLOG_POSTS: setCpt expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Set the endpoint to pull blog posts from
    */
    public function setPostsEndpoint($str) {
        if (gettype($str) === 'string') {
            $this->postsEndpoint = $str;
        } else {
            throw new \Exception('DPI_BLOG_POSTS: setEndpoint expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Set the name of cron event to run sync on
    */
    public function setEventHook($str) {
        if (gettype($str) === 'string') {
            $this->eventHook = $str;
        } else {
            throw new \Exception('DPI_BLOG_POSTS: setEventHook expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Startup
    */
    public function init() {
        if (count(array_filter(get_object_vars($this))) === 3) {
            $this->createCpt();
            add_action($this->eventHook, [$this, 'sync']);
            add_action('pre_get_posts', [$this, 'hideRBPImagesLegacy']);
            add_filter('posts_where', [$this, 'hideRBPImagesAJAX']);
        } else {
            throw new \Exception('DPI_BLOG_POSTS: $cptName, $endPoint, and $eventHook must be set before running init!');
            return false;
        }
    }

    /**
    * Create the dpi_blog_posts cpt
    */
    private function createCpt() {
        if (!post_type_exists($this->cptName)) {
            register_post_type($this->cptName, ['public' => false]);
        }
    }

    /**
    * Fetch remote blog posts from an endpoint
    */
    private function getRemotePosts() {
        if ($this->postsEndpoint) {
            $req = wp_remote_get($this->postsEndpoint);

            if (is_wp_error($req)) {
                return false;
            } else {
                return json_decode(wp_remote_retrieve_body($req));
            }
        } else {
            throw new \Exception('DPI_BLOG_POSTS: no endpoint set for getRemotePosts!');
            return false;
        }
    }

    /**
    * Fetch saved blog posts from the database
    */
    private function getLocalPosts() {
        return get_posts([
            'post_type' => $this->cptName, 
            'numberposts' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);
    }

    /**
    * Get an array of all the local post dates in unixtime
    */
    private function getLocalPostDates($localPosts) {
        return array_map(function($post) {
            return new \DateTime($post->post_date_gmt);
        }, $localPosts);
    }

    /**
    * Store only the 10 most recent posts
    */
    private function sortPosts($local, $remote) {
        if ($local && $remote) {
            $localCopy = $local;
            $localPostDates = $this->getLocalPostDates($local);

            // 1. Slice the remote posts so we don't have more than we need and loop over them
            // 2. Check if the current remote post date is newer than the newest local post date
            // 3. If the above condition is true, insert that remote post into the database
            // 4. Offset the newly inserted post by removing the oldest local post if there are 10 or more
            foreach(array_slice($remote, 0, 10) as $remotePost) {
                if (new \dateTime($remotePost->date_gmt) > max($localPostDates)) {
                    $this->insertPost($remotePost);

                    if (count($local) >= 10) {
                        $postID = array_pop($localCopy)->ID;

                        // if the post has a thumbnail delete associated values from database and remove file from uploads folder
                        if (has_post_thumbnail($postID)) {
                            $thumbnailID = get_post_thumbnail_id($postID);
                            @unlink(wp_upload_dir()['path'] . '/' . basename(get_the_post_thumbnail_url($thumbnailID)));
                            wp_delete_attachment($thumbnailID, true);
                        }

                        wp_delete_post($postID, true);
                    }
                }
            }
        }
    }
 
    /**
    * check if post has an image, return 
    */
    private function getPostImageURL($post) {
        if (property_exists($post, '_embedded') && 
            property_exists($post->_embedded, 'wp:featuredmedia') &&
            !empty($post->_embedded->{'wp:featuredmedia'}) &&
            property_exists($post->_embedded->{'wp:featuredmedia'}[0], 'source_url')) {
                return $post->_embedded->{'wp:featuredmedia'}[0]->source_url;
        } else {
            return false;
        }
    }

    /**
    * Strip all not-allowed html tags and attributes
    */
    private function stripTags($content, $allowedTags = []) {
        $allowedProtocols = ['https', 'http', 'mailto'];
        $content = wp_kses($content, $allowedTags, $allowedProtocols);
        return wp_specialchars_decode(htmlentities($content, ENT_NOQUOTES));
    }

    /**
    * Check if post content contains vc shortcodes and replace content with a link
    */
    private function stripVC($post, $content) {
        if (preg_match_all('/' . get_shortcode_regex(['vc_row']) . '/s', $content, $matches) &&
            array_key_exists(2, $matches) &&
            in_array('vc_row', $matches[2])) {
                return '<a href="' . $post->link . '" target="_blank">View this article on Diocesan.com</a>';
        } else {
            return $content;
        }
    }

    /**
    * Store a post in the database
    */
    private function insertPost($remotePost) {
        $postImageURL = $this->getPostImageURL($remotePost);

        $allowedExcerptTags = [
            'a' => [
                'href' => true,
                'target' => '_blank'
            ]
        ];

        $allowedContentTags = [
            'p' => '',
            'h1' => '',
            'h2' => '',
            'h3' => '',
            'h4' => '',
            'h5' => '',
            'h6' => '',
            'a' => [
                'href' => true,
                'target' => '_blank'
            ]
        ];

        $insertID = wp_insert_post([
            'post_type' => $this->cptName,
            'post_date' => $remotePost->date,
            'post_date_gmt' => $remotePost->date_gmt,
            'post_content' => $this->stripTags($this->stripVC($remotePost, $remotePost->content->rendered), $allowedContentTags),
            'post_excerpt' => $this->stripTags($this->stripVC($remotePost, $remotePost->excerpt->rendered), $allowedExcerptTags),
            'post_title' => $remotePost->title->rendered,
            'post_status' => 'publish',
            'meta_input' => [
                'post_remote_id' => $remotePost->id,
                'post_remote_link' => $remotePost->link,
                'post_remote_img_link' => $postImageURL,
            ]
        ]);

        if ($postImageURL && $insertID) {
            $this->insertPostImage($postImageURL, $insertID, $remotePost);
        }
    }

    /**
    * Download, store, and attach post featured image
    */
    private function insertPostImage($url, $insertID, $remotePost) {
        $tempFile = download_url($url, 5);

        if (!is_wp_error($tempFile)) {
            $file = [
                'name' => basename($url),
                'type' => $remotePost->_embedded->{'wp:featuredmedia'}->mime_type,
                'tmp_name' => $tempFile,
                'error' => 0,
                'size' => filesize($tempFile)
            ];

            $insertImgID = media_handle_sideload($file, $insertID, 'DPI_REMOTE_BLOG_IMAGE', ['post_parent' => $insertID]);

            if ($insertImgID) {
                set_post_thumbnail($insertID, $insertImgID);
            }
        }

        @unlink($tempFile);
    }

    /**
    * Wrapper around func's to fetch, sort, and insert or delete blog posts
    */
    public function sync() {
        $localPosts = $this->getLocalPosts();
        $remotePosts = $this->getRemotePosts();

        if (!post_type_exists($this->cptName)) {
            $this->createCpt();
        }

        if (empty($localPosts) && !empty($remotePosts)) {
            foreach(array_slice($remotePosts, 0, 10) as $post) {
                $this->insertPost($post);
            }
        } else {
            $this->sortPosts($localPosts, $remotePosts);
        }
    }
    
    /**
    * Get the ids for all featured images inserted by the plugin
    */
    private function getRBPImgIds() {
        global $wpdb;
        
        // querying the database directly because WP goes into a recursive race condition 
        // if trying to use new wp_query() or get_posts() inside query filters
        $attachments = $wpdb->get_results('SELECT * FROM wp_posts WHERE post_title = "DPI_REMOTE_BLOG_IMAGE"');
        
        if (empty($attachments)) {
            return false;
        }
        
        return array_map(function($post) { return $post->ID;}, $attachments);
    }
    
    /**
    * Don't show inserted featured images in legacy media library
    */
    public function hideRBPImagesLegacy($query) {
        global $pagenow;

        if (('edit.php' == $pagenow && 'upload.php' == $pagenow) || $query->is_admin) {
            $query->query_vars['post__not_in'] = $this->getRBPImgIDs();
        }
        
        return $query;
    }
    
    /**
    * Don't show inserted featured images in backbone media library
    */
    public function hideRBPImagesAJAX($where) {
        if (isset($_POST['action']) && $_POST['action'] == 'query-attachments') {
    	    $where .= ' AND wp_posts.ID NOT IN ('. implode(',', $this->getRBPImgIDs()) .')';
    	}
    
        return $where;
    }
}