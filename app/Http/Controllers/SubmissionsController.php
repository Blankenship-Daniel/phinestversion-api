<?php

namespace App\Http\Controllers;

use App\Repositories\SubmissionRepository;
use App\Submission;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{
    public function getAllSubmissions() {
        $submissions = Submission::all();
        return json_encode($submissions);
    }

    public function getSubmissionById($id) {
        $submission = SubmissionRepository::getSubmissionById($id);
        return json_encode($submission);
    }

    public function getSubmissionsBySongId($id) {
        $submissions = Submission::where('song_id', '=', $id)->get();
        return json_encode($submissions);
    }

    public function getSubmissionsByShowId($id) {
        $submissions = Submission::where('show_id', '=', $id)->get();
        return json_encode($submissions);
    }

    public function getSubmissionsByUserId(Request $request, $id) {
        $submissions = SubmissionRepository::getSubmissionsByUserId($request, $id);
        return json_encode($submissions);
    }

    public function getSubmissionsByUserName(Request $request, $username) {
        $submissions = SubmissionRepository::getSubmissionsByUserName($request, $username);
        return json_encode($submissions);
    }

    public function getSubmissionsBySlug(Request $request, $slug) {
        $submissions = SubmissionRepository::getSubmissionsBySlug($request, $slug);
        return json_encode($submissions);
    }

    public function getRankingsByDate($date) {
        $submissions = SubmissionRepository::getRankingsByDate($date);
        return json_encode($submissions);
    }

    public function getRecentSubmissions() {
        $submissions = SubmissionRepository::getRecentSubmissions();
        return json_encode($submissions);
    }

    public function saveSubmission(Request $request) {
        $submission_id = SubmissionRepository::saveSubmission($request);
        return $this->getSubmissionById($submission_id);
    }

    public function saveSubmissionScore(Request $request) {
        $response = SubmissionRepository::saveSubmissionScore($request);
        return $response;
    }
}
