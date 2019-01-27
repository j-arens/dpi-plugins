<?php




/**** DPI SITE CUSTOMIZER ****/




// CUSTOMIZER SETUP

class Custom_Options_Page {
	private $settings;
	private $parents;


/**
* Class constructor
*/
	public function __construct() {
		$this->settings_base = 'opt_page_';

    // Initialise settings
  	add_action( 'admin_init', array( $this, 'init' ) );

  	// Register plugin settings
  	add_action( 'admin_init' , array( $this, 'register_settings' ) );

  	// Add settings page to menu
  	add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

    // enqueue styles
    add_action( 'admin_enqueue_scripts', array( $this, 'page_styles' ) );

    // enqueue scripts
    add_action( 'admin_enqueue_scripts', array( $this, 'page_scripts' ) );
	}


/**
* Initialise options page model
*/
  public function init() {
    $this->settings = $this->settings_fields();
		$this->parents = $this->site_sections();
  }


/**
* Add settings page to admin menu
*/
  public function add_menu_item() {
    add_menu_page( 'Homepage Customizer', 'Homepage Customizer', 'manage_options', 'homepage_customizer', array( $this, 'settings_page' ), 'dashicons-admin-home', 3 );
  }


/**
* Custom options page styles
*/
  public function page_styles() {

    // admin page styles
    wp_register_style('options-page-admin-styles', get_template_directory_uri() . '/admin-styles/opt-page-styles.css', '1.0.0', 'all' );
    wp_enqueue_style('options-page-admin-styles');

    // farbtastic
    wp_enqueue_style( 'farbtastic' );
  }


/**
* Custom options page scripts
*/
  public function page_scripts() {

    // media picker
    wp_enqueue_media();

    // opt page script
    wp_register_script( 'options-page-admin-js', get_template_directory_uri() . '/js/settings.js', array( 'farbtastic', 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'options-page-admin-js' );
	}

// MODEL AND REGISTER DATA

/**
* Model of editable site sections
*/
private function site_sections() {
	$parents = array(
		'header',
		'homepage',
		'footer',
	);

	return $parents;
}

/**
* Model of components and fields
*/
private function settings_fields() {

	$settings['mission-statement'] = array(
		'parent' => 'header',
		'title' => 'Mission Statement',
		'description' => 'this is the description 1',
		'sections' => array(
			'content',
			'link',
		),
		'fields' => array(
			array(
				'parent' => 'content', // containing component
				'id' => 'header_content_text_field_0', // id
				'label' => 'Title', // title of the input
				'description' => 'description for text_field_0', // descrip of the input
				'type' => 'text', // type of input
				'default' => '', // default value of input
				'placeholder' => '', // placeholder text of input
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'content',
				'id' => 'header_content_textarea_1',
				'label' => 'Content',
				'description' => 'description for textarea_1',
				'type' => 'textarea',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'header_link_text_field_2',
				'label' => 'Link Title',
				'description' => 'description for link_text_field_0',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'header_link_text_field_3',
				'label' => 'Link Title',
				'description' => 'Link button text',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_sanitize_text_input',
			),
		)
	);

	$settings['link-box'] = array(
		'parent' => 'header',
		'title' => 'Link Box',
		'description' => 'this is the description link ox',
		'sections' => array(
			'background image',
			'overlay color',
			'content',
			'link'
		),
		'fields' => array(
			array(
				'parent' => 'background image',
				'id' => 'header_link_box_image_field_4',
				'label' => 'Background Image',
				'description' => '',
				'type' => 'image',
				'default' => '',
			),
			array(
				'parent' => 'overlay color',
				'id' => 'header_link_box_color_field_5',
				'label' => 'Overlay Color',
				'type' => 'color',
				'default' => '#cccccc'
			),
			array(
				'parent' => 'content',
				'id' => 'header_link_box_text_field_6',
				'label' => 'Link Box Title',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'content',
				'id' => 'header_link_box_text_field_7',
				'label' => 'Day',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'content',
				'id' => 'header_link_box_textarea_8',
				'label' => 'Days and Times',
				'description' => '',
				'type' => 'textarea',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'header_link_box_text_field_9',
				'label' => 'Button Title',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'header_link_box_text_field_10',
				'label' => 'Link URL',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
		)
	);

	$settings['icon-box'] = array(
		'parent' => 'homepage',
		'title' => 'Icon Box',
		'description' => 'this is the description 2',
		'sections' => array(
			'icon',
			'content'
		),
		'fields' => array(
			array(
				'parent' => 'icon',
				'id' => 'field-id-1-2',
				'label' => 'label 1-2',
				'description' => 'description 1-2',
				'type' => 'text',
				'default' => 'default 1-2',
				'placeholder' => 'placeholder 1-2',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'content',
				'id' => 'field-id-2-2',
				'label' => 'label 2-2',
				'description' => 'description 2-2',
				'type' => 'text',
				'default' => 'default 2-2',
				'placeholder' => 'placeholder 2-2',
				'callback' => 'opt_page_sanitize_text_input',
			),
		)
	);

	$settings['icon-box-2'] = array(
		'parent' => 'homepage',
		'title' => 'Icon Box 2',
		'description' => 'this is the description 2',
		'sections' => array(
			'icon',
			'content'
		),
		'fields' => array(
			array(
				'parent' => 'icon',
				'id' => 'field-id-1-2-2',
				'label' => 'label 1-2',
				'description' => 'description 1-2',
				'type' => 'text',
				'default' => 'default 1-2',
				'placeholder' => 'placeholder 1-2',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'content',
				'id' => 'field-id-2-2-2',
				'label' => 'label 2-2',
				'description' => 'description 2-3',
				'type' => 'text',
				'default' => 'default 2-3',
				'placeholder' => 'placeholder 2-3',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'icon_box_text_field_9',
				'label' => 'Button Title',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
			array(
				'parent' => 'link',
				'id' => 'icon_box_text_field_10',
				'label' => 'Link URL',
				'description' => '',
				'type' => 'text',
				'default' => '',
				'placeholder' => '',
				'callback' => 'opt_page_sanitize_text_input',
			),
		)
	);

	return $settings;
}

/**
* Register plugin settings
*/
public function register_settings() {
		if( is_array( $this->settings ) ) {

			// get fields
			foreach( $this->settings as $section => $data ) {

				foreach( $data['fields'] as $field ) {

					// Validation callback for field
					$sanitize = '';

					if( isset( $field['callback'] ) ) {
						$sanitize = $field['callback'];
					}

					// Register field
					$option_name = $this->settings_base . $field['id'];
					register_setting( 'plugin_settings', $option_name, $sanitize );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'plugin_settings', $section, array( 'field' => $field ) );
				}
			}
		}
	}

// HTML OUTPUT

/**
* Generate HTML for displaying fields
*/
public function display_field( $fields_arr ) {
		$html = '';
		$option_name = $this->settings_base . $fields_arr['id'];
		$option = get_option( $option_name );
		$data = '';
		$type = $fields_arr['type'];

		// get the value of default if it exists
		if( isset( $fields_arr['default'] ) ) {
			$data = $fields_arr['default'];
			if( $option ) {
				$data = $option;
			}

		}
		switch( $type ) {
			case 'text':
			case 'password':
			case 'number':
				$html .= '<span class="piece-title">' . $fields_arr['label'] . '</span><input id="' . esc_attr( $fields_arr['id'] ) . '" type="' . $fields_arr['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $fields_arr['placeholder'] ) . '" value="' . $data . '"/>';
			break;

			case 'text_secret':
				$html .= '<input id="' . esc_attr( $fields_arr['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $fields_arr['placeholder'] ) . '" value=""/>';
			break;

			case 'textarea':
				$html .= '<span class="piece-title">' . $fields_arr['label'] . '</span><textarea id="' . esc_attr( $fields_arr['id'] ) . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $fields_arr['placeholder'] ) . '">' . $data . '</textarea><br/>';
			break;

			case 'checkbox':
				$checked = '';
				if( $option && 'on' == $option ){
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $fields_arr['id'] ) . '" type="' . $fields_arr['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>';
			break;

			case 'checkbox_multi':
				foreach( $fields_arr['options'] as $k => $v ) {
					$checked = false;
					if( in_array( $k, $data ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $fields_arr['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $fields_arr['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;

			case 'radio':
				foreach( $fields_arr['options'] as $k => $v ) {
					$checked = false;
					if( $k == $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $fields_arr['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $fields_arr['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;

			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $fields_arr['id'] ) . '">';
				foreach( $fields_arr['options'] as $k => $v ) {
					$selected = false;
					if( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
			break;

			case 'select_multi':
				$html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $fields_arr['id'] ) . '" multiple="multiple">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( in_array( $k, $data ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
				}
				$html .= '</select> ';
			break;

			case 'image':
				$image_thumb = '';
				if( $data ) {
					$image_thumb = wp_get_attachment_thumb_url( $data );
				}
				$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" />';
				$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="Upload an image" data-uploader_button_text="Use image" class="image_upload_button button" value="Upload new image" />';
				$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="Remove image" />';
				$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/>';
			break;

			case 'color':
				?><div class="color-picker" style="position:relative;">
			        <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
			        <div class="colorpicker"></div>
			    </div>
			    <?php
			break;

		}

		switch( $type ) {
			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $fields_arr['description'] . '</span>';
			break;
		}
		echo $html;
	}

/**
* Generate HTML for sidebar sections nav
*/
	private function build_sections_nav() {

		// icon
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" width="512" height="512"><path d="M150 0C67.2 0 0 67.2 0 150S67.2 300 150 300s150-67.2 150-150S232.8 0 150 0zM221.3 107.9l-14.2 14.2 -29-29 -11 11 29 29 -71.1 71.1 -29-29L84.9 186.3l29 29 -7.1 7.1 -0.1-0.1c-0.8 1.3-2.1 2.2-3.6 2.6l-27 6c-0.4 0.1-0.8 0.1-1.2 0.1 -1.5 0-2.9-0.6-4-1.6 -1.4-1.4-1.9-3.3-1.5-5.2l6-27c0.3-1.5 1.3-2.8 2.6-3.6l-0.1-0.1L192.3 78.9c1.7-1.7 4.4-1.7 6.1 0l22.9 22.9C223 103.5 223 106.3 221.3 107.9z"/></svg>';

		$html = '<nav class="site-section-nav">';
		$html .= '<div class="promo-section"><h1>Customizer</h1></div>';
		$html .= '<span class="nav-title">Sections</span>';
		$html .= '<ul>';

		foreach($this->parents as $i => $section) {
			if ($i === 0) {
				$html .= '<li class="active-tab">' . $svg . $section . '</li>';
			} else {
				$html .= '<li>' . $svg . $section . '</li>';
			}
		}

		$html .= '</ul>';
		$html .= '</nav>';

		return $html;
}

/**
* Generate HTML for componets
*/
private function build_componets() {
	$count = 0;
	foreach($this->parents as $site_part) {
		if ($count === 0) {
			echo '<div class="active-section site-section ' . $site_part . '-container">';
		} else {
			echo '<div class="site-section ' . $site_part . '-container">';
		}

		$this->build_tabs_nav($site_part);

		echo '<ul class="tab-panel section-' . $site_part . '">';

		foreach($this->settings as $component) {

			if ($component['parent'] === $site_part) {

				if ($count === 0) {
					echo '<li class="active-component component ' . strtolower(preg_replace('/\s+/', '-', $component['title'])) . '">';
				} else {
					echo '<li class="component ' . strtolower(preg_replace('/\s+/', '-', $component['title'])) . '">';
				}

				$this->build_component_part($component);

				echo '</li>';
			}
			$count++;
		}
		echo '</ul>';
		echo '</div>';
	}
}

/**
* Generate HTML for the tab nav
*/
  private function build_tabs_nav($site_part) {
    $html = '<nav class="tab-nav"><ul>';

		$i = 0;
    foreach( $this->settings as $section => $data ) {
			if ($data['parent'] === $site_part) {
				if ($i === 0) {
					$html .= '<li class="active-part">' . $data['title'] . '</li>';
				} else {
					$html .= '<li>' . $data['title'] . '</li>';
				}
				$i++;
			}
    }

    $html .= '</ul></nav>';

    echo $html;
  }

/**
* Generate HTML for component parts
*/
private function build_component_part($comp_arr) {

	foreach($comp_arr['sections'] as $component_part) {
		echo '<div class="input-wrapper">';
		echo '<span class="component-title">' . $component_part , '</span>';

		foreach($comp_arr['fields'] as $fields) {

			if ($fields['parent'] === $component_part) {
				$this->display_field($fields);
			}
		}
		echo '</div>';
	}

}

/**
* Build settings page
*/
  public function settings_page() {

     // Build page HTML
    $html = '<div id="dpi-opt-page">';
		$html .= $this->build_sections_nav();

		// begin form
    $html .= '<form class="opt-page-form" method="post" action="options.php" enctype="multipart/form-data">';
		$html .= '<nav class="top-nav"></nav>';

    // Get settings fields
		ob_start();
    echo '<div class="tab-panel-container">';
    settings_fields( 'plugin_settings' );
		$this->build_componets();
    echo '</div>';
    $html .= ob_get_clean();

    // submit and closing tags
    $html .= '<div class="submit-form">';
    $html .= '<input name="Submit" type="submit" class="submit-btn" value="Save Settings" />' . "\n";
    $html .= '</div>';
    $html .= '</form>';
    $html .= '</div>';

    echo $html;
  }

}

if ( is_admin() )
	$homepage_customizer_opt = new Custom_Options_Page();

function opt_page_sanitize_text_input($input) {
	$output = sanitize_text_field($input);
	return $output;
}
