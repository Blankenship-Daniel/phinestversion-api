<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchRepository {
    public static function searchSongs($song) {
        $sql = <<<EOF
SELECT
    submissions.song_id AS song_id,
    title,
    slug,
    tracks_count,
    SUM(score) as score
FROM submissions
INNER JOIN songs ON submissions.song_id = songs.id
WHERE songs.title LIKE ?
GROUP BY title
ORDER BY score DESC
EOF;

        $response = DB::select($sql, ['%' . $song . '%']);
        return $response;
    }

    public static function searchShows($date) {
        $sql = <<<EOF
SELECT
    date,
    name,
    location,
    SUM(score) AS score
FROM submissions
INNER JOIN shows ON submissions.show_id = shows.id
INNER JOIN venues ON venue_id = venues.id
WHERE strftime("%Y", shows.date) > 1982 AND shows.date LIKE ?
GROUP BY date
ORDER BY score DESC
EOF;

        $response = DB::select($sql, ['%' . $date . '%']);
        return $response;
    }

    public static function searchYears($year) {
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
    WHERE strftime("%Y", shows.date) > 1982 AND strftime("%Y", shows.date) LIKE ?
    GROUP BY date
    ORDER BY score DESC) rankings
GROUP BY year
ORDER BY year_score DESC
EOF;

        $response = DB::select($sql, ['%' . $year . '%']);
        return $response;
    }

    public static function searchUsers($username) {
        $sql = <<<EOF
SELECT
    users.id AS user_id,
    users.image AS user_image,
    users.username AS username,
    SUM(submissions.score) AS score
FROM users
INNER JOIN submissions ON submissions.user_id = users.id
WHERE users.username LIKE ?
GROUP BY user_id
ORDER BY score DESC
EOF;

        $response = DB::select($sql, ['%' . $username . '%']);
        return $response;
    }
}
