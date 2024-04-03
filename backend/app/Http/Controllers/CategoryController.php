<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public $category;

    public function __construct(Category $category){
        $this->category = $category;
    }
    public function newcategory(){
        return view('categories.newcategory');
    }

    public function add(Request $request){
        // dd($request);
        $data = $request->validate([
            'c_code' => ['required'],
            'c_description' => ['required'],
            'created_at'
        ]);

        $code = strtoupper($data['c_code']);
        $data['c_code'] = $code;

        $description = ucwords($data['c_description']);
        $data['c_description'] = $description;

        $data['created_at'] = now();

        $checkduplicate = $this->category->checkDuplicates($data);

        if($checkduplicate >= 1){
            return redirect('/newcategory')->with('error', ' Category already exists!');
        }

        $save = $this->category->addCategory($data);

        if($save){
            return redirect('/categories')->with('success',  $data['c_description'] .  ' ' . 'Category added!');
        }else{
            return redirect('/categories')->with('error', 'Failed to add category!');
        }
    }

    public function categories(){
        $categories = $this->category->getCategories();
        return view('categories.categories', compact('categories'));
    }
    

    public function category($c_id){
        $data = $this->category->viewCategory($c_id);
        return view('categories.category', compact('data'));
    }

    public function editcategory(Request $request){
        $data = $request->validate([
            'c_id' => ['required'],
            'c_code' => ['required'],
            'c_description' => ['required'],
            'c_updatedby' => ['nullable'],
            'updated_at' => ['nullable'],
            'c_status' => ['nullable'],
        ]);

        $update = $this->category->updateCategory($data);

        if($update){
            return redirect('/categories')->with('success',  $data['c_code'] .  ' ' . 'Category updated!');
        }else{
            return redirect('/categories')->with('error', 'Failed to update category ' . $data['c_code'] . '!');
        }
    }

    public function searchcategory(Request $request){
        $searchitem = $request->validate(['searchitem' => ['required']]);
        $categories = $this->category->searchCategory($searchitem);
        return view('categories.categories', compact('categories'));
    }
}
