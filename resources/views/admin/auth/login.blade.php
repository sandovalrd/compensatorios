@extends('admin.template.main')
@section('title', 'Login')
@section('sub-title', 'Iniciar Sesión')

@section('content')

	<div class="panel panel-default col-md-offset-3	col-md-6">
		<div class="panel-body">
		<br>
		{!! Form::open(['route'=> 'login', 'method' => 'POST', 'class'=>'form-horizontal']) !!}

			<div class="form-group">
				{!! Form::label('username', "Indicador:", ['class' => 'control-label col-md-2']) !!}
				<div class="col-md-9">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						{!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=> 'Introduzca el indicador', 'required']) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
			

				{!! Form::label('password', "Password:", ['class' => 'control-label col-md-2']) !!}
				<div class="col-md-9">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						{!! Form::password('password', ['class' => 'form-control', 'placeholder' => '*************', 'required']) !!}
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2	col-md-9">
					{!! Form::submit('Acceder', ['class'=>'btn btn-primary']) !!}
				</div>
			</div>

		{!! Form::close() !!}
		</div>
	</div>

@endsection