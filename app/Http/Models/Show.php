<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shows';

    protected $fillable = [
        'id',
        'date',
        'tour_id',
        'venue_id'
    ];
}
