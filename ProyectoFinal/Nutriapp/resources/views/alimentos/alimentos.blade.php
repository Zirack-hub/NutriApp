@extends('layouts.default')
@section('title', 'Alimentos')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/alimentos.css') }}">
@endsection
@section('content')
<table>
    @forelse($alimentos as $alimento)
        <th><a href="#">{{ $alimento->alimento }}</a></th>
    @empty
        <p>No se han introducido alimentos</p>
    @endforelse
</table>
@endsection