<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! AeroGrid will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

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
