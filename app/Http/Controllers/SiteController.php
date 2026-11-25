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

        return back()->with('success', 'Thanks! Windstitch will follow up within one business day.');
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
            'sail-repair' => [
                'title' => 'Sail Repair',
                'summary' => 'Seams, corners, leech tapes, and panel patches.',
                'body' => 'Windstitch inspects cloth, restitches load paths, and patches with matched weight so Newport race sails survive the next start.',
                'image' => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=1600&q=80',
            ],
            'recut-shape' => [
                'title' => 'Recut & Shape',
                'summary' => 'Luff curve and draft adjustments for aging sails.',
                'body' => 'We evaluate shape on the loft floor and recut where cloth still has life — cheaper than a premature new sail.',
                'image' => 'https://images.unsplash.com/photo-1530053969600-caed2596d242?auto=format&fit=crop&w=1600&q=80',
            ],
            'uv-cover' => [
                'title' => 'UV Covers',
                'summary' => 'Sunbrella and acrylic covers for furling genoas.',
                'body' => 'UV covers get measured and stitched to protect leeches through Rhode Island summers.',
                'image' => 'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?auto=format&fit=crop&w=1600&q=80',
            ],
            'batten-work' => [
                'title' => 'Batten Pockets & Battens',
                'summary' => 'Pocket repairs and batten replacements.',
                'body' => 'Broken battens and torn pockets are rebuilt so mains set cleanly without flutter.',
                'image' => 'https://images.unsplash.com/photo-1468413253725-0d5181091126?auto=format&fit=crop&w=1600&q=80',
            ],
            'canvas-dodger' => [
                'title' => 'Canvas Dodgers & Biminis',
                'summary' => 'Marine canvas repairs and replacements.',
                'body' => 'Dodgers, biminis, and cockpit covers get loft attention with marine-grade thread and hardware.',
                'image' => 'https://images.unsplash.com/photo-1540946485063-a40bc277dc44?auto=format&fit=crop&w=1600&q=80',
            ],
            'wash-storage' => [
                'title' => 'Sail Wash & Storage',
                'summary' => 'End-of-season wash, flake, and labeled storage.',
                'body' => 'We wash, inspect, and tag sails so spring commissioning is not a mildew surprise.',
                'image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}