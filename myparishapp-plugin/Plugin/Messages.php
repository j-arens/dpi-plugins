<?php namespace MyParishApp\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Messages {

    use PreFlight;

    private $authKey;
    private $postTypeName;
    private $apiEndpoint;
    private $eventName;

    /**
    * Set the authkey prop
    * @param{string/boolean} $key
    */
    public function setAuthKey($key) {
        if ($this->compareType('string', $key) || compareType('boolean', $key)) {
            $this->authKey = $key;
        } else {
            $this->invalidType('string', $str);
            return false;
        }
    }

    /**
    * Set the postTypeName prop
    * @param{string} $str
    */
    public function setPostTypeName($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->postTypeName = $str;
    }

    /**
    * Set the apiEndpoint prop
    * @param{string} $str
    */
    public function setApiEndpoint($str) {
        if (!$this->compareType('string', $str)) {
            $this->invalidType('string', $str);
            return false;
        }

        $this->apiEndpoint = $str;
    }

    /**
    * set the eventName prop
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
    * Startup
    */
    public function init() {
        if ($this->allPropsSet()) {
            $this->createPostType();
            add_action($this->eventName, [$this, 'sync']);
        }
    }

    /**
    * Register new custom post type for messages if it doesn't already exist
    */
    private function createPostType() {
        if (!post_type_exists($this->postTypeName)) {
            register_post_type($this->postTypeName, [
                'public' => true,
                'exclude_from_search' => true,
                'publicly_queryable' => true,
                'show_ui' => false,
                'show_in_nav_menus' => true,
                'show_in_menu' => false,
                'show_in_admin_bar' => false,
                'has_archive' => true
            ]);
        }
    }

    /**
    * Fetch remote messages from endpoint
    * @return boolean/array
    */
    private function getRemoteMessages() {
        $req = wp_remote_get($this->apiEndpoint . $this->authKey, ['timeout' => 5]);
        
        if (!is_wp_error($req)) {
            $res = json_decode(wp_remote_retrieve_body($req));
            
            if (empty($res)) {
                return [];
            }

            return $res;
        }

        return false;
    }

    /**
    * Fetch local messages from database
    * @return array
    */ 
    private function getLocalMessages() {
        return get_posts([
            'post_type' => $this->postTypeName,
            'post_status' => ['publish', 'future', 'pending', 'trash'],
            'numberposts' => -1
        ]);
    }

    /**
    * Get an array of local message ID's
    * @param{array} $localMessages
    * @return array
    */
    private function getLocalMessageIDs(Array $localMessages) {
        return array_map(function($message) {
            return intval(get_post_meta($message->ID, 'myparishapp_message_id', true));
        }, $localMessages);
    }

    /**
    * Get an array of remote message ID's
    * @param{array} $remoteMessages
    * @return array
    */
    private function getRemoteMessageIDs(Array $remoteMessages) {
        return array_map(function($message) {
            return intval($message->id);
        }, $remoteMessages);
    }

    /**
    * Diff remote and local messages
    * @param{array} $localMessages
    * @param{array} $remoteMessages
    */
    private function sortMessages(Array $localMessages, Array $remoteMessages) {
        $localMessageIDs = $this->getLocalMessageIDs($localMessages);
        $remoteMessageIDs = $this->getRemoteMessageIDs($remoteMessages);

        // 1. Get all of the unique id's from localMessages and remoteMessages
        // 2. Loop over each unique id
        // 3. If the unique id is from remoteMessages, assume it's a new message, add it to the database
        // 4. If the unique id is from localMessages, assume this message has been deleted from the app, delete this message from the database
        $uniqueIDs = array_merge(
            array_diff($localMessageIDs, $remoteMessageIDs),
            array_diff($remoteMessageIDs, $localMessageIDs)
        );

        foreach($uniqueIDs as $id) {

            if (in_array($id, $remoteMessageIDs)) {
                $message = array_filter($remoteMessages, function($message) use($id) {
                    return ($message->id === $id);
                });

                $this->insertMessage(array_shift($message));
            }

            if (in_array($id, $localMessageIDs)) {
                // getting a crazy array to string conversion error
                // might be related to this https://core.trac.wordpress.org/ticket/30013
                // $query = new WP_Query([
                //     'post_type' => $this->postTypeName,
                //     'meta_key' => 'myparishapp_message_id',
                //     'meta_value' => $id
                // ]);

                // wp_delete_post($query->posts[0]->ID, true);
                
                $message = array_filter($localMessages, function($message) use($id) {
                    return (intval(get_post_meta($message->ID, 'myparishapp_message_id', true)) === $id);
                });

                wp_delete_post(array_shift($message)->ID, true);
            }
        }
    }

    /**
    * Insert a message into the database
    * @param{object} $message
    */
    private function insertMessage($message) {
        wp_insert_post([
            'post_type' => $this->postTypeName,
            'post_date' => $message->date,
            'post_date_gmt' => $message->date,
            'post_title' => 'myParishApp Message: ' . date('m/d/Y g:ia', strtotime($message->date)),
            'post_content' => $message->text,
            'post_status' => 'publish',
            'meta_input' => [
                'myparishapp_message_id' => $message->id
            ]
        ]);
    }

    /**
    * Entry point for fetching, sorting, and inserting or deleting messages
    */
    public function sync() {
        $localMessages = $this->getLocalMessages();
        $remoteMessages = $this->getRemoteMessages();

        if (gettype($remoteMessages) !== 'array') return;

        // assume all new messages, add all remoteMessages to the database
        if (empty($localMessages) && !empty($remoteMessages)) {

            foreach($remoteMessages as $message) {
                $this->insertMessage($message);
            }

        // assume all remote messages have been deleted, remove all local messages
        } else if (!empty($localMessages) && empty($remoteMessages)) {

            foreach($localMessages as $message) {
                wp_delete_post($message->ID, true);
            }

        // otherwise diff messages
        } else if (!empty($localMessages) && !empty($remoteMessages)) {
            $this->sortMessages($localMessages, $remoteMessages);
        }
    }
}