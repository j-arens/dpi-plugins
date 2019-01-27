<?php namespace DpiTabs\core;

interface LoaderInterface {
    
    public function enqueueStyle(array $stylesheet);

    public function enqueueScript(array $script);
    
}