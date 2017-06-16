@extends('admin.template.main')
@section('title', 'Guardia')
@section('sub-title')
	{{ 'Editar Guardia: ' . $user->name . ' '. $user->lastname }}
@endsection

@section('content')

	{!! Form::open(['route'=>['guardias.update', $guardia], 'method'=>'PUT', 'class'=>'form-horizontal']) !!}

		

		<div class="form-group">
			{!! Form::label('day','Días de compensatorio:', ['class' => 'control-label col-md-4']) !!}
			<div class="col-md-4">
				{!! Form::text('days', $guardia->days, ['class'=>'form-control', 'placeholder'=>'Nombre del Grupo', 'autofocus'=>'autofocus', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-4	col-md-4">
				{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

		
	{!! Form::close() !!}

@endsection