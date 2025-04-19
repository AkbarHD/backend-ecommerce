<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        // Fetch all sizes from the database
        $sizes = Size::orderBy('name', 'desc')->get();
        return response()->json([
            'status' => 200,
            'data' => $sizes
        ]);
    }
}
