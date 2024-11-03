<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RatingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Ratings/Index', [

        ]);
    }

    public function store()
    {
        //
    }
}
