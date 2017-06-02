@extends('admin.template.main')
@section('title', 'Roles')
@section('sub-title')
	{{ 'Asignar rol al usuario: ' . $user->name . ' ' . $user->lastname }}
@endsection

@section('content')

	{!! Form::open(['route'=>['roles.store'], 'method'=>'POST', 'class'=>'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('rol','Rol:', ['class' => 'control-label col-md-2']) !!}
			<div class="col-md-8">
				{!! Form::select('rol_id', $roles, null, ['class'=>'form-control', 'placeholder'=>'Seleccione una opción..', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2	col-md-8">
				{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
				
			</div>
		</div>

		{!! Form::hidden('user_id', $user->id, ['class'=>'form-control', 'placeholder'=>'Extensión del empleado', 'required']) !!}


	{!! Form::close() !!}

@endsection