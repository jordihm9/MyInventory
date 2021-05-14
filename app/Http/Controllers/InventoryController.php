<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Condition;
use App\Models\State;

class InventoryController extends Controller
{
    /**
     * Return to the view sending the categories and subcategories, states, conditions and products from the currently logged user
     */
    public function index()
    {
        return view('inventory', [
            'categories' => Category::all(),
            'states' => State::all()->sortBy('id'),
            'conditions' => Condition::all()->sortBy('id'),
            'products' => \Auth::user()->products,
        ]);
    }

    /**
     * Filter and get the products
     * @param Request $request
     */
    public function filter(Request $request)
    {
        \Log::debug($request);
        // get the values from the form
        $keyword = $request->input('keyword');
        $keyword = empty($keyword) ? '' : $keyword .'%';

        $category = $request->input('category');
        $category = empty($category) || $category === 'all' ? 'null' : $category;
        
        $subcategory = $request->input('subcategory');
        $subcategory = empty($subcategory) || $subcategory === 'all' ? 'null' : $subcategory;

        $state = $request->input('state');
        $state = empty($state) ? 'null' : $state;

        $condition = $request->input('condition');
        $condition = empty($condition) ? 'null' : $condition;

        // switch ($request->input('price')) {
        //     case 'high':
        //         $priceOrder = 'DESC';
        //         break;
        //     case 'low':
        //         $priceOrder = 'ASC';
        //         break;
        //     default:
        //         $priceOrder = null;
        //         break;
        // }
        
        $products = Product::with(['images'])
            ->where('user_id', \Auth::id())
            ->where(function($query) use ($keyword) {
                $query
                    ->where('title', 'LIKE', '%'. $keyword)
                    ->orWhere('description', 'LIKE', '%'. $keyword);
            })
            ->where(function($query) use ($category) {
                $query
                    ->where('category_id', $category)
                    ->orWhereRaw($category .' IS NULL');
            })
            ->where(function($query) use ($subcategory) {
                $query
                    ->where('subcategory_id', $subcategory)
                    ->orWhereRaw($subcategory .'  IS NULL');
            })
            ->where(function($query) use ($state) {
                $query
                    ->where('state_id', $state)
                    ->orWhereRaw($state .'  IS NULL');
            })
            ->where(function($query) use ($condition) {
                $query
                    ->where('condition_id', $condition)
                    ->orWhereRaw($condition .'  IS NULL');
            })
            // ->dump()->get()->dump();
            ->get();

        // return the response as json
        // send the subcategories of the category
        return response()->json([
            'products' => $products,
        ]);
    }
}
