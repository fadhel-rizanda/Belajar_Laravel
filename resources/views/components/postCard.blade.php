@props(['post', 'full' => false])

<div class="bg-white border-2 rounded-xl shadow-md mb-4 p-6">
    {{-- cover image --}}
    <div class="card">        
            <img src="{{($post->image) ? asset('storage/'.$post->image) : asset('storage/posts_images/default.png')}}" class="w-1/3" alt=""> {{-- ingat php dasar penggunaan . sebagai concat --}}
    </div>

    {{-- title --}}
    <h2 class="font-bold text-xl">{{ $post->title }}</h2>

    {{-- author & date --}}
    <div class="text-xs font-light mb-4">
        <span>Posted {{$post->created_at->diffForHumans()}} by</span>
        <a href="{{route('post.user', $post->user)}}" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
    </div>
    
    {{-- body --}}
    @if ($full)
        <div class="text-sm">
            <span>{{ $post->body }}</span>            
        </div>
    @else
        <div class="text-sm">
            <span>{{ Str::words($post->body, 15) }}</span>
            <a href="{{route('posts.show', $post)}}" class="text-blue-500 ml-2">Read more &rarr;</a>
        </div>
    @endif

    <div class="flex items-center justify-end gap-4 mt-6">
        {{ $slot }}
    </div>
</div>