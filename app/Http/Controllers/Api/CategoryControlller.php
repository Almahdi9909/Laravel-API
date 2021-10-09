<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class CategoryControlller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Http\Resources\CategoryResource::collection(Category::all()->load('transaction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        // Category::create($this->validateCatgeory());
        // $category = new CategoryResource(Category::create($request->validated() + ['user_id' => auth()->id ]));
        //  u can set the attributes at the time of insertion as well from the user model 
        // or better option is to use the below code 
        $category = auth()->user()->category()->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Category $category)
    // {
    //     return $category;
    // }
    public function show(Category $category)
    {
        
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
       $category->update($request->validated());
       return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }

    protected function validateCatgeory(Category $category = null): array
    {
        $category ??= new Category();

        return request()->validate([
            'name' => 'required',
        ]);
    }

}
