@extends('layouts.default')
@section('title', 'Alimentos')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/alimentos.css') }}">
@endsection
@section('content')
<a href="{{ route('alimentos.create') }}">Crear nuevos alimentos</a>
<table>
    @forelse($alimentos as $alimento)
        <th><a href="{{ route('alimentos.edit', ['alimento'=>$alimento->id]) }}">{{ $alimento->alimento }}</a></th>
        <th><form method="POST" action="{{ route('alimentos.destroy', $alimento->id) }}">
                @csrf
                @method('DELETE')
                <input type="submit" value="DELETE">
            </form>
        </th>
    @empty
        <p>No se han introducido alimentos</p>
    @endforelse
</table>
@endsection