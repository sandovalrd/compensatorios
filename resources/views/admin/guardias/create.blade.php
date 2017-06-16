@extends('admin.template.main')
@section('title', 'Guardia')
@section('sub-title')
	{{ 'Nueva Guardia: ' . $group->name  }}
@endsection

@section('content')

	{!! Form::open(['route'=>'guardias.store', 'method'=>'POST', 'class'=>'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('username','Indicador:', ['class' => 'control-label col-md-4']) !!}
			<div class="col-md-4">
				{!! Form::select('users', $users, null, [ 'id'=>'user', 'class'=>'form-control select-users', 'placeholder'=>'Seleccione una opción..', 'name'=>'user_id', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('day','Días de compensatorio:', ['class' => 'control-label col-md-4']) !!}
			<div class="col-md-4">
				{!! Form::text('days', 2, ['class'=>'form-control', 'placeholder'=>'Nombre del Grupo', 'autofocus'=>'autofocus', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-4	col-md-4">
				{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

		{!! Form::hidden('group_id', $group->id, ['class'=>'form-control', 'placeholder'=>'Extensión del empleado', 'required']) !!}

	{!! Form::close() !!}

@endsection
