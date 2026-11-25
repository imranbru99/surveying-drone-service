@extends('layouts.app')
@section('title', 'AeroGrid Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">From subdivision topo to quarry volumes — flight packages sized for civil firms, GCs, and materials yards.</p>
        <div class="grid-3">
            @foreach([
                ['topographic-mapping','Topographic Drone Mapping','https://images.unsplash.com/photo-1527979809429-b4bb5c0c0f1c?auto=format&fit=crop&w=1600&q=80'],
                ['construction-orthomosaic','Construction Progress Orthomosaics','https://images.unsplash.com/photo-1531834685032-c34bfa9ee8b2?auto=format&fit=crop&w=1600&q=80'],
                ['corridor-row','Corridor & ROW Surveys','https://images.unsplash.com/photo-1464037866556-68135799b824?auto=format&fit=crop&w=1600&q=80'],
                ['stockpile-volumetrics','Stockpile Volumetrics','https://images.unsplash.com/photo-1565008576549-57569a49371d?auto=format&fit=crop&w=1600&q=80'],
                ['as-built-capture','As-Built Aerial Capture','https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80'],
                ['utility-inspection','Utility Corridor Inspection','https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=1600&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection