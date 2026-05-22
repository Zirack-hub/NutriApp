@extends('layouts.default')
@section('title', 'Mis Comentarios de Retroalimentación')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/comentarios.css') }}">    
@endsection

@section('content')
<x-navegacion>
    <a href="{{ route('inicio') }}" class="nav-brand">INICIO</a>
    <div class="nav-spacer"></div>
    <a href="{{ route('alimentos') }}" class="nav-link">ALIMENTOS</a>
    <a href="{{ route('dietas') }}" class="nav-link">DIETAS</a>
</x-navegacion>

<div class="container">
    <div class="dashboard">
        <h1 class="title">Buzón de Retroalimentación 📬</h1>
        <p class="objetivo">Aquí tienes las correcciones y anotaciones que el profesor ha realizado sobre tus planificaciones nutricionales.</p>
        
        <div class="comentarios-list">
            @if($dietasConComentarios->isNotEmpty())
                @foreach($dietasConComentarios as $dieta)
                    <div class="comentario-card">
                        <div class="comentario-meta">
                            <a href="{{ route('dietas.show', $dieta->id) }}" class="comentario-dieta-name">
                                📋 Dieta: {{ $dieta->nombre }}
                            </a>
                        </div>
                        
                        <div class="comentario-texto">
                            "{!! nl2br(e($dieta->comentario)) !!}"
                        </div>
                        
                        <div class="comentario-action" style="display: flex; justify-content: space-between; align-items: center; margin-top: 14px; gap: 10px;">
                            
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <span style="color: #7a9a6a; font-size: 0.85em; font-weight: 600;">
                                    👤 Enviado por: Admin
                                </span>

                                @if(!$dieta->comentario_leido)
                                    <form action="{{ route('alumno.comentarios.visto', $dieta->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: linear-gradient(135deg, #a8e063, #4e6b4e); padding: 6px 14px; font-size: 0.8em; border-radius: 10px; border: none; cursor: pointer; color: white; font-weight: bold; font-family: inherit;">
                                            Marcar como leído
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <a href="{{ route('dietas.show', $dieta->id) }}" class="btn-ir-dieta">
                                Ver Dieta →
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="comentarios-empty">
                    <span class="comentarios-empty-icon">☕</span>
                    <h3>¡Todo al día por aquí!</h3>
                    <p>Aún no tienes comentarios o revisiones registradas por tus profesores en tus dietas actuales.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection