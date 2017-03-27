<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    protected $fillable = [
        'submission_id',
        'user_id',
        'comment',
        'updated_at',
        'created_at'
    ];

    public function setUpdatedAt($value)
    {}

    public function setCreatedAt($value)
    {}
}
