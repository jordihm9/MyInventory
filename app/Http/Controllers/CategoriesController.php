<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;

class CategoriesController extends Controller
{
    /**
     * Select the subcategories of a category (by id)
     */
    public function getSubcategories(Request $request, $id)
    {
        // select the category by id
        $category = Category::findOrFail($id);

        // return the response as json
        // send the subcategories of the category
        return response()->json([
            'subcategories' => $category->subcategories,
        ]);
    }
}
