<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRepository {

    public static function get($year) {
        $sql = <<<EOF
SELECT
    date,
    name,
    location,
    SUM(score) AS score
FROM submissions
INNER JOIN shows ON submissions.show_id = shows.id
INNER JOIN venues ON venue_id = venues.id
WHERE strftime("%Y", shows.date) = ?
GROUP BY date
ORDER BY score DESC
EOF;

        $response = DB::select($sql, [$year]);
        return $response;
    }

    public static function getAll(Request $request) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT
    date,
    name,
    location,
    SUM(score) AS score
FROM submissions
INNER JOIN shows ON submissions.show_id = shows.id
INNER JOIN venues ON venue_id = venues.id
WHERE strftime("%Y", shows.date) > 1982
GROUP BY date
ORDER BY score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$limit, $start]);
        return $response;
    }

    public static function getShowRanking($date) {
        $sql = <<<EOF
SELECT
    date,
    name,
    location,
    SUM(score) AS score
FROM submissions
INNER JOIN shows ON submissions.show_id = shows.id
INNER JOIN venues ON venue_id = venues.id
WHERE shows.date = ?
GROUP BY date
ORDER BY score DESC
EOF;

        $response = DB::select($sql, [$date]);
        return $response;
    }
}
