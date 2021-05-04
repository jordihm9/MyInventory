<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Condition;
use App\Models\State;

class InventoryController extends Controller
{
    /**
     * Return to the view sending the categories and subcategories, states, conditions and products
     */
    public function index()
    {
        return view('inventory', [
            'categories' => Category::all(),
            'states' => State::all()->sortBy('id'),
            'conditions' => Condition::all()->sortBy('id'),
            'products' => Product::all()->sortBy('id'),
        ]);
    }
}
