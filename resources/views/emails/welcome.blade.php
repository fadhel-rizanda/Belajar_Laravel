<h1>Hello {{$user->username}}, Welcome to {{env('APP_NAME')}}</h1>

<div class="">
    <h2>You created {{$post->title}} posts</h2>
    <p>{{$post->body}}</p>

    <img width="300" src="{{$message->embed('storage/'.$post->image)}}" alt="">
</div>