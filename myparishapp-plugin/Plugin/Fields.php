<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Fields {

    /**
    * Facade around field creation methods
    * @param{array} $args
    * @return function
    */
    public function createField(Array $args) {
        switch($args['type']) {
            case 'radio':
                return $this->radioField($args);
            case 'checkbox':
                return $this->checkBoxField($args);
            case 'number':
                return $this->numberField($args);
            case 'select':
                return $this->selectField($args);
            case 'textarea':
                return $this->textAreaField($args);
            case 'color':
                return $this->colorField($args);
            default:
                return $this->textField($args);
        }
    }

    /**
    * Generate the markup for a radio button
    * @param{array} $args
    * @return string
    */
    private function radioFields(Array $args) {
        $default = array_key_exists('on', $args) && $args['on'] === true ? 'checked' : false;
        $on = !empty(get_option($args['id'])) && get_option($args['id']) === 'on' ? 'checked' : '';

        return '
            <input 
                type="' . $args['type'] . '" 
                id="' . $args['id'] . '" 
                name="' . $args['id'] . '"
                ' . (empty($on) && $default ? $default : $on) . ' 
            />
        ';
    }

    /**
    * Generate the markup for a checkbox
    * @param{array} $args
    * @return string
    */
    private function checkBoxField(Array $args) {
        $default = array_key_exists('checked', $args) && $args['checked'] === true ? 'checked' : false;
        $checked = !empty(get_option($args['id'])) && get_option($args['id'] === 'on') ? 'checked' : '';

        return '
            <input 
                type="' . $args['type'] . '"
                id="' . $args['id'] . '"
                name="' . $args['id'] . '"
                ' . (empty($checked) && $default) ? $default : $checked . '
            />
        ';
    }

    /**
    * Generate the markup for a number field
    * @param{array} $args
    * @return string
    */
    private function numberField(Array $args) {
        $min = is_numeric($args['min']) ? 'min="' . $args['min'] . '"' : '';
        $max = is_numeric($args['max']) ? 'max="' . $args['max'] . '"' : '';
        $value = is_numeric($args['default']) && empty(get_option($args['id'])) ? $args['default'] : get_option($args['id']);

        return '
            <input
                type="number"
                id="' . $args['id'] . '"
                name="' . $args['id'] . '"
                ' . $min . '
                ' . $max . '
                value="' . $value . '"
            />
        ';
    }

    /**
    * Generate the markup for a select field
    * @param{array} $args
    * @return string
    */
    private function selectField(Array $args) {
        $default = array_key_exists('default', $args) ? $args['default'] : false;
        $selected = get_option($args['id']);

        $select = '<select id="' . $args['id'] . '" name="' . $args['id'] . '">';

        foreach($args['options'] as $k => $v) {
            $select .= '<option ' . ($selected === $k || empty($selected) && $default === $k ? "selected" : "") . ' value="' . $k . '">' . $v . '</option>';
        }

        return $select . '</select>';
    }

    /**
    * Generate the markup for a textarea
    * @param{array} $args
    * @return string
    */
    private function textAreaField(Array $args) {
        $default = array_key_exists('default', $args) ? $args['default'] : false;
        $value = !empty(get_option($args['id'])) ? get_option($args['id']) : '';

        return '
            <textarea id="' . $args['id'] . '" name="' . $args['id'] . '">
                ' . (empty($value) && $default ? $default : $value) . '
            </textarea>
        ';
    }

    /**
    * Generate the markup for a text field
    * @param{array} $args
    * @return string
    */
    private function textField(Array $args) {
        $default = array_key_exists('default', $args) ? $args['default'] : false;
        $value = !empty(get_option($args['id'])) ? get_option($args['id']) : '';

        return '
            <input 
                type="' . $args['type'] . '" 
                id="' . $args['id'] . '"
                name="' . $args['id'] . '"
                value="' . (empty($value) && $default ? $default : $value) . '"
            />
        ';
    }

    /**
    * Generate the markup for a color field
    * @param{array} $args
    * @return string
    */
    private function colorField(Array $args) {
        $default = array_key_exists('default', $args) ? $args['default'] : false;
        $value = !empty(get_option($args['id'])) ? get_option($args['id']) : '';

        return '
            <input 
                type="text" 
                id="' . $args['id'] . '"
                name="' . $args['id'] . '"
                class="dpiPluginPage__color"
                value="' . (empty($value) && $default ? $default : $value) . '"
            />
        ';
    }
}