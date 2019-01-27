<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

trait PreFlight {

    /**
    * Check if a value is of a certain type
    * @param{string} $expected
    * @param{*} $actual
    * @return boolean
    */
    public function compareType($expected, $actual) {
        return (gettype($actual) === $expected);
    }

    /**
    * Trigger an invalid type error
    * @param{string} $expected
    * @param{*} $actual
    * @return boolean
    */
    public function invalidType($expected, $actual) {
        return trigger_error(
            'TYPE ERROR AT: ' . debug_backtrace()[1]['function'] . ' expects a(n) ' . $expected . '. You passed a(n) ' . gettype($actual) . '.',
            E_USER_ERROR
        );
    }

    /**
    * Check if certain class props are set
    * @param{array} $props
    * @return boolean
    */
    public function somePropsSet(Array $props) {
        $notSet = array_filter($props, function($prop) {
            return !isset($this->$prop);
        });

        if (empty($notSet)) {
            return true;
        }

        trigger_error(
            'You must set the properties [' . implode(', ', $notSet) . '] in ' . __CLASS__ . ' before calling ' . debug_backtrace()[1]['function'] . '.',
            E_USER_ERROR
        );

        return false;
    }

    /**
    * Check if all class props are set
    * @return boolean
    */
    public function allPropsSet() {
        if (count(get_object_vars($this)) === count(array_filter(get_object_vars($this)))) {
            return true;
        }

        trigger_error(
            'You must set the properties [' . implode(', ', array_keys(get_object_vars($this))) . '] in ' . __CLASS__ . ' before calling ' . debug_backtrace()[1]['function'] . '.',
            E_USER_ERROR
        );

        return false;
    }
}