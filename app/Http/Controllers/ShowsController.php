<?php

namespace App\Http\Controllers;

use App\Repositories\ShowRepository;
use App\Repositories\YearRepository;
use App\Show;
use Illuminate\Http\Request;

class ShowsController extends Controller
{
    public function getAllShows() {
        $shows = Show::all();
        return json_encode($shows);
    }

    public function getShowById($id) {
        $show = Show::where('id', '=', $id)->first();
        return json_encode($show);
    }

    public function getShowByDate($date) {
        $show_date = Show::where('date', '=', $date)->first();
        return json_encode($show_date);
    }

    public function getShowRankings($year) {
        $shows = ShowRepository::get($year);
        return json_encode($shows);
    }

    public function getAllShowRankings(Request $request) {
        $shows = ShowRepository::getAll($request);
        return json_encode($shows);
    }

    public function getAllYearRankings() {
        $years = YearRepository::getAll();
        return json_encode($years);
    }

    public function getYearRanking($year) {
        $response = YearRepository::get($year);
        return json_encode($response);
    }

    public function getShowRanking($date) {
        $response = ShowRepository::getShowRanking($date);
        return json_encode($response);
    }
}
