<?php

namespace App\Http\Controllers;

use App\Repositories\SearchRepository;

class SearchController extends Controller
{
    public function searchSongs($songname) {
        $songs = SearchRepository::searchSongs($songname);
        return json_encode($songs);
    }

    public function searchShows($showdate) {
        $shows = SearchRepository::searchShows($showdate);
        return json_encode($shows);
    }

    public function searchYears($year) {
        $years = SearchRepository::searchYears($year);
        return json_encode($years);
    }

    public function searchUsers($username) {
        $users = SearchRepository::searchUsers($username);
        return json_encode($users);
    }
}
