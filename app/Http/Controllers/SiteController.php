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

        return back()->with('success', 'Thanks! SkyDatum will follow up within one business day.');
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
        return array (
  'topographic-mapping' => 
  array (
    'title' => 'Topographic Drone Mapping',
    'summary' => 'Survey-grade GCPs, dense point clouds, and CAD-ready contours for design teams.',
    'body' => 'SkyDatum flies Central Texas sites with RTK/PPK workflows and ground control so civil engineers get contours and breaklines they can trust — not pretty pictures alone.',
    'image' => 'https://images.unsplash.com/photo-1527979809429-b4bb5c0c0f1c?auto=format&fit=crop&w=1600&q=80',
  ),
  'construction-orthomosaic' => 
  array (
    'title' => 'Construction Progress Orthomosaics',
    'summary' => 'Repeatable flight plans for weekly or monthly progress basemaps.',
    'body' => 'GCs and owners compare week-over-week orthos in the same CRS. We lock flight lines and camera settings so change detection stays honest through the Austin build season.',
    'image' => 'https://images.unsplash.com/photo-1531834685032-c34bfa9ee8b2?auto=format&fit=crop&w=1600&q=80',
  ),
  'corridor-row' => 
  array (
    'title' => 'Corridor & ROW Surveys',
    'summary' => 'Linear mapping for roads, utilities, and right-of-way documentation.',
    'body' => 'Long corridors need consistent altitude and overlap. SkyDatum delivers georeferenced mosaics and extracted centerlines for roadway and utility ROW packages.',
    'image' => 'https://images.unsplash.com/photo-1464037866556-68135799b824?auto=format&fit=crop&w=1600&q=80',
  ),
  'stockpile-volumetrics' => 
  array (
    'title' => 'Stockpile Volumetrics',
    'summary' => 'Cubic-yard inventories for aggregates, spoils, and quarry faces.',
    'body' => 'We fly stockyards and pits, build surface models, and report volumes with the assumptions your auditors want documented — base surfaces included.',
    'image' => 'https://images.unsplash.com/photo-1565008576549-57569a49371d?auto=format&fit=crop&w=1600&q=80',
  ),
  'as-built-capture' => 
  array (
    'title' => 'As-Built Aerial Capture',
    'summary' => 'Post-construction aerials for as-built plan overlays and closeout packages.',
    'body' => 'When punch lists close, SkyDatum captures the site so as-built drawings and BIM models share the same aerial truth for Central Texas closeouts.',
    'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1600&q=80',
  ),
  'utility-inspection' => 
  array (
    'title' => 'Utility Corridor Inspection',
    'summary' => 'Visual inspection flights for transmission, pipeline, and solar corridors.',
    'body' => 'Pilots capture high-resolution stills and video along linear assets, tagging anomalies for field crews — faster than walking every mile in Texas heat.',
    'image' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?auto=format&fit=crop&w=1600&q=80',
  ),
);
    }
}