<?php namespace DPI_Blog\Components;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

use DPI_Blog\Classes\Component;

class Article_Cards implements Component {
    
    private $posts;
    private $args;
    
    /**
    * Init properties
    */
    public function __construct($posts, $args) {
        $this->posts = $posts;
        $this->args = $args;
    }
    
    /**
    * Enqueue js/css
    */
    public function loadAssets() {
        // css
        wp_enqueue_style(
            'article-cards-css',
            plugins_url('/styles/articleCards.css', DPI_BLOG_ROOT),
            null,
            filemtime(plugin_dir_path(DPI_BLOG_ROOT) . '/styles/articleCards.css'),
            'all'
        );

        // js
        wp_enqueue_script(
            'article-cards-js', 
            plugins_url('/js/articleCards.js', DPI_BLOG_ROOT), 
            null, 
            filemtime(plugin_dir_path(DPI_BLOG_ROOT) . '/js/articleCards.js'), 
            true
        );
    }

    /**
    * Generate the markup for the cards
    */
    private function generateArticleCards($posts) {
        $counter = -1;
        // TODO - create backup featured image
        $imageURL = '';

        return array_map(function($post) use(&$counter, &$imageURL){
            $counter++;
            
            if (has_post_thumbnail($post)) {
                $imageURL = get_the_post_thumbnail_url($post, 'large');
            }

            // responsive image example
            // <img style="width: 100%; height: 100%;"
            //     src="' . get_the_post_thumbnail_url($post) . '" 
            //     srcset="' . wp_get_attachment_image_srcset(get_post_thumbnail_id($post->ID)) . '"
            //     sizes="' . wp_get_attachment_image_sizes(get_post_thumbnail_id($post->ID)) . '"
            //     alt="DPI Blog Image" 
            // />
                
            return '
                <article class="dpiBlog-articleCards__article" data-articleidx="' . $counter . '">
                    <figure class="dpiBlog-articleCards__figure">
                        <div class="dpiBlog-articleCards__figure-img" style="background-image: url(' . $imageURL . ')"></div>
                    </figure>
                    <div class="dpiBlog-articleCards__content">
                        <h2 class="dpiBlog-articleCards__title">' . get_the_title($post) . '</h2>
                        <hr class="dpiBlog-articleCards__rule" />
                        <p class="dpiBlog-articleCards__excerpt">' . get_the_excerpt($post) . '</p>
                        <a href="' . get_the_permalink($post) . '" class="dpiBlog-articleCards__link">Read More <svg class="dpiBlog-articleCards__link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75.6 57.9"><path d="M4.5 33.4h55.8L43.5 50.2c-1.8 1.8-1.8 4.6 0 6.4 1.8 1.8 4.6 1.8 6.4 0l24.4-24.4c0.8-0.8 1.3-2 1.3-3.2s-0.5-2.3-1.3-3.2L49.9 1.3C49 0.4 47.9 0 46.7 0s-2.3 0.4-3.2 1.3c-1.8 1.8-1.8 4.6 0 6.4L60.3 24.4H4.5c-2.5 0-4.5 2-4.5 4.5C0 31.4 2 33.4 4.5 33.4z"/></svg></a>
                    </div>
                </article>
            ';
        }, array_slice($posts, 0, $this->args['max_posts']));
    }
    
    /**
    * Render out the markup for the article cards component
    */
    public function render() {
        if (!empty($this->posts)) {
            return '
                <div id="dpiBlog-articleCards__root">
                    ' . implode('', $this->generateArticleCards($this->posts)) . '
                </div>
            ';
        } else {
            return '
                <div id="dpiBlog-articleCards__root">
                    <p class="dpiBlog-articleCards__empty">Sorry, there aren\'t any posts to display right now.</p>
                </div>
            ';
        }
    }
}