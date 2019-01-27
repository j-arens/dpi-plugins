<?php

class Customizer {

  private $manager;
  private $localize = [];
  private $components;
  private $register;
  private $sanitize;
  private $validate;

  public function __construct() {
    add_action( 'customize_register' [$this, 'init'] );
    add_action( 'customize_preview_init', [$this, 'customizer_js'] );
  }

  public function init( $wp_customize ) {
    $this->manager = $wp_customize;
    $this->register = new Register( $this->manager );
    $this->sanitize = new Sanitize( $this->manager );
    $this->validate = new Validate( $this->manager );
    $this->loop_components( $this->components );
    $this->remove_defaults();
  }

  public function loop_components( $arr ) {
    $iterator = new RecursiveArrayIterator( $arr );

    while ( $iterator->valid() ) {
      if ( $iterator->hasChildren() ) {
        foreach( $iterator->getChildren() as $k => $component ) {

          if ( $component['method'] === 'add_setting' ) {
            $component['settings']['sanitize_callback'] = $this->sanitize->register_callback();
            // $component['settings']['validate_callback'] = $this->validate->register_callback();
          }

          $this->register->add_component( $component );
          array_push( $this->localize, $this->register->refresh_method( $component ) );
        }
      }
      $iterator->next();
    }
  }

  public function customizer_js() {
    wp_register_script( 'dpi-customizer-js', asset_path( 'scripts/js/dpiCustomizer.js' ), ['jquery', 'customize-preview'], '1.0.0', true );
    wp_localize_script( 'dpi-customizer-js', 'dpi_cust_local', json_encode( $this->localize ) );
    wp_enqueue_script( 'dpi-customizer-js' );
  }

  public function remove_defaults() {
    $defaults = [
      'colors',
      'header_image',
      'background_image',
      'static_front_page',
      'custom_css',
      'themes',
    ];

    foreach( $defaults as $default ) {
      $this->manager->remove_section( $default );
    }

    // can't remove the menus or widget panels with remove_panel(), thanks wordpress...
    remove_action( 'customize_controls_enqueue_scripts', [$this->manager->nav_menus, 'enqueue_scripts'] );
    remove_action( 'customize_register', [$this->manager->nav_menus, 'customize_register'], 11 );
    remove_filter( 'customize_dynamic_setting_args', [$this->manager->nav_menus, 'filter_dynamic_setting_args'] );
    remove_filter( 'customize_dynamic_setting_class', [$this->manager->nav_menus, 'filter_dynamic_setting_class'] );
    remove_action( 'customize_controls_print_footer_scripts', [$this->manager->nav_menus, 'print_templates'] );
    remove_action( 'customize_controls_print_footer_scripts', [$this->manager->nav_menus, 'available_items_template'] );
    remove_action( 'customize_preview_init', [$this->manager->nav_menus, 'customize_preview_init'] );

    remove_action( 'customize_controls_enqueue_scripts', [$this->manager->widgets, 'enqueue_scripts'] );
    remove_action( 'customize_register', [$this->manager->widgets, 'customize_register'], 11 );
    remove_filter( 'customize_dynamic_setting_args', [$this->manager->widgets, 'filter_dynamic_setting_args'] );
    remove_filter( 'customize_dynamic_setting_class', [$this->manager->widgets, 'filter_dynamic_setting_class'] );
    remove_action( 'customize_controls_print_footer_scripts', [$this->manager->widgets, 'print_templates'] );
    remove_action( 'customize_controls_print_footer_scripts', [$this->manager->widgets, 'available_items_template'] );
    remove_action( 'customize_preview_init', [$this->manager->widgets, 'customize_preview_init'] );
  }
}
