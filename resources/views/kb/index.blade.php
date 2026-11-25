@extends('layouts.app')

@section('title', 'Knowledge Base')
@section('meta_description', 'Common issues, guides, admin manual, and troubleshooting for SkyDatum Aerial Survey.')

@section('content')
<section class="section">
    <div class="wrap">
        <h2>Knowledge base</h2>
        <p class="lede">Common issues, guides, admin manual notes, and troubleshooting for SkyDatum surveying drone service work.</p>
        @foreach($articles as $category => $items)
            <h3 style="font-family:var(--font-display);margin:2rem 0 .8rem">{{ $category }}</h3>
            <div class="grid-2">
                @foreach($items as $article)
                    <a class="panel" href="{{ route('knowledge.show', $article->slug) }}">
                        <h3>{{ $article->title }}</h3>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
@endsection