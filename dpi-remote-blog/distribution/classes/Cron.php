<?php namespace DPI_Blog\Classes;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Cron {

    private $hook;
    private $intervalKey;
    private $intervalSeconds;

    /**
    * Set the key for the cron job
    */
    public function setHook($str) {
        if (gettype($str) === 'string') {
            $this->hook = $str;
        } else {
            throw new \Exception('DPI_BLOG_CRON: setHook expects a string. You passed a(n)' . gettype($str) . '.');
            return false;
        }
    }

    /**
    * Set the interval key and seconds
    */
    public function setInterval($str, $seconds) {
        if (gettype($str) === 'string' && gettype($seconds) === 'integer') {
            $this->intervalKey = $str;
            $this->intervalkey = $seconds;
        } else {
            throw new \Exception('DPI_BLOG_CRON: You passed in invalid parameter to setInterval. The first paramter must be a string, and the second parameter must be a number.');
            return false;
        }
    }

    /**
    * Startup
    */
    public function init() {
        if (count(array_filter(get_object_vars($this))) === 3) {
            register_deactivation_hook(DPI_BLOG_ROOT, [$this, 'removeScheduledEvent']);
            add_filter('cron_schedules', [$this, 'addInterval']);
            $this->scheduleEvent();
        } else {
            throw new \Exception('DPI_BLOG_CRON: You must set the $hook and $interval before running init!');
            return false;
        }
    }

    /**
    * Add the set interval to cron schedules if it doesn't already exist
    */
    public function addInterval($schedules) {
        if (!isset($schedules[$this->intervalKey])) {
            $schedules['daily'] = [
                'interval' => $this->intervalSeconds,
                'display' => __($this->intervalKey)
            ];
        }

        return $schedules;
    }

    /**
    * Schedule cron job with wp
    */
    private function scheduleEvent() {
        if (!wp_get_schedule($this->hook)) {
            wp_schedule_event(time('now') + 1, $this->intervalKey, $this->hook);
        }
    }

    /**
    * Remove the cron job when the plugin is deactivated
    */
    public function removeScheduledEvent() {
        wp_clear_scheduled_hook($this->hook);
    }
}