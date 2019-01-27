<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Cron {

    use PreFlight;

    private $eventName;
    private $intervalName;
    private $intervalSeconds;

    /**
    * Set the eventName prop
    * @param{string} $str
    */
    public function setEventName($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->eventName = $str;
    }

    /**
    * Set the intervalName & intervalSeconds props
    * @param{string} $str
    * @param{integer} $int
    */
    public function setInterval($str, $int) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        if (!$this->compareType('integer', $int)) {
            $this->invalidType('integer', $int);
            return false;
        }

        $this->intervalName = $str;
        $this->intervalSeconds = $int;
    }

    /**
    * Startup
    */
    public function init() {
        if ($this->allPropsSet()) {
            register_deactivation_hook(MYPARISHAPP_ROOT, [$this, 'removeScheduledEvent']);
            add_filter('cron_schedules', [$this, 'addInterval']);
            $this->scheduleEvent();
        }
    }

    /**
    * Add an interval to wp if it doesn't already exist
    * @param{object} $schedules
    * @return object
    */
    public function addInterval($schedules) {
        if (!isset($schedules[$this->intervalName])) {
            $schedules[$this->intervalName] = [
                'interval' => $this->intervalSeconds,
                'display' => $this->intervalName
            ];
        }

        return $schedules;
    }

    /**
    * Schedule a cron event with wp if it doesn't already exist 
    */
    public function scheduleEvent() {
        if (!wp_get_schedule($this->eventName)) {
            wp_schedule_event(time('now') + 1, $this->intervalName, $this->eventName);
        }
    }

    /**
    * Remove a cron event from wp
    */
    public function removeScheduledEvent() {
        wp_clear_scheduled_hook($this->eventName);
    }
}