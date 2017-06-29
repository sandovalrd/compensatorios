@extends('admin.template.main')
@section('title', 'Grupos')
@section('sub-title', 'Nuevo Grupo')

@section('content')

	{!! Form::open(['route'=>'groups.store', 'method'=>'POST', 'class'=>'form-horizontal']) !!}

		<div class="form-group">
			{!! Form::label('name','Nombre:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre del Grupo', 'autofocus'=>'autofocus', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-3	col-md-7">
				{!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

@endsection