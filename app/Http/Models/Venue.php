<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'venues';

    protected $fillable = [
        'id',
        'name',
        'shows_count',
        'location',
        'slug'
    ];

    public function setUpdatedAt($value)
    {}

    public function setCreatedAt($value)
    {}
}
