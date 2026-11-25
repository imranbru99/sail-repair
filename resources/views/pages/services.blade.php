@extends('layouts.app')
@section('title', 'Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">Windstitch handles sail repairs, recuts, UV covers, batten work, canvas dodgers/biminis, and sail washing/storage across Newport and Narragansett Bay.</p>
        <div class="grid-3">
            @foreach([
                ['sail-repair','Sail Repair','https://images.unsplash.com/photo-1505118380757-91f5f5632de0?auto=format&fit=crop&w=1600&q=80'],
                ['recut-shape','Recut & Shape','https://images.unsplash.com/photo-1530053969600-caed2596d242?auto=format&fit=crop&w=1600&q=80'],
                ['uv-cover','UV Covers','https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?auto=format&fit=crop&w=1600&q=80'],
                ['batten-work','Batten Pockets & Battens','https://images.unsplash.com/photo-1468413253725-0d5181091126?auto=format&fit=crop&w=1600&q=80'],
                ['canvas-dodger','Canvas Dodgers & Biminis','https://images.unsplash.com/photo-1540946485063-a40bc277dc44?auto=format&fit=crop&w=1600&q=80'],
                ['wash-storage','Sail Wash & Storage','https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80'],
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
