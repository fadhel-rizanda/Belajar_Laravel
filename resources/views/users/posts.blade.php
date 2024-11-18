<x-layout>
    <h1 class="title">{{$user->username}} &#9830 {{$posts->total()}} posts</h1>

    {{-- user posts --}}
    @foreach ($posts as $post)
        <x-postCard :post="$post"/>
    @endforeach

    <div class="">{{$posts->links('pagination::tailwind')}}</div>

</x-layout>