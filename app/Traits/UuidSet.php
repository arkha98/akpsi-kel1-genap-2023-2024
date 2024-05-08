<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait UuidSet
{
    // public $incrementing = false;
    // protected $keyType = 'string';
    // protected $hidden = ['password', 'created_at', 'created_by'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::orderedUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    // public function getHidden() 
    // {
    //     return ['password', 'created_at', 'created_by'];
    // }
}
