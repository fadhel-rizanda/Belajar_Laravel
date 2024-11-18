<x-layout>    
<h1 class="title">Latest Post</h1>

{{-- images--}}

{{-- <p>{{$posts}}</p> --}}
@foreach ($posts as $post)
    <x-postCard :post="$post"/>
@endforeach

<div class="">
    {{$posts->links('pagination::tailwind')}}
</div>
</x-layout>