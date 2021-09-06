<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontpage.contact');
    }
}
