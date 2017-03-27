<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class YearRepository {

    public static function getAll() {
        $sql = <<<EOF
SELECT 
    strftime("%Y", rankings.date) AS year,
    SUM(rankings.score) AS year_score
FROM (SELECT 
        date, 
        name, 
        location,
        SUM(score) AS score
    FROM submissions
    INNER JOIN shows ON submissions.show_id = shows.id
    INNER JOIN venues ON venue_id = venues.id
    WHERE strftime("%Y", shows.date) > 1982
    GROUP BY date 
    ORDER BY score DESC) rankings
GROUP BY year
ORDER BY year_score DESC
EOF;

        $response = DB::select($sql);
        return $response;
    }

    public static function get($year) {
        $sql = <<<EOF
SELECT
    year,
    year_score
    FROM (SELECT 
        strftime("%Y", rankings.date) AS year,
        SUM(rankings.score) AS year_score
    FROM (SELECT 
            date, 
            name, 
            location,
            SUM(score) AS score
        FROM submissions
        INNER JOIN shows ON submissions.show_id = shows.id
        INNER JOIN venues ON venue_id = venues.id
        WHERE strftime("%Y", shows.date) > 1982
        GROUP BY date 
        ORDER BY score DESC) rankings
    GROUP BY year
    ORDER BY year_score DESC)
WHERE year = ?
EOF;

        $response = DB::select($sql, [$year]);
        return $response;
    }
}