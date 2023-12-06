<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class MusicService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MusicService';
    }
}
