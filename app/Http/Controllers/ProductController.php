<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Models\State;

class ProductController extends Controller
{
    /**
     * Return to the view sending the categories, states and conditions
     */
    public function create(Request $request)
    {
        return view('productForm', [
            'categories' => Category::all()->sortBy('name'),
            'conditions' => Condition::all()->sortBy('id'),
            'states' => State::all()->sortBy('id'),
        ]);
    }

    /**
     * Return to the view sending the product to edit, categories and subcategories, states, conditions
     */
    public function edit(Request $request)
    {
        // get the id from the request
        $id = $request->input('id');

        // get the product from the database
        $product = Product::where('id', $id)->firstOrFail();

        return view('productForm', [
            'product' => $product,
            'categories' => Category::all()->sortBy('name'),
            'subcategories' => Category::findOrFail($product->category->id)->subcategories,
            'conditions' => Condition::all()->sortBy('id'),
            'states' => State::all()->sortBy('id'),
        ]);
    }

    /**
     * Receive the product data, if receives an id, update the product, if not, create a new one
     */
    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'quantity' => ['required', 'integer'],
            'unit-price' => ['required', 'regex:/^[0-9]+[.,]+[0-9]*$/'],
        ]);

        // get the id from the request
        $id = $request->input('id');
        
        // if id is null or empty, create a new product,
        // if not, get the product from the database and update it
        if ($id === null || $id === '') {
            $product = new Product;
        } else {
            $product = Product::firstOrFail($id);
        }

        // get the unit price and total price to replace commas to dots
        $unit_price = $request->input('unit-price');
        $unit_price = str_replace(',', '.', $unit_price);
        $total_price = $request->input('total-price');
        $total_price = str_replace(',', '.', $total_price);

        // set the values for the product columns/attributes
        $product->title = $request->input('title');
        $product->quantity = $request->input('quantity');
        $product->unit_price = $unit_price;
        $product->total_price = $total_price;
        $product->description = $request->input('description');
        $category_id = $request->input('category');
        $product->category_id = $category_id === 'all' ? null : $category_id; // if value equals to all, set to null
        $subcategory_id = $request->input('subcategory');
        $product->subcategory_id = $subcategory_id === 'all' ? null : $subcategory_id; // if value equals to all, set to null
        $product->condition_id = $request->input('condition');
        $product->state_id = $request->input('state');
        $product->user_id = \Auth::id(); // get the id from the current logged in user

        // update or create the product saving changes
        $product->save();

        // redirect to the inventory route
        return redirect()->route('inventory');
    }
}
