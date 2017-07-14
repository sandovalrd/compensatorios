@extends('admin.template.main')
@section('title', 'Login')
@section('sub-title', 'Iniciar Sesión')

@section('content')

	<div class="col-md-offset-3 col-md-6">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<h4 class="text-info text-center">Sistema de Compensatorios AIT</h4>
			</div>
			<div class="panel-body">

			<br>
			{!! Form::open(['route'=> 'login', 'method' => 'POST', 'class'=>'form-horizontal']) !!}

				<div class="form-group">
					{!! Form::label('username', "Indicador:", ['class' => 'control-label col-md-2']) !!}
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
							{!! Form::text('username', null, ['class' => 'form-control', 'placeholder'=> 'Introduzca el indicador', 'autofocus'=>'autofocus','required']) !!}
						</div>
					</div>
				</div>
				<div class="form-group">
				

					{!! Form::label('password', "Password:", ['class' => 'control-label col-md-2']) !!}
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
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
	</div>

@endsection