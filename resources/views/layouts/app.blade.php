<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Windstitch Sail Loft') — Newport Sail Repair</title>
    <meta name="description" content="@yield('meta_description', 'Windstitch Sail Loft provides sail repair, recuts, and marine canvas across Newport and Narragansett Bay.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@500;600;700;800&family=Source+Serif+4:opsz,wght@8..60,400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #12263A;
            --deep: #1E3A5F;
            --accent: #E07A5F;
            --signal: #2A9D8F;
            --steel: #4A6572;
            --fog: #EEF2F6;
            --paper: #EEF2F6;
            --font-display: "Libre Franklin", sans-serif;
            --font-body: "Source Serif 4", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--ink);
            background:
                radial-gradient(1100px 520px at 100% -10%, color-mix(in srgb, var(--deep) 22%, transparent), transparent 55%),
                radial-gradient(820px 440px at 0% 25%, color-mix(in srgb, var(--accent) 16%, transparent), transparent 50%),
                linear-gradient(180deg, #fff 0%, var(--paper) 48%, color-mix(in srgb, var(--fog) 80%, #dfe9ee) 100%);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(12px);
            background: color-mix(in srgb, var(--paper) 92%, transparent);
            border-bottom: 1px solid rgba(11,22,32,.08);
        }
        .nav { display: flex; align-items: center; justify-content: space-between; padding: .95rem 0; gap: 1rem; }
        .brand { font-family: var(--font-display); font-size: 1.35rem; letter-spacing: -0.02em; font-weight: 700; }
        .brand span { color: var(--accent); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .9rem 1.1rem; align-items: center; }
        .nav-links a { color: var(--steel); font-size: .95rem; font-weight: 500; }
        .nav-links a:hover { color: var(--deep); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .8rem 1.25rem; border-radius: .65rem; font-weight: 600; border: 0; cursor: pointer;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: var(--accent); color: #fff; box-shadow: 0 10px 28px color-mix(in srgb, var(--accent) 35%, transparent); }
        .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.35); }
        .btn-dark { background: var(--ink); color: #fff; }
        .hero {
            min-height: calc(100vh - 68px); display: grid; align-items: end; position: relative;
            overflow: hidden; color: #fff;
            background:
                linear-gradient(180deg, rgba(11,22,32,.28) 0%, rgba(11,22,32,.86) 100%),
                url('https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
        }
        .hero-inner { padding: 5rem 0 3.75rem; max-width: 640px; animation: rise .85s ease both; }
        .hero h1 {
            font-family: var(--font-display); font-size: clamp(2.6rem, 6vw, 4.5rem);
            line-height: 1.05; margin: 0 0 1rem; letter-spacing: -0.03em;
        }
        .hero p { font-size: 1.08rem; line-height: 1.6; color: rgba(255,255,255,.9); margin: 0 0 1.5rem; max-width: 36rem; }
        .hero-ctas { display: flex; flex-wrap: wrap; gap: .75rem; }
        .section { padding: 4.5rem 0; }
        .section h2 { font-family: var(--font-display); font-size: clamp(1.9rem, 3.5vw, 2.7rem); margin: 0 0 .75rem; }
        .lede { color: var(--steel); max-width: 40rem; line-height: 1.6; margin: 0 0 2rem; }
        .grid-3 { display: grid; gap: 1.25rem; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-2 { display: grid; gap: 1.5rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .service-tile { position: relative; overflow: hidden; min-height: 280px; color: #fff; isolation: isolate; border-radius: 1.2rem; }
        .service-tile img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; transition: transform .6s ease; }
        .service-tile:hover img { transform: scale(1.06); }
        .service-tile::after { content: ""; position: absolute; inset: 0; z-index: -1; background: linear-gradient(180deg, transparent 25%, rgba(11,22,32,.88)); }
        .service-tile .pad { position: absolute; left: 0; right: 0; bottom: 0; padding: 1.3rem; }
        .service-tile h3 { margin: 0 0 .35rem; font-family: var(--font-display); }
        .service-tile p { margin: 0; color: rgba(255,255,255,.85); font-size: .92rem; }
        .panel { background: rgba(255,255,255,.78); border: 1px solid rgba(11,22,32,.06); padding: 1.4rem; border-radius: 1rem; }
        .panel h3 { margin: 0 0 .5rem; font-family: var(--font-display); }
        .dash-preview { display: grid; gap: 1rem; grid-template-columns: 1.2fr .8fr; background: var(--ink); color: #fff; padding: 1.5rem; border-radius: 1.2rem; overflow: hidden; }
        .metric { padding: 1rem; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08); border-radius: .7rem; }
        .metric strong { display: block; font-size: 1.6rem; color: var(--accent); font-family: var(--font-display); }
        .bars { display: flex; align-items: end; gap: .45rem; height: 140px; margin-top: 1rem; }
        .bars span { flex: 1; border-radius: 4px 4px 0 0; background: linear-gradient(180deg, var(--accent), var(--signal)); animation: grow .9s ease both; }
        form.stack { display: grid; gap: .85rem; }
        label { font-weight: 600; font-size: .9rem; }
        input, textarea, select { width: 100%; padding: .8rem .9rem; border: 1px solid rgba(11,22,32,.14); background: #fff; font: inherit; border-radius: .7rem; }
        .flash { background: color-mix(in srgb, var(--signal) 12%, white); border: 1px solid color-mix(in srgb, var(--signal) 35%, white); color: var(--ink); padding: .9rem 1rem; margin-bottom: 1rem; border-radius: .7rem; }
        .site-footer { background: var(--ink); color: rgba(255,255,255,.78); padding: 2.5rem 0; margin-top: 2rem; }
        .site-footer .brand { margin-bottom: .5rem; color: #fff; }
        .wa-float { position: fixed; right: 1.1rem; bottom: 1.1rem; z-index: 50; width: 56px; height: 56px; border-radius: 999px; display: grid; place-items: center; background: #25d366; color: #fff; font-weight: 800; box-shadow: 0 12px 28px rgba(0,0,0,.25); animation: pulse 2.4s ease infinite; }
        .chat-launcher { position: fixed; right: 1.1rem; bottom: 5rem; z-index: 50; }
        .chat-launcher button { border: 0; background: var(--deep); color: #fff; padding: .75rem 1rem; border-radius: 999px; font-weight: 700; cursor: pointer; box-shadow: 0 12px 28px rgba(0,0,0,.2); }
        .chat-panel { display: none; position: fixed; right: 1.1rem; bottom: 9rem; width: min(360px, calc(100vw - 2rem)); height: 420px; background: #fff; border-radius: 1rem; box-shadow: 0 20px 50px rgba(0,0,0,.25); z-index: 60; flex-direction: column; overflow: hidden; border: 1px solid rgba(11,22,32,.08); }
        .chat-panel.open { display: flex; }
        .chat-head { background: var(--deep); color: #fff; padding: .9rem 1rem; font-weight: 700; }
        .chat-log { flex: 1; overflow: auto; padding: 1rem; display: grid; gap: .6rem; background: #f7fafb; }
        .bubble { padding: .7rem .85rem; border-radius: .8rem; max-width: 85%; font-size: .92rem; line-height: 1.45; }
        .bubble.bot { background: #fff; border: 1px solid rgba(11,22,32,.08); }
        .bubble.user { background: var(--accent); color: #fff; margin-left: auto; }
        .chat-form { display: flex; gap: .4rem; padding: .75rem; border-top: 1px solid rgba(11,22,32,.08); }
        .chat-form input { flex: 1; }
        @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleY(.2); } to { transform: scaleY(1); } }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.06); } }
        @media (max-width: 860px) {
            .grid-3, .grid-2, .dash-preview { grid-template-columns: 1fr; }
            .nav-links { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Wind<span>stitch</span></a>
        <nav class="nav-links">
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog.index') }}">Journal</a>
            <a href="{{ route('knowledge.index') }}">Knowledge</a>
            <a class="btn btn-dark" href="{{ route('contact') }}">Contact</a>
        </nav>
    </div>
</header>
@yield('content')
<footer class="site-footer">
    <div class="wrap">
        <div class="brand">Wind<span>stitch</span> Sail Loft</div>
        <p>23 Commercial Wharf, Newport, RI 02840 · (401) 555-0155 · hello@windstitchloft.example</p>
        <p>Mon–Sat loft hours · rush race repairs by appointment</p>
    </div>
</footer>
<a class="wa-float" href="https://wa.me/14015550155" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>
<div class="chat-launcher"><button type="button" id="chatToggle">Chat</button></div>
<div class="chat-panel" id="chatPanel">
    <div class="chat-head">Windstitch Assistant</div>
    <div class="chat-log" id="chatLog">
        <div class="bubble bot">Hi — ask Windstitch about sail repairs, UV covers, canvas work, or dropping a sail at the Newport loft.</div>
    </div>
    <form class="chat-form" id="chatForm">
        <input id="chatInput" type="text" placeholder="Ask a question..." autocomplete="off">
        <button class="btn btn-primary" type="submit">Send</button>
    </form>
</div>
<script>
(() => {
    const panel = document.getElementById('chatPanel');
    const toggle = document.getElementById('chatToggle');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('chatInput');
    const log = document.getElementById('chatLog');
    const sessionId = 'web-' + Math.random().toString(36).slice(2);
    toggle.addEventListener('click', () => panel.classList.toggle('open'));
    const add = (text, who) => {
        const el = document.createElement('div');
        el.className = 'bubble ' + who;
        el.textContent = text;
        log.appendChild(el);
        log.scrollTop = log.scrollHeight;
    };
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        add(message, 'user');
        input.value = '';
        try {
            const res = await fetch(@json(route('ai.chat')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });
            const data = await res.json();
            add(data.reply || 'Something went wrong.', 'bot');
        } catch (err) {
            add('Network error — please try again or call (401) 555-0155.', 'bot');
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>
