@extends('layouts.app')
@section('title', 'Contact Windstitch')
@section('content')
<section class="section">
    <div class="wrap grid-2">
        <div>
            <h2>Contact</h2>
            <p class="lede">Call (401) 555-0155, WhatsApp, or send a note — Newport, RI crews are ready.</p>
            <div class="panel">
                <p><strong>Phone:</strong> (401) 555-0155</p>
                <p><strong>Email:</strong> hello@windstitchloft.example</p>
                <p><strong>Address:</strong> 23 Commercial Wharf, Newport, RI 02840</p>
                <p><strong>Hours:</strong> Mon–Sat loft hours · rush race repairs by appointment</p>
            </div>
        </div>
        <div>
            @if(session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif
            <form class="stack" method="post" action="{{ route('contact.store') }}">
                @csrf
                <div>
                    <label>Name</label>
                    <input name="name" value="{{ old('name') }}" required>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label>Phone</label>
                    <input name="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label>Subject</label>
                    <input name="subject" value="{{ old('subject') }}">
                </div>
                <div>
                    <label>Message</label>
                    <textarea name="message" rows="5" required>{{ old('message') }}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>
@endsection
