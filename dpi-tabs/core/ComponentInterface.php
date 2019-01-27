<?php namespace DpiTabs\core;

interface ComponentInterface {

    function handleError($msg);

    function loadAssets();

    function render($attrs, $content);

}