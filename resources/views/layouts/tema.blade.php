@php($show = $show ?? false)

<div class="tema">
	<div class="div__left">
		<span class="votos__count">{{ $tema->likes->count() }}</span>
		<span class="votos__name">Votos</span>
		<span class="votos__count">{{ $tema->comentarios->count() }}</span>
		<span class="votos__name">Respuestas</span>
		@if($show)
			<a href="#" onclick="return likeClick({{ $tema->id }}, 3, {{$contador}})">
				@if (Auth::check() && in_array(Auth::user()->id, $tema->likes->pluck('user_id')->all()))
					@php($like_style = "color: red")
				@else
					@php($like_style = '')
				@endif
				<span id="likes__numero__{{$contador}}" class="likes__numero votos__count" style='{{ $like_style }}'>{{ $tema->likes->count() }}</span>
				<span id="likes__icon__{{$contador}}" class="icon-like votos__name" style='{{ $like_style }}'></span>				
			</a>
		@endif
	</div>
	<div class="div__right">
		<div class="user__heading">
			<a href="{{ route('users.show', $tema->user->id) }}">
				@if($tema->user->foto)
					<img src="/{{ $tema->user->foto->ruta_foto }}">
				@else
					<img src="/images/users/default.jpg">
				@endif
			</a>
			<a href="{{ route('users.show', $tema->user->id) }}"><span class="user__name">{{ $tema->user->name }}</span></a>
			<span>preguntó hace {!! Helper::formatoTiempo($tema->created_at) !!}</span>
		</div>
		<div class="tema__asunto">
			@if($show)
				<span>{{ $tema->asunto }}</span>
			@else
				<a href="{{ route('temas.show', $tema->id) }}">{{ $tema->asunto }}</a>
			@endif
		</div>
		<div class="categorias">
			@foreach($tema->categorias as $categoria)
				<a href="{{ route('temas.categoria', $categoria->id) }}">{{$categoria->nombre}}</a>
			@endforeach
		</div>
		@if($show)
			<br />
			<div class="tema__contenido">
				<p class="contendio__txt">{!! nl2br(e($tema->contenido)) !!}</p>
				@if($tema->foto)
					<img src="/{{ $tema->foto->ruta_foto }}">
				@endif
			</div>
		@endif
	</div>                    
</div>