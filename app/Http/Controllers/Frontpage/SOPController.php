<?php

namespace App\Http\Controllers\Frontpage;

use App\StandardOperationProcedure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SOPController extends Controller
{
    public function index()
    {
        $sops = StandardOperationProcedure::select('file_path','filename')->get();

        return view('frontpage.sop.index', compact('sops'));
    }
}
