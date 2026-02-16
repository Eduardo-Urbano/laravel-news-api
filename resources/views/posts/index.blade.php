@extends('layouts.app')

@section('content')
<h1 class="text-2xl mb-4">Posts</h1>

@if($posts->count())
    @foreach($posts as $post)
        <p>{{ $post->title }}</p>
    @endforeach
@else
    <p>Nenhum post encontrado.</p>
@endif
@endsection