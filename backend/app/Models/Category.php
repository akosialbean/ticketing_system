<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'c_code',
        'c_description',
        'c_createdby',
        'c_updatedby',
        'c_status',
    ];

    public function getCategories(){
        return Category::orderby('c_id', 'desc')->paginate(10);
    }

    public function searchCategory($searchitem){
        return Category::where('categories.c_id', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('categories.c_code', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('categories.c_description', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orderby('c_id', 'desc')->paginate(10);
    }

    public function addCategory($category){
        return Category::create($category);
    }

    public function updateCategory($data){
        return Category::where('c_id', $data['c_id'])
            ->update([
                'c_code' => $data['c_code'],
                'c_description' => $data['c_description'],
                'c_updatedby' => Auth::user()->id,
                'updated_at' => now(),
                'c_status' => $data['c_status'],
            ]);
    }

    public function viewCategory($c_id){
        return Category::where('c_id', $c_id)->first();
    }

    public function getCategoryCodes(){
        return Category::where('c_status', 1)->orderby('c_code', 'asc')->get();
    }

    public function checkDuplicates($data){
        return Category::where('c_code', 'LIKE', '%' . $data['c_code'] . '%')->count();
    }
}
