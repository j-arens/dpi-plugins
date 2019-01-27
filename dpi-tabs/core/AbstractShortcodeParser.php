<?php namespace DpiTabs\core;

abstract class AbstractShortcodeParser implements ShortcodeParserInterface {
    
    /**
     * Parse content for shortcode and return formatted matches
     * 
     * @param string $shortcode
     * @param string $content
     * @return array
     */
    public function getMatches($shortcode, $content) {
        $pattern = get_shortcode_regex([$shortcode]);
        preg_match_all("/$pattern/", trim($content), $matches);

        if (empty($matches)) {
            return [];
        }

        return array_map(function($key) use($shortcode, $matches) {
            return [
                'shortcode' => $shortcode,
                'attributes' => $matches[3][$key],
                'content' => $matches[5][$key],
            ];
        }, array_keys($matches[2]));
    }

    /**
     * Pluck an attribute and its value from a string of attributes
     * 
     * @param string $attrName
     * @param string $attrs
     */
    public function pluckAttribute($attrName, $attrs) {
        if ($attrName === '' || $attrs === '') {
            return [];
        }

        $pattern = "(?<={$attrName}=\")(.+?)(?=\")";
        preg_match("/$pattern/", $attrs, $matches);

        if (empty($matches)) {
            return [];
        }

        return [$attrName => $matches[0]];
    }

} 