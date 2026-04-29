@props(['url', 'title', 'description'])

<div class="card">
    <a href="{{ $url }}">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
    </a>
</div>