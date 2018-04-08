<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitffa6768526ed323e56406cff2ea8f0a8
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WebArticleExtractor\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WebArticleExtractor\\' => 
        array (
            0 => __DIR__ . '/..' . '/zackslash/php-web-article-extractor/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitffa6768526ed323e56406cff2ea8f0a8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitffa6768526ed323e56406cff2ea8f0a8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}