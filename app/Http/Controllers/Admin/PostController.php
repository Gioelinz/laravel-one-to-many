<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        return view('admin.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|unique:posts|min:5|max:255',
                'image' => 'required|string|unique:posts',
                'description' => 'required|string',
            ],
            [
                'required' => 'Il campo :attribute è obbligatorio!',
                'title.unique' => "Il Post $request->title è già esistente!",
                'image.unique' => "Questa immagine è già stata inserita!",
                'title.min' => "$request->title è lungo meno di 5 caratteri!"
            ]
        );

        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');

        $post = Post::create($data);

        return redirect()->route('admin.posts.index')->with('message', "$post->title creato con successo");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title' => ['required', 'string', Rule::unique('posts')->ignore($post->id), 'min:5', 'max:255'],
                'image' => ['required', 'string', Rule::unique('posts')->ignore($post->id)],
                'description' => 'required|string',
            ],
            [
                'required' => 'Il campo :attribute è obbligatorio!',
                'title.unique' => "Il Post $request->title è già esistente!",
                'image.unique' => "Questa immagine è già stata inserita!",
                'title.min' => "$request->title è lungo meno di 5 caratteri!"
            ]
        );

        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('message', "$post->title modificato con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('message', "Il Post $post->title è stato cancellato");
    }
}
