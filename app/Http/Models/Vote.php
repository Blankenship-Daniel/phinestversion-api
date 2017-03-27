<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votes';

    protected $primaryKey = 'submission_id';

    protected $fillable = [
        'submission_id',
        'user_id',
        'vote_type'
    ];

    public $timestamps = false;

    public function setUpdatedAtAttribute($value)
    {}

    public function setUpdatedAt($value)
    {}

    public function setCreatedAt($value)
    {}
}
