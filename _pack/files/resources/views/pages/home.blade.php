@extends('layouts.app')

@section('title', 'AeroGrid Survey')
@section('meta_description', 'Front Range drone surveying for orthomosaics, topographic maps, construction progress, stockpile volumetrics, and corridor inspections by AeroGrid Survey.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>AeroGrid<br>Survey</h1>
        <p>Precision aerial mapping and photogrammetry across Denver, Boulder, Fort Collins, and Colorado Springs — deliverables GCs, engineers, and asset owners can stake decisions on.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Schedule a mission</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View survey services</a>
        </div>
    </div>
</section>
<section class="section">
    <div class="wrap">
        <h2>Aerial survey services</h2>
        <p class="lede">From site orthomosaics to corridor ROW inspections — flight plans, GCPs, and deliverables sized for Front Range projects.</p>
        <div class="grid-3">
            @foreach([
                ['orthomosaic-mapping','Orthomosaic Mapping','Georeferenced site mosaics for planning and as-builts.','https://images.unsplash.com/photo-1508444845599-5b89963bd43e?auto=format&fit=crop&w=1200&q=80'],
                ['topographic-drone-survey','Topographic Drone Survey','Dense elevation products with contour-ready surfaces.','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80'],
                ['construction-progress','Construction Progress Captures','Repeatable flight lines for week-to-week progress.','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80'],
            ] as [\,\,\,\])
                <a class="service-tile" href="{{ route('services.show', \) }}">
                    <img src="{{ \ }}" alt="{{ \ }}">
                    <div class="pad"><h3>{{ \ }}</h3><p>{{ \ }}</p></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why AeroGrid</h2>
        <p class="lede">Pilots and photogrammetrists who treat flight planning, ground control, and delivery QA as one continuous workflow.</p>
        <div class="grid-3">
            <div class="panel"><h3>Mission-first planning</h3><p>We match GSD, overlap, and GCP density to the decision you need before propellers spin.</p></div>
            <div class="panel"><h3>RTK &amp; ground control</h3><p>RTK airframes plus surveyed GCPs keep surfaces locked to your project CRS.</p></div>
            <div class="panel"><h3>ERP-run flight ops</h3><p>Missions, battery/prop inventory, invoices, and appointments live in one stack.</p></div>
        </div>
    </div>
</section>
<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the AeroGrid ERP used to schedule missions, track flight gear, and close invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>34</strong> Active missions</div>
                    <div class="metric"><strong>\</strong> Pipeline</div>
                    <div class="metric"><strong>98%</strong> On-time deliveries</div>
                </div>
                <div class="bars"><span style="height:45%"></span><span style="height:70%"></span><span style="height:55%"></span><span style="height:85%"></span><span style="height:60%"></span><span style="height:92%"></span><span style="height:68%"></span></div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0;font-size:1.4rem">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Missions &amp; flight scheduling</li>
                    <li>Battery / RTK / GCP inventory</li>
                    <li>Invoices &amp; client payments</li>
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
        <p class="lede">Practical notes for GCs, civil engineers, and asset owners planning drone surveys.</p>
        <div class="grid-3">
            @forelse(\ as \)
                <a class="panel" href="{{ route('blog.show', \->slug) }}"><h3>{{ \->title }}</h3><p>{{ \->excerpt }}</p></a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
