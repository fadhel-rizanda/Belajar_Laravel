<x-layout>    
    
    <h1 class="title text-red-500 font-extralight">Hello {{auth()->user()->username}}, Welcome to {{env('APP_NAME')}}</h1>

    {{-- create posts form --}}
    <div class="w-full bg-white p-6 rounded-xl mb-4">
        <h2 class="font-bold mb-4">Create a new post</h2>        

        <form action="{{ route('posts.store') }}" method="POST" 
        enctype="multipart/form-data">{{-- enctype digunakan untuk form file --}}
            @csrf

            {{-- image --}}
            <div class="mb-4">
                <label for="image">Cover Photo</label>
                <input type="file" name="image" class="image" id="image">
                @error('image') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- title --}}
            <div class="mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="input" value="{{old('title')}}">
                @error('title') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- body --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <textarea name="body" id="" rows="5" cols="10" class="input resize-none">                
                    {{old('body')}}                    
                </textarea>                
                @error('body') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>


            <button type="submit" class=" w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
        </form>

        {{-- sessoin messages --}}
        @if (session('success'))
            <x-flashMsg msg="{{session('success')}}" />        
        @elseif (session('delete'))
            <x-flashMsg msg="{{session('delete')}}" bg="bg-red-500"/>
        @endif
    </div>
    

    {{-- user post --}}
    <h2 class="text-center font-bold mb-4">
        Your latest posts
        @if ($posts->total() > 0)
            you have - {{$posts->total()}} posts
        @endif
    </h2>
    @foreach ($posts as $post)
        <x-postCard :post="$post"> {{-- untuk mengirim data berupa objek --}} 
            
            {{-- update post --}}
           <a href="{{route('posts.edit', $post)}}" class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">Update</a>
            
            {{-- delete post --}}
            <form action="{{route('posts.destroy', $post)}}" method="POST">
                @csrf
                @method('DELETE') {{-- wajib utnuk put dan delete --}}
                <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">Delete</button>
            </form>

        </x-postCard>
    @endforeach
<div class="">{{$posts->links('pagination::tailwind')}}</div>
</x-layout>