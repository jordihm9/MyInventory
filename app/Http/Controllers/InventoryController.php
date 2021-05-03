<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // 
        return view('inventory', [
            'categories'=> Category::all()
        ]);
    }
}
