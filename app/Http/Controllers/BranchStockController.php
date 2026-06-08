<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class BranchStockController extends Controller
{
    public function index()
    {
        $stocks = Stock::where(
            'branch_id',
            auth()->user()->branch_id
        )->get();

        return view('branch.stock.index', compact('stocks'));
    }
}