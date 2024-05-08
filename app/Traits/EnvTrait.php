<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait EnvTrait
{
    public static function getEnvAppEnv()
    {
        return env('APP_ENV');
    }

    public static function getEnvAppUrl()
    {
        return env('APP_URL');
    }

    public static function getEnvUploadPublicPathProd()
    {
        return env('PROD_PUBLIC_UPLOAD_PATH');
    }
}
