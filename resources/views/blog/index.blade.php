@extends('layouts.app')

@section('title', 'SkyDatum Blog')
@section('meta_description', 'Practical notes for civil engineers, GCs, and materials yards using drone survey data.')

@section('content')
<section class="section">
    <div class="wrap">
        <h2>From the flight log</h2>
        <p class="lede">Practical notes for civil engineers, GCs, and materials yards using drone survey data.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    @if($post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="" style="width:100%;height:160px;object-fit:cover;margin-bottom:.8rem;border-radius:.3rem;">
                    @endif
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>No posts yet.</p></div>
            @endforelse
        </div>
        <div style="margin-top:2rem">{{ $posts->links() }}</div>
    </div>
</section>
@endsection