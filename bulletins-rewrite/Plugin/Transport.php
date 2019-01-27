<?php namespace Bulletins\Plugin;

// prevent direct access
if ( !defined( 'ABSPATH' ) ) exit;

class Transport {

    private $domain = 'http://bulletins.discovermass.com';

    /**
    * Get bulletin & cover links from discovermass, format into an array
    * mcrypt is mostly deprecated in php 7, must refactor this process before upgrading php!
    */
    private function buildLinks($id, $date) {
        $timestamp = time();
        $key = pack( "H*", "69F693BA89D7224C932A292D14A6262813DA4B443A95F233DBB25E132B4E7E8F" );
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
        $plainText = "{$id}|{$date}|{$timestamp}";
        $cipherText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_CBC, $iv);
        $cipherText = rawurlencode(base64_encode($iv . $cipherText));

        return [
            'bulletin' => $this->domain . '/download.php?bulletin=' . $cipherText,
            'cover' => $this->domain . '/image.php?bulletin=' . $cipherText
        ];
    }

    /**
    * Retrieve bulletin dates and links, format into an array
    */
    public function getBulletins($id, $quantity = 1) {
        if (!$id) {
            return trigger_error('A valid ID must be passed to ' . __METHOD__ . ' in ' . __CLASS__ . '!', E_USER_ERROR);
        }

        $res = wp_remote_get($this->domain . '/list.php?folder=' . $id . '&quantity=' . $quantity);

        if (!is_wp_error($res)) {
            $dates = array_flip(json_decode($res['body'], true));

            return array_map(function($date) use($id) {

                return [
                    'date' => $date,
                    'links' => $this->buildLinks($id, $date)
                ];

            }, $dates);
        }

        return false;
    }
}