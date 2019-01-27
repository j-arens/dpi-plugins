<?php namespace DpiTabs\core;

interface ShortcodeParserInterface {
    
    function getMatches($shortcode, $content);

    function pluckAttribute($attrName, $attrs);

}