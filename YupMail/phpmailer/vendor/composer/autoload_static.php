<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit76baa33a92b26fb6d9f99b01bec4ee2b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit76baa33a92b26fb6d9f99b01bec4ee2b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit76baa33a92b26fb6d9f99b01bec4ee2b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
