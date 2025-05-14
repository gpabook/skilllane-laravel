<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //====
    public function index () {
        return Inertia::render('Home'); // Home.vue
    }
    //====
    public function about () {
        return Inertia::render('About', [
            'message' => 'Inertiajs',
            'postcode' => 50230
        ]); // About.vue
    }
    //====
    public function dashboad () {
        return Inertia::render('Dashboard')->middleware(['auth', 'verified']);
    }
    //====
}