<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'submissions';

    public $timestamps = false;

    protected $fillable = [
        'song_id',
        'show_id',
        'description',
        'user_id',
        'score'
    ];

    public function setUpdatedAt($value)
    {}

    public function setCreatedAt($value)
    {}
}
