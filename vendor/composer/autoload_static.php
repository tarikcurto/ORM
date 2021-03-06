<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbf18d9a7556718abd14fe04f67670a47
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'League\\Plates\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'League\\Plates\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/plates/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbf18d9a7556718abd14fe04f67670a47::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbf18d9a7556718abd14fe04f67670a47::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
