<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_name',
        'playlist_description',
        'user_id',
        'is_private',
        'playlist_cover',
    ];

    public function updatePlaylist(Array $params, $id)
    {
        $playlist = Playlist::find($id);

        if(!$playlist){
            abort(404);
        }

        $is_private = $params['is_private'] ?? false;

        $updateData = [
            'playlist_name' => $params['playlist_name'] ?? $playlist->playlist_name,
            'playlist_description' => $params['playlist_description'] ?? $playlist->playlist_description,
            'is_private' => $is_private,
        ];

        if ($params['playlist_name'] !== $playlist->playlist_name ||
            $params['playlist_description'] !== $playlist->playlist_description ||
            $is_private !== $playlist->is_private) {

            if (isset($params['playlist_cover'])) {
                $file_name = $params['playlist_cover']->store('public/playlist_cover/');
                $updateData['playlist_cover'] = basename($file_name);
            }

            $playlist->update($updateData);
        }
    }

    public function getAuthorName($user_id)
    {
        return User::find($user_id)->name;
    }
}
