<?php

class Register {

  private $manager;

  public function __construct( $manager ) {
    $this->manager = $manager;
  }

  public function add_component( $component ) {
    $type = array_key_exists( 'type', $component['settings'] ) ? $component['settings']['type'] : '';

    switch ( $type ) {
      case 'color':
        $this->manager->add_control(
          new WP_Customize_Color_Control(
            $this->manager,
            $component['id'],
            $component['settings']
          )
        );
        break;
      case 'image':
        $this->manager->add_control(
          new WP_Customize_Image_Control(
            $this->manager,
            $component['id'],
            $component['settings']
           )
        );
        break;
      case 'image_crop':
        $this->manager->add_control(
          new WP_Customize_Cropped_Image_Control(
            $this->manager,
            $component['id'],
            $component['settings']
          )
        );
        break;
      case 'file':
        $this->manager->add_control(
          new WP_Customize_Media_Control(
            $this->manager,
            $component['id'],
            $component['settings']
          )
        );
      case 'custom':
        $this->manager->add_control(
          new WP_Customize_Control(
            $this->manager,
            $component['id'],
            $component['settings']
          )
        );
      default:
        call_user_func_array(
          [$this->manager, $component['method']],
          [$component['id'], $component['settings']]
        );
        break;
    }
  }

  public function refresh_method( $component ) {
    $selective_refresh = array_key_exists( 'selective_refresh', $component );
    $js_refresh = array_key_exists( 'js_refresh', $component );

    if ( $selective_refresh ) {
      $this->add_partial( $component );
      return null;
    } else if ( $js_refresh ) {
      $component['js_refresh']['id'] = $component['id'];
      return $component['js_refresh'];
    } else {
      return null;
    }
  }

  public function add_partial( $component ) {
    $id = $component['id'];
    $component['selective_refresh']['settings'] = $id;

    $component['selective_refresh']['render_callback'] = function() use ( $id ) {
      return get_theme_mod( $id );
    };

    $this->manager->selective_refresh->add_partial( $id, $component['selective_refresh'] );
  }
}
