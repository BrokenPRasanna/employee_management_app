<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Homecontroller extends Controller
{
    public function aboutUs() {
        if (true) {
            return redirect()->route('welcome');
        }
        return 'Veliye jaav';
    }
}
