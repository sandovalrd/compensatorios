@extends('admin.template.main')
@section('title', 'Empleados')
@section('sub-title', 'Editar Perfil')

@section('content')

	{!! Form::open(['route'=>['perfil.update', $user], 'method'=>'PUT', 'class'=>'form-horizontal', 'id'=>'form']) !!}


		<div class="form-group">
			{!! Form::label('name','Nombre:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('name', $user->name, ['class'=>'form-control', 'placeholder'=>'Nombre del empleado', 'autofocus'=>'autofocus','required']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('lastname','Apellido:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('lastname', $user->lastname, ['class'=>'form-control', 'placeholder'=>'Apellido del empleado', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('ext','Extensión:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('ext', $user->ext, ['class'=>'form-control', 'placeholder'=>'Extensión del empleado', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('phone','Teléfono:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('phone', $user->phone, ['class'=>'form-control', 'placeholder'=>'Teléfono del empleado', 'required']) !!}
			</div>
		</div>


		<div class="form-group">
			<div class="col-md-offset-3	col-md-7">
				{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
			
				<a href="{{ route('home') }}" class="btn btn-primary">Cancel</a>
			</div>
		</div>

	{!! Form::close() !!}

@endsection

