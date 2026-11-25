<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'sail repair seam leech patch newport',
            'a' => 'Windstitch repairs seams, corners, and panels with matched cloth. Call (401) 555-0155 to drop a sail.',
        ],
        [
            'q' => 'uv cover furling genoa sunbrella',
            'a' => 'We measure and stitch UV covers for furling genoas to protect leeches through summer.',
        ],
        [
            'q' => 'recut shape draft luff curve',
            'a' => 'Aging sails with life left can be recut for better shape — we evaluate on the loft floor.',
        ],
        [
            'q' => 'canvas dodger bimini window',
            'a' => 'Dodgers, biminis, and windows get marine canvas repairs or replacements.',
        ],
        [
            'q' => 'wash storage mildew bag',
            'a' => 'End-of-season wash, inspect, and labeled storage so spring is mildew-free.',
        ],
        [
            'q' => 'newport middletown bristol service area',
            'a' => 'Windstitch serves Newport, Middletown, Bristol, Jamestown, and Narragansett Bay sailors.',
        ],
        [
            'q' => 'race week rush repair',
            'a' => 'Priority slots available for ripped leeches and blown seams before Saturday starts.',
        ],
        [
            'q' => 'schedule appointment drop sail',
            'a' => 'Use the contact form or call (401) 555-0155 with sail type, damage notes, and pickup timing.',
        ],
    ];

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
            'blog' => "Write a concise SEO blog post outline and intro for a water damage restoration company about: {$prompt}",
            'description' => "Write a compelling service description for water damage restoration: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a water damage restoration SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this water restoration operations issue with clear steps: {$prompt}",
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

        return 'Thanks for reaching Windstitch Sail Loft. We repair sails and canvas for Newport and Narragansett Bay sailors. Call (401) 555-0155.';
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
                        'content' => 'You are the Windstitch Sail Loft assistant for a Newport, RI sail repair loft. Be concise about sail repairs, UV covers, canvas, and loft logistics. Never invent unsafe rigging advice.',
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
                            ['text' => "You are the Windstitch Sail Loft assistant for a Newport, RI sail repair loft. Be concise about sail repairs, UV covers, canvas, and loft logistics. Never invent unsafe rigging advice.
{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}