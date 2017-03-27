<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserRepository {

    public static function getUserRankings(Request $request) {
        $limit = $request->input('limit') ? $request->input('limit') : PHP_INT_MAX;
        $start = $request->input('start') ? $request->input('start') : 0;

        $sql = <<<EOF
SELECT 
    users.id AS user_id, 
    users.image AS user_image, 
    users.username AS username, 
    SUM(submissions.score) AS score 
FROM users 
INNER JOIN 
    submissions ON submissions.user_id = users.id 
GROUP BY user_id 
ORDER BY score DESC
LIMIT ?
OFFSET ?
EOF;

        $response = DB::select($sql, [$limit, $start]);
        return $response;
    }

    public static function getUserByUserName($username) {
        $sql = <<<EOF
SELECT 
    users.id AS user_id, 
    users.image AS user_image, 
    users.username AS username, 
    SUM(submissions.score) AS score 
FROM users 
INNER JOIN 
    submissions ON submissions.user_id = users.id 
WHERE users.username = ?
GROUP BY user_id 
ORDER BY score DESC
EOF;

        $response = DB::select($sql, [$username]);
        return $response;
    }
}