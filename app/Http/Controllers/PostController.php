<?php

namespace App\Http\Controllers;

use App\Model\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allposts = Post::with('user')->get()->latest();
        return response($allposts , 200);
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
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
            'image' => 'nullable,mimes:jpeg,png,jpg',
        ]);

        $post = new Post([
            'title'     => $request->title,
            'user_id'   => Auth::user()->id,
            'slug'      => Str::slug($request->title) . '-' . Str::random(10),
            'body'      => $request->body,
            'tags'      => $request->tags,            
        ]);

        if($request->hasFile('image'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploadedimages'), $imageName);
            $post->image = $imageName;
            $post->save();
        }       

        return response(["status" =>  "A blog with title: $post->title has been created."] , 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return response(Post::find('slug',$slug), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'title' => 'required',
            'body'  => 'required',
            'image' => 'nullable,mimes:jpeg,png,jpg',
        ]);

        $post = Post::where('slug',$slug)->first();
        
        $post->update([
            'title'     => $request->title,
            'body'      => $request->body,
            'tags'      => $request->tags,            
        ]);

        if($request->hasFile('image'))
        {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploadedimages'), $imageName);
            $post->image = $imageName;
            $post->save();
        }       

        return response(["status" =>  "A blog with title: $post->title has been updated."] , 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug',$slug)->first();
        $post->delete();
        return response(["msg" => "deleted sucessfully" ], 200);
    }
}
