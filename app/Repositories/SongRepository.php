<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SongRepository {

    public static function getAll(Request $request) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT
    submissions.song_id AS song_id,
    title,
    slug,
    tracks_count,
    SUM(score) as score
FROM submissions
INNER JOIN songs ON submissions.song_id = songs.id
GROUP BY title
ORDER BY score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$limit, $start]);
        return $response;
    }

    public static function get($slug) {
        $sql = <<<EOF
SELECT
    submissions.song_id AS song_id,
    title,
    slug,
    tracks_count,
    SUM(score) as score
FROM submissions
INNER JOIN songs ON submissions.song_id = songs.id
WHERE songs.slug = ?
GROUP BY title
ORDER BY score DESC
EOF;

        $response = DB::select($sql, [$slug]);
        return $response;
    }
}
