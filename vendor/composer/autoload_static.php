<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2dbcf213bdad5537a838447393fec989
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Ibrahimcadirci\\VirtualPos\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ibrahimcadirci\\VirtualPos\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2dbcf213bdad5537a838447393fec989::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2dbcf213bdad5537a838447393fec989::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2dbcf213bdad5537a838447393fec989::$classMap;

        }, null, ClassLoader::class);
    }
}
