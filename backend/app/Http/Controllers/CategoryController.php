<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function newcategory(){
        return view('categories.newcategory');
    }

    public function add(Request $request){
        // dd($request);
        $category = $request->validate([
            'c_code' => ['required'],
            'c_description' => ['required'],
            'created_at'
        ]);

        $code = strtoupper($category['c_code']);
        $category['c_code'] = $code;

        $description = ucwords($category['c_description']);
        $category['c_description'] = $description;

        $category['created_at'] = now();

        $checkduplicate = Category::where('c_code', 'LIKE', '%' . $category['c_code'] . '%')->count();

        if($checkduplicate >= 1){
            return redirect('/newcategory')->with('error', ' Category already exists!');
        }

        $save = Category::insert($category);

        if($save){
            return redirect('/newcategory')->with('success',  $category['c_description'] .  ' ' . 'Category added!');
        }else{
            return redirect('/newcategory')->with('error', 'Failed to add category!');
        }
    }

    public function categories(){
        $get = Category::orderby('c_id', 'desc')->get();
        return view('categories.categories', ['categories' => $get]);
    }
}
