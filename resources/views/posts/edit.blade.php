<x-layout>
    
    <a href="{{route('dashboard')}}" class="block mb-2 text-xs text-blue-500">&larr; Go back to your dashboard</a>
    <div class="w-full bg-white p-6 rounded-xl mb-4">
        <h2 class="font-bold mb-4">Update a new post</h2>   
        <form action="{{ route('posts.update', $post)}}" method="POST"
        enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- title --}}
            <div class="mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="input" value="{{$post->title}}">
                @error('title') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- body --}}
            <div class="mb-4">
                <label for="body">Body</label>
                <textarea name="body" id="" rows="5" cols="10" class="input resize-none">                
                    {{$post->body}}                    
                </textarea>                
                @error('body') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- photo --}}
            @if ($post->image)
                <div class="h-64 rounded-md mb-4 w-1/4 object-cover overflow-hidden">        
                    <label>Post Content</label> 
                    <img src="{{asset('storage/'.$post->image)}}"  class="" alt=""> {{-- ingat php dasar penggunaan . sebagai concat --}}
                </div>
            @endif

              {{-- upload image --}}
              <div class="mb-4">
                <label for="image">Cover Photo</label>
                <input type="file" name="image" class="image" id="image">
                @error('image') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>


            <button type="submit" class=" w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
        </form>
    </div>
</x-layout>