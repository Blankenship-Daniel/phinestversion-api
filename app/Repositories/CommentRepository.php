<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentRepository {

    public static function getCommentById($id) {
        $sql = <<<EOF
SELECT
    comments.id AS id,
    comments.submission_id AS submission_id,
    comments.comment AS comment,
    comments.created_at AS created_at,
    users.id AS user_id,
    users.username AS username,
    users.image AS user_image
    FROM comments
    INNER JOIN users
        ON comments.user_id = users.id
    WHERE comments.id = ?
EOF;

        $response = DB::select($sql, [$id]);
        return $response;
    }

    public static function getCommentsBySubmissionIdCount($submissionId) {
        $sql = <<<EOF
SELECT
    COUNT(*) AS size
    FROM comments
    INNER JOIN users
        ON comments.user_id = users.id
    WHERE submission_id = ?
EOF;

        $response = DB::select($sql, [$submissionId]);
        return $response;
    }

    public static function getCommentsBySubmissionId(Request $request, $submissionId) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT * FROM (
    SELECT
        comments.id AS id,
        comments.submission_id AS submission_id,
        comments.comment AS comment,
        comments.created_at AS created_at,
        users.id AS user_id,
        users.username AS username,
        users.image AS user_image
        FROM comments
        INNER JOIN users
            ON comments.user_id = users.id
        WHERE submission_id = ?
    ORDER BY id DESC
    LIMIT ?
    OFFSET ?
) c
ORDER BY c.id ASC
EOF;

        $response = DB::select($sql, [$submissionId, $limit, $start]);
        return $response;
    }

    public static function getRecentComments() {
        $sql = <<<EOF
SELECT
    songs.slug as slug,
    songs.title as title,
    users.username as username,
    submission_id,
    comment,
    comments.created_at as created_at,
    shows.date as date
FROM comments
    LEFT JOIN submissions
        ON comments.submission_id = submissions.id
    LEFT JOIN songs
        ON songs.id = submissions.song_id
    LEFT JOIN users
        ON users.id = submissions.user_id
    LEFT JOIN shows
        ON shows.id = submissions.show_id
    ORDER BY comments.created_at DESC LIMIT 5
EOF;

        $response = DB::select($sql);
        return $response;
    }

    public static function saveComment(Request $request) {
        $submission_id  = $request->input('submission_id');
        $comment        = $request->input('comment');
        $user_id        = $request->input('user_id');
        $date_time      = date("Y-m-d H:i:s", time());

        $id = DB::table('comments')->insertGetId(
            [
                'submission_id' => $submission_id,
                'comment'       => $comment,
                'user_id'       => $user_id,
                'created_at'    => $date_time,
                'updated_at'    => $date_time
            ]
        );

        return $id;
    }
}
