<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'songs';

    protected $fillable = [
        'id',
        'title',
        'alias_for',
        'tracks_count',
        'slug'
    ];
}
