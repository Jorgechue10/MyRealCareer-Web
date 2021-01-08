<a id="volver__link" class="icon-back" href="{{ route('users.show', Auth::user()->id) }}"><span>Volver a mi perfil</span></a>

<section>
        <span class="section__name">{{ $section__name }}</span>
        @forelse($temas as $tema)
            <article>
                @if (Auth::check() && Auth::user()->esAdmin())
                    <div class="opciones">
                        {!! Form::open(['method' => 'GET', 'route' => ['temas.edit', $tema->id]]) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-edit']) }}
                        {!! Form::close() !!}
                        {!! Form::model($tema, ['method' => 'DELETE', 'action' => ['TemasController@destroy', $tema->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                            @csrf
                            {{ Form::button('', ['type' => 'submit', 'class' => 'icon-delete']) }}
                        {!! Form::close() !!}
                    </div>                    
                @endif
                
                @include("../layouts.tema")
            </article>
        @empty
            <p id="objeto__empty">No hay temas para leer</p>
        @endforelse
    </section>
    <div id="paginacion">
        {{ $temas->links() }}
    </div>
</section>