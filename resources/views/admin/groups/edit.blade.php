@extends('admin.template.main')
@section('title', 'Grupos')
@section('sub-title', 'Modificar Grupo')

@section('content')

	{!! Form::open(['route'=>['groups.update', $group], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('name','Nombre:', ['class' => 'control-label col-md-2']) !!}
			<div class="col-md-8">
				{!! Form::text('name', $group->name, ['class'=>'form-control', 'placeholder'=>'Nombre del Grupo', 'autofocus'=>'autofocus', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2	col-md-8">
				{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

@endsection