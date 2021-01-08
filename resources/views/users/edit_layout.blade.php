@if($errors->all())
    <div class="error">
        <span>Se han producido errores en el envío de datos:</span>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Editar Usuario</h2>

{!! Form::model($user, ['id' => 'formulario', 'method' => 'PATCH', 'action' => ['UsersController@update', $user->id], 'files' => true]) !!}
    @csrf

    {!! Form::label('name', 'Nombre'); !!}
    {!! Form::text('name'); !!}

    {!! Form::label('email', 'Email'); !!}
    {!! Form::text('email'); !!}
    
    {!! Form::label('foto', 'Foto Actual'); !!}
    <img class="user__img" src="{{ $user->foto ? '/'.$user->foto->ruta_foto : '/images/default.jpg'}}" />
    {!! Form::label('foto_nueva', 'Foto Nueva (opcional)'); !!}
    <img class="user__img" src="#" id="vista_previa" />
    {!! Form::file('foto_nueva'); !!}

    {!! Form::submit('Editar user'); !!}
    {!! Form::reset('Borrar'); !!}

{!! Form::close() !!}