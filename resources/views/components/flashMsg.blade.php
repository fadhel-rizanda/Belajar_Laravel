@props(['msg', 'bg'=>'bg-green-500'])

<div class="flex justify-center {{$bg}} text-white rounded w-full {{$msg ? 'mt-4' : 'mt-0'}}">
    {{$msg}}
</div>  