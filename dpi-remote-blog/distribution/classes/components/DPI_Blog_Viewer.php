<?php namespace DPI_Blog\Classes\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

/**
* This is the one component that doesn't implent the component interface.
* The viewer is meant to be a global component that's always available for other devs to use.
* Check out the article cards component to see an example of using the viewer. 
*/

class DPI_Blog_Viewer {

    private $posts;

    /**
    * Init properties
    */
    public function __construct($posts) {
        $this->posts = $posts;
    }

    /**
    * Condense and map posts
    */
    private function mapPosts($posts) {
        return array_map(function($post) {
            // TODO - create backup image
            $imageURL = '';

            if (has_post_thumbnail($post)) {
                $imageURL = get_the_post_thumbnail_url($post, 'large');
            }

            return [
                'date' => $post->post_date,
                'title' => $post->post_title,
                'content' => $post->post_content,
                'imageURL' => $imageURL
            ];
        }, $posts);
    }

    /**
    * Enqueue scripts and styles to make the viewer globally available
    */
    public function enqueue() {
        // css
        wp_enqueue_style(
            'dpi-blog-viewer-css',
            plugins_url('/styles/viewer.css', DPI_BLOG_ROOT),
            null,
            filemtime(plugin_dir_path(DPI_BLOG_ROOT) . '/styles/viewer.css'),
            'all'
        );

        // js
        wp_register_script(
            'dpi-blog-viewer-js', 
            plugins_url('/js/viewer.js', DPI_BLOG_ROOT), 
            null, 
            filemtime(plugin_dir_path(DPI_BLOG_ROOT) . '/js/viewer.js'), 
            true
        );

        // global posts
        wp_localize_script(
            'dpi-blog-viewer-js',
            'dpiBlogPosts',
            json_encode($this->mapPosts($this->posts))
        );

        wp_enqueue_script('dpi-blog-viewer-js');
    }
}