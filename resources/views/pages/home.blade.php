@extends('layouts.app')

@section('title', 'Windstitch Sail Loft')
@section('meta_description', 'Panel repairs, UV covers, recuts, and canvas work for Newport sailors who need race-week turnarounds and cruising durability.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>Windstitch<br>Sail Loft</h1>
        <p>Panel repairs, UV covers, recuts, and canvas work for Newport sailors who need race-week turnarounds and cruising durability.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Drop a sail for quote</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">Explore loft services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">Windstitch handles sail repairs, recuts, UV covers, batten work, canvas dodgers/biminis, and sail washing/storage across Newport and Narragansett Bay.</p>
        <div class="grid-3">
            @foreach([
                ['sail-repair','Sail Repair','Seams and panels that hold under load.','https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=1600&q=80'],
                ['uv-cover','UV Covers','Leech protection for furling genoas.','https://images.unsplash.com/photo-1530053969600-caed2596d242?auto=format&fit=crop&w=1600&q=80'],
                ['canvas-dodger','Canvas Work','Dodgers and biminis stitched for Bay weather.','https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?auto=format&fit=crop&w=1600&q=80'],
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
        <h2>Why Windstitch</h2>
        <p class="lede">Loft stitchers who read cloth bias, batten pockets, and UV damage before they quote a patch.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Race-week urgency</h3>
                <p>Priority slots for ripped leeches and blown seams before Saturday starts.</p>
            </div>
            <div class="panel">
                <h3>Cloth-matched repairs</h3>
                <p>We match weight and weave so patches last more than one season.</p>
            </div>
            <div class="panel">
                <h3>ERP-run loft</h3>
                <p>Sail jobs, cloth inventory, invoices, and pickup appointments in one stack.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the Windstitch ERP used to dispatch crews, track inventory, and close invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>21</strong> Sails in loft</div>
                    <div class="metric"><strong>$74k</strong> Loft pipeline</div>
                    <div class="metric"><strong>33</strong> Cloth SKUs</div>
                </div>
                <div class="bars">
                    <span style="height:45%"></span><span style="height:70%"></span><span style="height:55%"></span>
                    <span style="height:85%"></span><span style="height:60%"></span><span style="height:92%"></span>
                    <span style="height:68%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);margin-top:0">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Customers & jobs</li>
                    <li>Inventory / products</li>
                    <li>Invoices & payments</li>
                    <li>Appointments</li>
                    <li>AI Studio & chatbot logs</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the journal</h2>
        <p class="lede">Practical notes for customers and crews.</p>
        <div class="grid-3">
            @foreach($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
