<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit933d70d42ef341c1c1c02f8c43031df1
{
    public static $files = array (
        '5fa24b36609c517d4317b7afb5c92511' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/plugin-update-checker.php',
    );

    public static $classMap = array (
        'DPI_CAL_Calendar' => __DIR__ . '/../..' . '/classes/DPI_CAL_Calendar.php',
        'DPI_CAL_Events' => __DIR__ . '/../..' . '/classes/DPI_CAL_Events.php',
        'DPI_CAL_Plugin_Page' => __DIR__ . '/../..' . '/classes/DPI_CAL_Plugin_Page.php',
        'DPI_CAL_Shortcodes' => __DIR__ . '/../..' . '/classes/DPI_CAL_Shortcodes.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit933d70d42ef341c1c1c02f8c43031df1::$classMap;

        }, null, ClassLoader::class);
    }
}
