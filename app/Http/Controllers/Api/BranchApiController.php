<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Branch::all()
        ]);
    }
}