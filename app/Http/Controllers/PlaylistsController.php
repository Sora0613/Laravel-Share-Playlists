<?php

namespace App\Http\Controllers;

use App\Facades\MusicService;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class PlaylistsController extends Controller
{
    public function index()
    {
        return view('playlists.index');
    }
}
