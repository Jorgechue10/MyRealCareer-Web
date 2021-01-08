@php($contador = 0)
<div id="comentarios">
    <h2>{{ $objeto->comentarios->count() }} Comentarios</h2>
    @forelse ($objeto->comentarios as $comentario)
        @php($contador++)
        @include("../comentarios.comentario")
        @php($contador += $comentario->respuestas->count())        
    @empty
        <p>Este tema no tiene comentarios</p>
    @endforelse
    <h2 id="pulicar_comentario">Publicar Comentario</h2>
    {!! Form::open(['method' => 'POST']) !!}
        @csrf
        {{ Form::textarea('contenido', null, array('placeholder' => 'Escribe un comentario...')) }}
        {{ Form::submit('Publicar Comentario') }}
    {!! Form::close() !!}
</div>