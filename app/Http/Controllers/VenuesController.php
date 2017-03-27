<?php

namespace App\Http\Controllers;

use App\Venue;
use Illuminate\Http\Request;

use App\Http\Requests;

class VenuesController extends Controller
{
    public function getAllVenues() {
        $venues = Venue::all();
        return json_encode($venues);
    }

    public function getVenueById($id) {
        $venue = Venue::findOrFail($id);
        return json_encode($venue);
    }

    public function getVenueBySlug($slug) {
        $venues = Venue::where('slug', '=', $slug)->first();
        return json_encode($venues);
    }
}
