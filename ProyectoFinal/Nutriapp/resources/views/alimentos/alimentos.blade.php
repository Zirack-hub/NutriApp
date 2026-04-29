@extends('layouts.default')
@section('title', 'Alimentos')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/inicio.css') }}">
@endsection
@section('content')
<ul>
    @forelse($alimentos as $alimento)
        <li><a href="#">{{ $alimento->alimento }}</a></li>
    @empty
        <p>No se han introducido alimentos</p>
    @endforelse
</ul>
@endsection