<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function newcategory(){
        return view('categories.newcategory');
    }
}
