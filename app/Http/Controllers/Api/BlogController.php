<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Blog;
use Validator;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();

        return $this->sendResponse(BlogResource::collection($blogs), 'Blogs retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $input = $request->all();

      $validator = Validator::make($input, [
          'title' => 'required',
          'content' => 'required'
      ]);

      if($validator->fails()){
          return $this->sendError('Validation Error.', $validator->errors());       
      }

      $blog = Blog::create($input);

      return $this->sendResponse(new BlogResource($blog), 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $blog = Blog::find($id);
  
      if (is_null($blog)) {
          return $this->sendError('Blog not found.');
      }

      return $this->sendResponse(new BlogResource($blog), 'Blog retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
      $input = $request->all();

      $validator = Validator::make($input, [
          'title' => 'required',
          'content' => 'required'
      ]);

      if($validator->fails()){
          return $this->sendError('Validation Error.', $validator->errors());       
      }

      $blog->title = $input['title'];
      $blog->summary = $input['summary'];
      $blog->content = $input['content'];
      $blog->save();

      return $this->sendResponse(new BlogResource($blog), 'Blog updated successfully.');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
      $blog->delete();

      return $this->sendResponse([], 'Product deleted successfully');
    }
}
