<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommentsController extends Controller
{
    public function getAllComments() {
        $comments = Comment::all();
        return json_encode($comments);
    }

    public function getCommentById($id) {
        $comment = CommentRepository::getCommentById($id);
        return json_encode($comment);
    }

    public function getCommentsByUserId($id) {
        $comments = Comment::where('user_id', '=', $id)->get();
        return json_encode($comments);
    }

    public function getCommentsBySubmissionIdCount($id) {
        $count = CommentRepository::getCommentsBySubmissionIdCount($id);
        return json_encode($count);
    }

    public function getCommentsBySubmissionId(Request $request, $id) {
        $comments = CommentRepository::getCommentsBySubmissionId($request, $id);
        return json_encode($comments);
    }

    public function getRecentComments() {
        $comments = CommentRepository::getRecentComments();
        return json_encode($comments);
    }

    public function saveComment(Request $request) {
        $comment_id = CommentRepository::saveComment($request);
        return $this->getCommentById($comment_id);
    }
}
