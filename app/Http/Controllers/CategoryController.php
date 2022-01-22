<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ListCategoriesRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Providers\CategoryStored;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListCategoriesRequest $request) :JsonResponse
    {
        $data = $request->validated();
        $categories = Category::where('locale', $data['locale'])->get();


        return response()->json(
            CategoryResource::collection($categories), 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request) :JsonResponse
    {
        $data = $request->validated();

        if(Category::where(['name' => $data['name'], 'locale' => $data['locale']])->exists()){
            return response()->json([
                'message' => 'This category already exists in database'
            ], 422);
        }

        $user = User::query()->first(); //for test notification
        
        $category = Category::create($data);
        event(new CategoryStored($category, $user));
      
        return response()->json([
            'message' => 'Category successfully stored'
        ], 201);
        
       
    }


}
