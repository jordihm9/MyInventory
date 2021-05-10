<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use App\Models\Subcategory;
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

        $data = array(
            'product' => $product,
            'categories' => Category::all()->sortBy('name'),
            'conditions' => Condition::all()->sortBy('id'),
            'states' => State::all()->sortBy('id'),
        );

        // check if the product had a category set
        if ($product->category !== null) {
            // add the subcategories from the category to the data that will be sent to the view
            $data = array_merge($data, array(
                'subcategories' => Subcategory::where('category_id', $product->category->id)->get()
            ));
        }

        return view('productForm', $data);
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
            'image*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        // get the id from the request
        $id = $request->input('id');
        
        // if id is null or empty, create a new product,
        // if not, get the product from the database and update it
        if ($id === null || $id === '') {
            $product = new Product;
        } else {
			// get the product from the database
            $product = Product::findOrFail($id);
			// get the input with the id of images to delete
			// split the id's and store in array
			$images_ids = explode(',', $request->input('images-to-remove'));
			
			$images = array();
			foreach ($images_ids as $image_id) {
				// get the image from the database
				$image = Image::where('id', $image_id)->first();
				if ($image instanceof Image) {
					array_push($images, $image);
				}
			}
			$this->deleteImages($images);
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

        // get the array of files sent
        $images = $request->file();

        // check if there are images
        if (sizeof($images) >= 1) {
            // upload the images
            $this->uploadImages($product, $images);
        }

        // redirect to the inventory route
        return redirect()->route('inventory');
    }

    /**
     * Store every image sent in the request and insert to the database
     * @param App\Models\Product $product
     * @param array $images
     */
    private function uploadImages(Product $product, $images)
    {
        // get the product id
        $product_id = $product->id;

        // loop over each image
        foreach ($images as $image) {
            // store the image and get the path where it has been saved
            $url = Storage::disk('public')->putFile('uploads', $image);

            // create a new image to save details in database
            $image = new Image;
            // set the properties
            $image->url = $url;
            $image->product_id = $product_id;

            // save changes
            $image->save();
        }
    }

    /**
     * Remove the images from the filesystem and from the database
     * @param array $images list of images to delete
     */
    private function deleteImages($images)
    {
        // loop over each image 
        foreach ($images as $image) {
            // delete from the filesystem
            Storage::disk('public')->delete($image->url);
            // delete from the database
            $image->delete();
        }
    }
}