# -*- coding: utf-8 -*-
from pathlib import Path
import re

root = Path(__file__).resolve().parent

# --- SiteController service catalog ---
site = (root / 'app/Http/Controllers/SiteController.php').read_text(encoding='utf-8')
catalog = r'''
    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return [
            'orthomosaic-mapping' => [
                'title' => 'Orthomosaic Mapping',
                'summary' => 'Georeferenced site mosaics for planning, as-builts, and stakeholder reviews.',
                'body' => 'AeroGrid plans nadir missions with the overlap and GSD your project needs, then processes a seamless orthomosaic tied to your CRS. Ideal for Denver and Front Range sites where planners, estimators, and owners need a true-to-scale aerial base map.',
                'image' => 'https://images.unsplash.com/photo-1508444845599-5b89963bd43e?auto=format&fit=crop&w=1600&q=80',
            ],
            'topographic-drone-survey' => [
                'title' => 'Topographic Drone Survey',
                'summary' => 'Dense elevation products with contour-ready surfaces for civil design.',
                'body' => 'We combine RTK airframes with surveyed GCPs to produce DSMs, DTMs, and contour-ready surfaces civil teams can import. Typical Front Range deliverables include GeoTIFF surfaces and accuracy checks against control.',
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1600&q=80',
            ],
            'construction-progress' => [
                'title' => 'Construction Progress Captures',
                'summary' => 'Repeatable flight lines that track earthwork and vertical progress week to week.',
                'body' => 'Fixed flight lines and consistent processing settings make week-to-week comparisons honest. GCs and owners get orthos and cut/fill snapshots for Boulder and Colorado Springs jobsites.',
                'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1600&q=80',
            ],
            'stockpile-volumetrics' => [
                'title' => 'Stockpile Volumetrics',
                'summary' => 'Repeatable pile measurements for aggregate, spoil, and inventory reconciliation.',
                'body' => 'Stockpile missions use dense coverage and a documented base method so volumes reconcile month to month. We deliver pile reports with cubic-yard totals and notes on shadows or vegetation that can bias the surface.',
                'image' => 'https://images.unsplash.com/photo-1581094794329-adb0d0f1bf4b?auto=format&fit=crop&w=1600&q=80',
            ],
            'corridor-row-inspection' => [
                'title' => 'Corridor / Utility ROW Inspection',
                'summary' => 'Linear asset flights for utilities, pipelines, and transportation rights-of-way.',
                'body' => 'Corridor missions capture ROW conditions with nadir and optional oblique passes. Deliverables help asset owners spot encroachment and vegetation pressure along Front Range corridors.',
                'image' => 'https://images.unsplash.com/photo-1487887235947-a955ef187fcc?auto=format&fit=crop&w=1600&q=80',
            ],
            'as-built-aerial' => [
                'title' => 'As-Built Aerial Documentation',
                'summary' => 'Closeout orthos and elevation products that freeze the built condition for the record set.',
                'body' => 'When the job wraps, AeroGrid flies a closeout mission that documents the as-built condition for owners and insurers. Packages typically include orthomosaics, key elevations, and optional mesh exports.',
                'image' => 'https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}
'''
site = re.sub(r'\n    /\*\* @return array.*\n}\s*\Z', catalog, site, flags=re.S)
# fallback if format differs
if 'orthomosaic-mapping' not in site:
    site = re.sub(r'protected function serviceCatalog\(\): array\s*\{.*\}\s*\}\s*\Z', catalog.strip() + '\n', site, flags=re.S)
(root / 'app/Http/Controllers/SiteController.php').write_text(site, encoding='utf-8', newline='\n')
print('SiteController catalog', 'orthomosaic-mapping' in site)

# Fix contact success message
site2 = (root / 'app/Http/Controllers/SiteController.php').read_text(encoding='utf-8')
site2 = site2.replace('Thanks! AeroGrid will follow up', 'Thanks! AeroGrid Survey will follow up')
(root / 'app/Http/Controllers/SiteController.php').write_text(site2, encoding='utf-8', newline='\n')

# --- Rewrite seeder products block ---
seeder = (root / 'database/seeders/DatabaseSeeder.php').read_text(encoding='utf-8')
seeder = seeder.replace("company_email' => 'fly@aerogridsurvey.com'", "company_email' => 'hello@aerogridsurvey.com'")
seeder = seeder.replace("company_email' => 'hello@aerogridsurvey.com'", "company_email' => 'hello@aerogridsurvey.com'")  # noop safe

new_products = r'''$products = [
            ['name' => 'LiPo Flight Battery (TB30-class)', 'sku' => 'BAT-TB30', 'category' => 'battery', 'unit_cost' => 185, 'unit_price' => 0, 'stock_qty' => 24, 'unit' => 'each'],
            ['name' => 'Carbon Prop Pair (2110)', 'sku' => 'PROP-2110', 'category' => 'prop', 'unit_cost' => 28, 'unit_price' => 0, 'stock_qty' => 60, 'unit' => 'pair'],
            ['name' => 'GCP Target Kit (12-pack)', 'sku' => 'GCP-KIT-12', 'category' => 'gcp', 'unit_cost' => 95, 'unit_price' => 180, 'stock_qty' => 14, 'unit' => 'kit'],
            ['name' => 'RTK Base / Rover Day Kit', 'sku' => 'RTK-DAY-1', 'category' => 'rtk', 'unit_cost' => 120, 'unit_price' => 350, 'stock_qty' => 6, 'unit' => 'day'],
            ['name' => 'High-Speed MicroSD 256GB', 'sku' => 'CARD-256', 'category' => 'memory', 'unit_cost' => 42, 'unit_price' => 0, 'stock_qty' => 40, 'unit' => 'each'],
            ['name' => 'Orthomosaic Mapping — Acre Package', 'sku' => 'SVC-ORTHO', 'category' => 'service', 'unit_cost' => 180, 'unit_price' => 650, 'stock_qty' => 999, 'unit' => 'acre'],
            ['name' => 'Topo Survey — Acre Package', 'sku' => 'SVC-TOPO', 'category' => 'service', 'unit_cost' => 220, 'unit_price' => 820, 'stock_qty' => 999, 'unit' => 'acre'],
            ['name' => 'Stockpile Volume Report', 'sku' => 'SVC-VOL', 'category' => 'service', 'unit_cost' => 90, 'unit_price' => 275, 'stock_qty' => 999, 'unit' => 'pile'],
        ];'''

# Replace either array() style or short array style products assignment
seeder2 = re.sub(
    r'\$products\s*=\s*(?:array\s*\(|\[).*?\);\s*\n\s*foreach \(\$products as \$product\)',
    new_products + '\n        foreach ($products as $product)',
    seeder,
    count=1,
    flags=re.S,
)
if seeder2 == seeder:
    print('WARN: products block not replaced')
else:
    seeder = seeder2
    print('products replaced')

# Colorado customers
new_customers = r'''$customers = collect([
            ['name' => 'Riley Hart', 'email' => 'riley@summitcivil.co', 'phone' => '(303) 555-4101', 'company' => 'Summit Civil Engineering', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80202', 'address' => '1600 Blake St'],
            ['name' => 'Morgan Ellis', 'email' => 'morgan@flatironbuilds.com', 'phone' => '(303) 555-4110', 'company' => 'Flatiron Builds GC', 'city' => 'Boulder', 'state' => 'CO', 'zip' => '80301', 'address' => '2940 Pearl Pkwy'],
            ['name' => 'Sam Ortiz', 'email' => 'sam@frontenergy.ops', 'phone' => '(970) 555-4199', 'company' => 'Front Energy ROW', 'city' => 'Fort Collins', 'state' => 'CO', 'zip' => '80525', 'address' => '215 N College Ave'],
            ['name' => 'Taylor Quinn', 'email' => 'taylor.quinn@example.com', 'phone' => '(719) 555-4188', 'company' => null, 'city' => 'Colorado Springs', 'state' => 'CO', 'zip' => '80903', 'address' => '102 S Tejon St'],
            ['name' => 'Avery Kim', 'email' => 'avery@ridgeaggregate.com', 'phone' => '(303) 555-4177', 'company' => 'Ridge Aggregate', 'city' => 'Denver', 'state' => 'CO', 'zip' => '80216', 'address' => '4800 Brighton Blvd'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));'''

seeder3 = re.sub(
    r'\$customers\s*=\s*collect\(\[.*?\])->map\(fn \(\$c\) => Customer::query\(\)->updateOrCreate\(\[\'email\' => \$c\[\'email\'\]\], \$c\)\);',
    new_customers,
    seeder,
    count=1,
    flags=re.S,
)
if seeder3 != seeder:
    seeder = seeder3
    print('customers replaced')
else:
    print('WARN: customers not replaced')

# Fix manager emails / phones if still skydatum remnants
seeder = seeder.replace('manager@skydatum', 'manager@aerogridsurvey')
seeder = seeder.replace('pilot@skydatum', 'pilot@aerogridsurvey')
seeder = seeder.replace('Jordan Hale', 'Jordan Blake')
seeder = seeder.replace('Riley Campos', 'Casey Nguyen')
seeder = re.sub(r"'phone' => '\(512\) 555-0138'", "'phone' => '(303) 555-0100'", seeder, count=1)
seeder = seeder.replace("(512) 555-0138", "(303) 555-0194")

# Tax rate
seeder = seeder.replace("'tax_rate' => '8.25'", "'tax_rate' => '8.31'")
seeder = seeder.replace('* 0.0825', '* 0.0831')
seeder = seeder.replace('* 1.0825', '* 1.0831')

(root / 'database/seeders/DatabaseSeeder.php').write_text(seeder, encoding='utf-8', newline='\n')

# --- Pages ---
(root / 'resources/views/pages/home.blade.php').write_text(r'''@extends('layouts.app')

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
                ['orthomosaic-mapping','Orthomosaic Mapping','Georeferenced site mosaics for planning, as-builts, and stakeholder reviews.','https://images.unsplash.com/photo-1508444845599-5b89963bd43e?auto=format&fit=crop&w=1200&q=80'],
                ['topographic-drone-survey','Topographic Drone Survey','Dense elevation products with contour-ready surfaces for civil design.','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80'],
                ['construction-progress','Construction Progress Captures','Repeatable flight lines that track earthwork and vertical progress week to week.','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3><p>{{ $blurb }}</p></div>
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
            <div class="panel"><h3>RTK &amp; ground control</h3><p>RTK airframes plus surveyed GCPs keep orthomosaics and surfaces locked to your project CRS.</p></div>
            <div class="panel"><h3>ERP-run flight ops</h3><p>Missions, battery/prop inventory, invoices, and appointments live in one stack.</p></div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the AeroGrid ERP used to schedule missions, track flight gear, and close project invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>34</strong> Active missions</div>
                    <div class="metric"><strong>$214k</strong> Pipeline</div>
                    <div class="metric"><strong>98%</strong> On-time deliveries</div>
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
''', encoding='utf-8', newline='\n')

(root / 'resources/views/pages/services.blade.php').write_text(r'''@extends('layouts.app')
@section('title', 'Drone Survey Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">AeroGrid Survey delivers orthomosaic mapping, topographic drone surveys, construction progress captures, stockpile volumetrics, corridor/utility ROW inspection, and as-built aerial documentation across the Colorado Front Range.</p>
        <div class="grid-3">
            @foreach([
                ['orthomosaic-mapping','Orthomosaic Mapping','https://images.unsplash.com/photo-1508444845599-5b89963bd43e?auto=format&fit=crop&w=1200&q=80'],
                ['topographic-drone-survey','Topographic Drone Survey','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80'],
                ['construction-progress','Construction Progress Captures','https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80'],
                ['stockpile-volumetrics','Stockpile Volumetrics','https://images.unsplash.com/photo-1581094794329-adb0d0f1bf4b?auto=format&fit=crop&w=1200&q=80'],
                ['corridor-row-inspection','Corridor / Utility ROW Inspection','https://images.unsplash.com/photo-1487887235947-a955ef187fcc?auto=format&fit=crop&w=1200&q=80'],
                ['as-built-aerial','As-Built Aerial Documentation','https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=1200&q=80'],
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
''', encoding='utf-8', newline='\n')

(root / 'resources/views/pages/about.blade.php').write_text(r'''@extends('layouts.app')
@section('title', 'About AeroGrid Survey')
@section('content')
<section class="section">
    <div class="wrap grid-2">
        <div>
            <h2>Mapping that holds the grid</h2>
            <p class="lede">AeroGrid Survey is a Denver-based SME focused on aerial mapping and photogrammetry for civil, construction, and infrastructure clients along the Front Range. We grew out of pilots who refused to hand over pretty pictures without a known CRS — and that discipline still defines every mission.</p>
            <p class="lede">Our flight crews plan GSD and ground control. Our processing team delivers orthomosaics, DSMs/DTMs, and volume reports. Scheduling, battery inventory, and invoicing live in a unified ERP so project managers get clear timelines and defensible deliverables.</p>
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1527977966376-1c8408f9f108?auto=format&fit=crop&w=1400&q=80" alt="Survey drone prepared for flight" style="width:100%;height:360px;object-fit:cover;border-radius:.4rem;">
        </div>
    </div>
</section>
@endsection
''', encoding='utf-8', newline='\n')

(root / 'resources/views/pages/contact.blade.php').write_text(r'''@extends('layouts.app')
@section('title', 'Contact AeroGrid Survey')
@section('content')
<section class="section">
    <div class="wrap grid-2">
        <div>
            <h2>Contact</h2>
            <p class="lede">Tell us about the site acreage, required GSD, deliverable formats, and whether you need GCPs or RTK-only. We’ll confirm Front Range flight windows and send a written quote.</p>
            <div class="panel">
                <p><strong>Phone:</strong> (303) 555-0194</p>
                <p><strong>Email:</strong> hello@aerogridsurvey.com</p>
                <p><strong>Service area:</strong> Denver, Boulder, Fort Collins, Colorado Springs &amp; Front Range</p>
                <p><strong>WhatsApp:</strong> <a href="https://wa.me/13035550194" target="_blank" rel="noopener">Chat now</a></p>
            </div>
        </div>
        <div class="panel">
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif
            <form class="stack" method="post" action="{{ route('contact.store') }}">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<small style="color:#b91c1c">{{ $message }}</small>@enderror
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<small style="color:#b91c1c">{{ $message }}</small>@enderror
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject" value="{{ old('subject') }}">
                </div>
                <div>
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<small style="color:#b91c1c">{{ $message }}</small>@enderror
                </div>
                <button class="btn btn-primary" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>
@endsection
''', encoding='utf-8', newline='\n')

# ManageSettings defaults
ms = (root / 'app/Filament/Pages/ManageSettings.php').read_text(encoding='utf-8')
ms = ms.replace('fly@aerogridsurvey.com', 'hello@aerogridsurvey.com')
ms = ms.replace('SkyDatum', 'AeroGrid Survey')
if 'AeroGrid Survey' not in ms:
    ms = re.sub(r"getValue\('company_name',\s*'[^']+'\)", "getValue('company_name', 'AeroGrid Survey')", ms)
ms = re.sub(r"getValue\('company_phone',\s*'[^']+'\)", "getValue('company_phone', '(303) 555-0194')", ms)
ms = re.sub(r"getValue\('company_email',\s*'[^']+'\)", "getValue('company_email', 'hello@aerogridsurvey.com')", ms)
ms = re.sub(r"getValue\('whatsapp',\s*'[^']+'\)", "getValue('whatsapp', '13035550194')", ms)
ms = re.sub(r"getValue\('service_area',\s*'[^']+'\)", "getValue('service_area', 'Denver, Boulder, Fort Collins, Colorado Springs & Front Range')", ms)
ms = re.sub(r"getValue\('tax_rate',\s*'[^']+'\)", "getValue('tax_rate', '8.31')", ms)
(root / 'app/Filament/Pages/ManageSettings.php').write_text(ms, encoding='utf-8', newline='\n')

# README SEO line
readme = (root / 'README.md').read_text(encoding='utf-8')
readme = readme.replace(
    'AeroGrid Survey — Laravel 13 + Filament 3 website, ERP & AI for an Austin surveying drone service (topo, orthomosaics, volumetrics, chatbot).',
    'AeroGrid Survey — Laravel 13 + Filament 3 website, ERP, and AI chatbot for US surveying drone services (orthomosaics, topo surveys, construction progress, stockpile volumetrics, corridor inspections).'
)
readme = readme.replace(
    'AeroGrid Survey — Laravel 13 + Filament 3 website, ERP & AI for an Colorado Front Range surveying drone service (topo, orthomosaics, volumetrics, chatbot).',
    'AeroGrid Survey — Laravel 13 + Filament 3 website, ERP, and AI chatbot for US surveying drone services (orthomosaics, topo surveys, construction progress, stockpile volumetrics, corridor inspections).'
)
if 'midnight navy' not in readme:
    readme = readme.replace('custom AeroGrid theme', 'custom AeroGrid theme — midnight navy / sky cyan / signal')
(root / 'README.md').write_text(readme, encoding='utf-8', newline='\n')

# .env.example mail
envex = (root / '.env.example').read_text(encoding='utf-8')
envex = envex.replace('fly@aerogridsurvey.com', 'hello@aerogridsurvey.com')
envex = envex.replace('APP_NAME="SkyDatum Aerial Survey"', 'APP_NAME="AeroGrid Survey"')
if 'APP_NAME="AeroGrid Survey"' not in envex:
    envex = re.sub(r'APP_NAME="[^"]+"', 'APP_NAME="AeroGrid Survey"', envex, count=1)
(root / '.env.example').write_text(envex, encoding='utf-8', newline='\n')
env_path = root / '.env'
if env_path.exists():
    env = env_path.read_text(encoding='utf-8')
    env = env.replace('fly@aerogridsurvey.com', 'hello@aerogridsurvey.com')
    env = re.sub(r'APP_NAME="[^"]+"', 'APP_NAME="AeroGrid Survey"', env, count=1)
    env_path.write_text(env, encoding='utf-8', newline='\n')

print('content finalize done')
