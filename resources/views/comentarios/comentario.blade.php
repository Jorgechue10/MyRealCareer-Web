<div class="comentario">
	<div class="cabecera">
		<a href="{{ route('users.show', $comentario->user->id) }}">
			@if($comentario->user->foto)
				<img src="/{{ $comentario->user->foto->ruta_foto }}"/>
			@else
				<img src="/images/users/default.jpg"/>
			@endif
		</a>
		<a href="{{ route('users.show', $comentario->user->id) }}"><span class="user__name">{{ $comentario->user->name }}</span></a>
		<span class="fecha">{{ date('d/m/Y \a \l\a\s H:i:s', strtotime($comentario->created_at)) }}</span>
	</div>
	<div class="div__body">
		<div class="likes">
			<a href="#" onclick="return likeClick({{ $comentario->id }}, 4, {{$contador}})">
				@if (Auth::check() && in_array(Auth::user()->id, $comentario->likes->pluck('user_id')->all()))
					<span id="likes__icon__{{$contador}}" class="icon-like" style="color: red"></span>
					<span id="likes__numero__{{$contador}}" class="likes__numero" style="color: red">{{ $comentario->likes->count() }}</span>
				@else
					<span id="likes__icon__{{$contador}}" class="icon-like"></span>
					<span id="likes__numero__{{$contador}}" class="likes__numero">{{ $comentario->likes->count() }}</span>
				@endif
			</a>
		</div>
		<div class="div__contenido">
			<p class="contenido__txt">{!! nl2br(e($comentario->contenido)) !!}</p>

			@if ($comentario->parent_id === 0)
				<button class="btn_comentario" onclick="mostrarComentarios({{ $contador }})">
					@if ($comentario->respuestas->count() === 0)
						Añadir comentario
					@else
						Mostrar respuestas({{ $comentario->respuestas->count() }})
					@endif
				</button>
				<div id="respuesta__{{ $contador }}" class="respuesta" style="display:none">
					@foreach ($comentario->respuestas as $respuesta)
						@php($contador++)
						@include("../comentarios.comentario", ['comentario' => $respuesta])
					@endforeach
					<h2>Responder en el hilo</h2>
					{!! Form::open(['method' => 'POST']) !!}
						@csrf
						{{ Form::hidden('parent_id', $comentario->id) }}
						{{ Form::textarea('contenido', null, array('placeholder' => 'Escribe una respuesta...')) }}
						{{ Form::submit('Publicar Respuesta') }}
					{!! Form::close() !!}
				</div>
			@endif
		</div>
	</div>                
</div>