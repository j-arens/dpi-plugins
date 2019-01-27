<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

// expose a global function to get blog posts for other devs
function getDPIBlogPosts($quantity = -1) {
    return DPI_Blog_Init::externalRPBQuery($quantity);
}

class DPI_Blog_Init {

    // classes
    private $cron;
    private $blogPosts;
    private $pluginPage;
    private $shortcode;
    private $componentFactory;
    private $viewer;

    // config params
    private static $cptName = 'dpi_blog_posts';
    private $cronEventHook = 'dpi_blog_sync';
    private $shortcodeKey = 'dpi_blog_posts';
    private $endpoint = 'https://diocesan.com/wp-json/wp/v2/posts?_embed';
    private $components = ['error', 'article cards'];
    
    /**
    * Setup default values in the database
    */
    public static function install() {
        return false;
    }

    /**
    * Remove posts from database
    */
    public static function uninstall() {
        $posts = get_posts([
            'post_type' => self::$cptName,
            'numberposts' => -1
        ]);

        foreach($posts as $post) {
            // if the post has a thumbnail delete associated values from database and remove file from uploads folder
            if (has_post_thumbnail($post->ID)) {
                $thumbnailID = get_post_thumbnail_id($post->ID);
                @unlink(wp_upload_dir()['path'] . '/' . basename(get_the_post_thumbnail_url($thumbnailID)));
                wp_delete_attachment($thumbnailID, true);
            }

            wp_delete_post($post->ID, true);
        }
    }

    /**
    * Wrapper around get_posts for external queries
    */
    public static function externalRPBQuery($quantity) {
        return get_posts([
            'post_type' => self::$cptName,
            'numberposts' => $quantity
        ]);
    }

    /**
    * Check for and install any updates
    */
    public function checkForUpdates() {
        return false;
    }

    /**
    * Startup
    */
    public function init() {
        $this->loadCron();
        $this->loadBlogPosts();
        $this->loadComponentFactory();

        if (is_admin()) {
            $this->loadPluginPage();
        } else {
            $this->loadShortcode();
            $this->loadViewer();
        }
    }

    /**
    * Init the cron class
    */
    private function loadCron() {
        $this->cron = new DPI_Blog_Cron();
        $this->cron->setHook($this->cronEventHook);
        $this->cron->setInterval('daily', 86400);
        $this->cron->init();
    }

    /**
    * Init the blog posts class
    */
    private function loadBlogPosts() {
        $this->blogPosts = new DPI_Blog_Posts();
        $this->blogPosts->setCptName(self::$cptName);
        $this->blogPosts->setEventHook($this->cronEventHook);
        $this->blogPosts->setPostsEndpoint($this->endpoint);
        $this->blogPosts->init();
    }

    /**
    * Init the component factory class
    */
    private function loadComponentFactory() {
        $this->componentFactory = new DPI_Blog_Component_Factory();
        $this->componentFactory->setCptName(self::$cptName);
        $this->componentFactory->setComponents($this->components);
        $this->componentFactory->init();
    }

    /**
    * Init the plugin page class
    */
    private function loadPluginPage() {
        $this->pluginPage = new DPI_Blog_Plugin_Page();
        $this->pluginPage->init();
    }

    /**
    * Init the shortcode class
    */
    private function loadShortcode() {
        $this->shortcode = new DPI_Blog_Shortcode();
        $this->shortcode->setShortcodeKey($this->shortcodeKey);
        $this->shortcode->setFactory($this->componentFactory);
        $this->shortcode->init();
    }

    /**
    * Init the viewer class
    */
    private function loadViewer() {
        $posts = get_posts(['post_type' => self::$cptName, 'numberposts' => -1]);

        if (!empty($posts)) {
            $this->viewer = new DPI_Blog_Viewer($posts);
            $this->viewer->enqueue();
        }
    }
}