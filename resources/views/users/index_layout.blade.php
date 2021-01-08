<a id="volver__link" class="icon-back" href="{{ route('users.show', Auth::user()->id) }}"><span>Volver a mi perfil</span></a>

<section>
    <span class="section__name">{{ $section__name }}</span>
    @forelse($users as $user)
        <article>
            @if (Auth::check() && Auth::user()->esAdmin())
                <div class="opciones">
                    {!! Form::open(['method' => 'GET', 'route' => ['users.edit', $user->id]]) !!}
                        @csrf
                        {{ Form::button('', ['type' => 'submit', 'class' => 'icon-edit']) }}
                    {!! Form::close() !!}
                    {!! Form::model($user, ['method' => 'DELETE', 'action' => ['UsersController@destroy', $user->id], 'onsubmit' => 'return confirm("Are you sure you want to delete?")']) !!}
                        @csrf
                        {{ Form::button('', ['type' => 'submit', 'class' => 'icon-delete']) }}
                    {!! Form::close() !!}
                </div>                    
            @endif
            <a class="link__show" href="{{ route('users.show', $user->id) }}">
                <div class="objeto__info">
                    <div class="user__imagen">
                    @if($user->foto)
                        <img class="user__img" src="/{{ $user->foto->ruta_foto }}"/>
                    @else
                        <img class="user__img" src="/images/users/default.jpg"/>
                    @endif
                    </div>
                    <div class="objeto__txt">
                        <h2 class="objeto__titulo">{{ $user->name }}</h2>
                        <h2 class="objeto__titulo">{{ $user->email }}</h2>
                    </div>
                </div>
            </a>                    
        </article>
    @empty
        <p id="objeto__empty">No hay usuarios</p>
    @endforelse

    <div id="paginacion">
        {{ $users->links() }}
    </div>
    
</section>