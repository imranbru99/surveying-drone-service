@extends('layouts.app')

@section('title', 'SkyDatum Aerial Survey')
@section('meta_description', 'SkyDatum Aerial Survey — Drone topography, orthomosaics & volumetrics for Central Texas projects')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>SkyDatum<br>Aerial Survey</h1>
        <p>Survey-grade drone topography, progress orthomosaics, and stockpile volumetrics — so Central Texas projects fly on data civil teams can trust.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a flight</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View aerial services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">From subdivision topo to quarry volumes — flight packages sized for civil firms, GCs, and materials yards.</p>
        <div class="grid-3">
            @foreach([
                ['topographic-mapping','Topographic Drone Mapping','Survey-grade GCPs, dense point clouds, and CAD-ready contours for design teams.','https://images.unsplash.com/photo-1527979809429-b4bb5c0c0f1c?auto=format&fit=crop&w=1600&q=80'],
                ['construction-orthomosaic','Construction Progress Orthomosaics','Repeatable flight plans for weekly or monthly progress basemaps.','https://images.unsplash.com/photo-1531834685032-c34bfa9ee8b2?auto=format&fit=crop&w=1600&q=80'],
                ['stockpile-volumetrics','Stockpile Volumetrics','Cubic-yard inventories for aggregates, spoils, and quarry faces.','https://images.unsplash.com/photo-1565008576549-57569a49371d?auto=format&fit=crop&w=1600&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why SkyDatum</h2>
        <p class="lede">Pilots and processors who treat GCPs, CRS consistency, and deliverable QA as part of the same flight order.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Survey discipline</h3>
                <p>RTK/PPK plus independent GCPs so contours survive CAD scrutiny.</p>
            </div>
            <div class="panel">
                <h3>Repeatable progress flights</h3>
                <p>Locked plans make week-over-week orthos comparable for supers and owners.</p>
            </div>
            <div class="panel">
                <h3>ERP-run flight ops</h3>
                <p>Missions, battery inventory, invoices, and weather holds live in one stack.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the SkyDatum ERP used to schedule flights, track airframes, and close project invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>33</strong> Active missions</div>
                    <div class="metric"><strong>$156k</strong> Pipeline</div>
                    <div class="metric"><strong>95%</strong> On-time deliverables</div>
                </div>
                <div class="bars">
                    <span style="height:45%"></span><span style="height:70%"></span><span style="height:55%"></span>
                    <span style="height:85%"></span><span style="height:60%"></span><span style="height:92%"></span>
                    <span style="height:68%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0;font-size:1.4rem">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Flight missions & scheduling</li>
                    <li>Airframe & battery inventory</li>
                    <li>Invoices & rush fees</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the flight log</h2>
        <p class="lede">Practical notes for civil engineers, GCs, and materials yards using drone survey data.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection