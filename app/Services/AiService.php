<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = array (
  0 => 
  array (
    'q' => 'topographic mapping drone contours gcp rtk point cloud',
    'a' => 'SkyDatum topographic flights use RTK/PPK with ground control to deliver CAD-ready contours and point clouds for Central Texas design teams. Call (512) 555-0138.',
  ),
  1 => 
  array (
    'q' => 'orthomosaic construction progress weekly monthly',
    'a' => 'Progress orthomosaics use locked flight plans so week-over-week comparisons share the same CRS and altitude for GCs and owners.',
  ),
  2 => 
  array (
    'q' => 'corridor row roadway utility linear mapping',
    'a' => 'Corridor and ROW surveys deliver georeferenced mosaics and extracted centerlines for roads and utilities.',
  ),
  3 => 
  array (
    'q' => 'stockpile volumetrics cubic yard quarry aggregate',
    'a' => 'Stockpile volumetrics report cubic yards with documented base surfaces so materials yards can audit inventories.',
  ),
  4 => 
  array (
    'q' => 'as-built aerial capture closeout bim',
    'a' => 'As-built aerial capture supports plan overlays and BIM closeout packages after construction punch lists close.',
  ),
  5 => 
  array (
    'q' => 'utility inspection transmission pipeline solar corridor',
    'a' => 'Utility corridor inspection flights capture high-res stills and video with anomaly tags for field crews.',
  ),
  6 => 
  array (
    'q' => 'schedule quote austin round rock san marcos georgetown cost price',
    'a' => 'Call (512) 555-0138, use the contact form, or WhatsApp. We serve Austin, Round Rock, San Marcos, Georgetown, and Central Texas. Pricing depends on acreage, GCPs, and processing rush.',
  ),
  7 => 
  array (
    'q' => 'turnaround deliverable how long processing ortho',
    'a' => 'Typical processing is a few business days after a successful flight; rush 24h processing is available. Weather can shift flight days — we notify early.',
  ),
);

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a surveying drone service business about: {$prompt}",
            'description' => "Write a compelling service description for surveying drone service: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a surveying drone service SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this surveying drone service operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching SkyDatum Aerial Survey. We provide topographic drone mapping, construction orthomosaics, corridor ROW surveys, stockpile volumetrics, as-built capture, and utility inspections across Central Texas. Ask about scope, timelines, or scheduling—or call (512) 555-0138.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the SkyDatum Aerial Survey assistant for an Austin, TX surveying drone service. Be concise about topographic mapping, orthomosaics, corridor ROW, stockpile volumetrics, as-built capture, utility inspection, and scheduling. Never invent FAA approvals or survey licenses.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "SkyDatum Aerial Survey assistant (Austin / Central Texas surveying drone service). Answer briefly:
{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}