<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SongRepository;
use App\Song;

class SongsController extends Controller
{
    public function getAllSongs() {
        $songs = Song::orderBy('slug')->get();
        return json_encode($songs);
    }

    public function getSongById($id) {
        $song = Song::findOrFail($id);
        return json_encode($song);
    }

    public function getSongBySlug($slug) {
        $song = Song::where('slug', $slug)->first();
        return json_encode($song);
    }

    public function getRankings(Request $request) {
        $songs = SongRepository::getAll($request);
        return json_encode($songs);
    }

    public function getRankingsBySlug($slug) {
        $song = SongRepository::get($slug);
        return json_encode($song);
    }
}
