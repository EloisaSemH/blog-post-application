@extends('layout.skeleton')

@section('content')
    <main class="container bg-light p-5">
        <article>
            <h1 class="text-center">{!! $post['title'] !!}</h1>
            <h2 class="text-center">{!! $post['subtitle'] !!}</h2>
            <div class="text-center my-3">
                <img src="{{ asset('img/posts/Billie-Eilish-x-Nike-Air-Force-1-High-33.png') }}" class="img-fluid"
                     alt="Responsive image">
            </div>
            <p>{!! $post['text'] !!}</p>
        </article>
        @include('components.comments_section')
    </main>
@endsection
