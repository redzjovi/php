<?php

namespace redzjovi\php;

class UrlHelper
{
    public static function isRelative($url)
    {
        return strncmp($url, '//', 2) && strpos($url, '://') === false;
    }
}
