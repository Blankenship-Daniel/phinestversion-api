<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteRepository {

    private static function getNumVotes($submission_id, $user_id, $vote_type) {
        $sql = <<<EOF
SELECT
  COUNT(*) as count
  FROM votes
  WHERE submission_id = ?
    AND user_id = ?
    AND vote_type = ?
EOF;

        $response = DB::select($sql, [$submission_id, $user_id, $vote_type]);
        return $response;
    }

    public static function getVoteTypeBySubmissionId(Request $request) {
        $submission_id  = $request->input('submission_id');
        $user_id        = $request->input('user_id');

        $up_vote    = VoteRepository::getNumVotes($submission_id, $user_id, 'up');
        $down_vote  = VoteRepository::getNumVotes($submission_id, $user_id, 'down');

        $up_vote_count   = (int)$up_vote[0]->count;
        $down_vote_count = (int)$down_vote[0]->count;

        return ($up_vote_count - $down_vote_count);
    }

    public static function submitVote(Request $request) {
        $submission_id  = $request->input('submission_id');
        $user_id        = $request->input('user_id');
        $vote_type      = $request->input('vote_type');

        $response = DB::table('votes')->insert(
            [
                'submission_id' => $submission_id,
                'user_id'       => $user_id,
                'vote_type'     => $vote_type
            ]
        );

        return $response;
    }
}
