@extends('admin.template.main')
@section('title', 'Roles')
@section('sub-title')
	{{ 'Cambiar estatus de la guardia de ' . $user->name . ' ' . $user->lastname }}
@endsection

@section('content')

	{!! Form::open(['route'=>['guardia.update', $user], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('rol','Rol:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-6">
				{!! Form::select('estatus_id', $estatus, null, ['class'=>'form-control', 'placeholder'=>'Seleccione una opción..', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-3	col-md-6">
				{!! Form::submit('Aceptar', ['class' => 'btn btn-primary']) !!}
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

		{!! Form::hidden('user_id', $user->id, ['class'=>'form-control', 'placeholder'=>'Extensión del empleado', 'required']) !!}


	{!! Form::close() !!}

@endsection