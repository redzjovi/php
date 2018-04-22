<?php

namespace redzjovi\php;

class JsonHelper
{
    public static function isValidJson($strJson)
    {
        json_decode($strJson);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
