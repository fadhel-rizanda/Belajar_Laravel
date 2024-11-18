<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware () : array {
        return [            
            new Middleware(['auth', 'verified'], except:  ['index', 'show']), // jadi middleware dispecify utnuk function apa saja bisa menggunakan include(spesifik yg digunakan) atau except(yg tidak digunakan)
        ];
     }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        //utnu render homepage yg mengandung semua datanya
        $posts = Post::latest()->paginate(6);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //untuk render formnya
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //untuk menyimpan form                        

        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1000', 'mimes:png,jpg,jpeg,webp']
        ]);
        
        // store image if exist, gunakna if karena image nulable
        $path = null;
        if($request->hasFile('image')) {
            $path = Storage::disk('public')->put('posts_images', $request->image); // untuk menyimpan gambar akan disimpan ke dalam folder storage/app/posts_images, sebelumnya disk('public') tidak ada namun ditambahkan agar data menjadi public dan akan distore kedalam folder storage namun public, akan return berupa path
            // jalankan php artisan storage:link //sehingga dapat diakses langsung melalui folder public dan  bukan didalam folder app, cara kerjanya sebagai duplicate dari folder storage/app/posts_images ke folder public/posts_images sehingga disk('public') tetap penting
        }
        

        // create the user
         $post = Auth::user()->posts()->create([
             'title' => $request->title,
             'body' => $request->body,
             'image' => $path
         ]);

        //  send email
         Mail::to(Auth::user()->email)->send(new WelcomeMail(Auth::user(), $post));

         return back()->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {        
        //utnuk detail data
        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('modify', $post); // digunakna untuk menggunakan policies yang sudah dibuat
        //render form update
        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post); // digunakna untuk menggunakan policies yang sudah dibuat
        //menjalankan form update
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1000', 'mimes:png,jpg,jpeg,webp']
        ]);

        $path = $post->image ?? null;
        if($request->hasFile('image')) {
            if($post->image) { // jika ada prev image maka hapus
                Storage::disk('public')->delete($post->image);// jadi akan menghapus img yang ada di app public
            }
            $path = Storage::disk('public')->put('posts_images', $request->image);         
        }
        
         $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
         ]);

         return redirect()->route('dashboard')->with('success', 'Post Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post); // digunakna untuk menggunakan policies yang sudah dibuat

        // hapus image 
        if($post->image) {
            Storage::disk('public')->delete($post->image);// jadi akn menghapus img yang ada di app public
        }

        //utnu hapus detail data
        $post->delete();

        return redirect()->back()->with('delete', 'Post deleted successfully');
    }
}
