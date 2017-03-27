<?php

namespace App\Http\Controllers;

use App\Repositories\VoteRepository;
use App\Vote;
use Illuminate\Http\Request;

use App\Http\Requests;

class VotesController extends Controller
{
    public function getAllVotes() {
        $votes = Vote::all();
        return json_encode($votes);
    }

    public function getVotesByUserId($id) {
        $votes = Vote::where('user_id', '=', $id)->get();
        return json_encode($votes);
    }

    public function getVotesBySubmissionId($id) {
        $votes = Vote::where('submission_id', '=', $id)->get();
        return json_encode($votes);
    }

    public function getVoteTypeBySubmissionId(Request $request) {
        $voteType = VoteRepository::getVoteTypeBySubmissionId($request);
        return json_encode($voteType);
    }

    public function submitVote(Request $request) {
        $response = VoteRepository::submitVote($request);
        return json_encode($response);
    }
}
