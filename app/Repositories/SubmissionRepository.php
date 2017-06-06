<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionRepository {

    public static function getSubmissionById($id) {
        $sql = <<<EOF
SELECT
        songs.title AS song_title,
        songs.slug AS song_slug,
        submissions.id AS submission_id,
        submissions.description AS description,
        shows.date AS show_date,
        venues.name AS venue_name,
        venues.location AS venue_location,
        users.username AS username,
        users.image AS user_image,
        submissions.score AS submission_score
    FROM submissions
    INNER JOIN songs
        ON submissions.song_id = songs.id
    INNER JOIN shows
        ON submissions.show_id = shows.id
    INNER JOIN venues
        ON shows.venue_id = venues.id
    INNER JOIN users
        ON submissions.user_id = users.id
    WHERE submissions.id = ?
EOF;

        $response = DB::select($sql, [$id]);
        return $response;
    }

    public static function getSubmissionsBySlug(Request $request, $slug) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT
        songs.title AS song_title,
        songs.slug AS song_slug,
        submissions.id AS submission_id,
        submissions.description AS description,
        shows.date AS show_date,
        venues.name AS venue_name,
        venues.location AS venue_location,
        users.username AS username,
        users.image AS user_image,
        submissions.score AS submission_score
    FROM submissions
    INNER JOIN songs
        ON submissions.song_id = songs.id
    INNER JOIN shows
        ON submissions.show_id = shows.id
    INNER JOIN venues
        ON shows.venue_id = venues.id
    INNER JOIN users
        ON submissions.user_id = users.id
    WHERE songs.slug = ?
    ORDER BY submissions.score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$slug, $limit, $start]);
        return $response;
    }

    public static function getSubmissionsByUserId(Request $request, $userId) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT
        songs.title AS song_title,
        songs.slug AS song_slug,
        submissions.id AS submission_id,
        submissions.description AS description,
        shows.date AS show_date,
        venues.name AS venue_name,
        venues.location AS venue_location,
        users.username AS username,
        users.image AS user_image,
        submissions.score AS submission_score
    FROM submissions
    INNER JOIN songs
        ON submissions.song_id = songs.id
    INNER JOIN shows
        ON submissions.show_id = shows.id
    INNER JOIN venues
        ON shows.venue_id = venues.id
    INNER JOIN users
        ON submissions.user_id = users.id
    WHERE users.id = ?
    ORDER BY submissions.score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$userId, $limit, $start]);
        return $response;
    }

    public static function getSubmissionsByUserName(Request $request, $username) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT
        songs.title AS song_title,
        songs.slug AS song_slug,
        submissions.id AS submission_id,
        submissions.description AS description,
        shows.date AS show_date,
        venues.name AS venue_name,
        venues.location AS venue_location,
        users.username AS username,
        users.image AS user_image,
        submissions.score AS submission_score
    FROM submissions
    INNER JOIN songs
        ON submissions.song_id = songs.id
    INNER JOIN shows
        ON submissions.show_id = shows.id
    INNER JOIN venues
        ON shows.venue_id = venues.id
    INNER JOIN users
        ON submissions.user_id = users.id
    WHERE users.username = ?
    ORDER BY submissions.score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$username, $limit, $start]);
        return $response;
    }

    public static function getRankingsByDate($date) {
        $sql = <<<EOF
SELECT
        songs.title AS song_title,
        songs.slug AS song_slug,
        submissions.id AS submission_id,
        submissions.description AS description,
        shows.date AS show_date,
        venues.name AS venue_name,
        venues.location AS venue_location,
        users.username AS username,
        users.image AS user_image,
        submissions.score AS submission_score
    FROM submissions
    INNER JOIN songs
        ON submissions.song_id = songs.id
    INNER JOIN shows
        ON submissions.show_id = shows.id
    INNER JOIN venues
        ON shows.venue_id = venues.id
    INNER JOIN users
        ON submissions.user_id = users.id
    WHERE shows.date = ?
    ORDER BY submissions.score DESC
EOF;

        $response = DB::select($sql, [$date]);
        return $response;
    }

    public static function getRecentSubmissions() {
        $sql = <<<EOF
SELECT
    submissions.id AS submission_id,
    submissions.description AS description,
    songs.title AS title,
    songs.slug AS slug,
    shows.date AS date
FROM submissions
LEFT JOIN songs
    ON submissions.song_id = songs.id
LEFT JOIN shows
    ON submissions.show_id = shows.id
ORDER BY submissions.id DESC LIMIT 5
EOF;

        $response = DB::select($sql);
        return $response;
    }

    public static function saveSubmission(Request $request) {
        $song_id      = $request->input('song_id');
        $show_id      = $request->input('show_id');
        $description  = $request->input('description');
        $user_id      = $request->input('user_id');
        $score        = $request->input('score');

        $id = DB::table('submissions')->insertGetId(
            [
                'song_id'     => $song_id,
                'show_id'     => $show_id,
                'description' => $description,
                'user_id'     => $user_id,
                'score'       => $score
            ]
        );

        return $id;
    }

    public static function saveSubmissionScore(Request $request) {
        $submission_id  = $request->input('submission_id');
        $score          = $request->input('score');

        $response = DB::table('submissions')->where('id', $submission_id)
                                ->update([
                                  'score' => $score
                                ]);

        return $response;
    }
}
