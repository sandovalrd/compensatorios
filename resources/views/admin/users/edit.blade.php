@extends('admin.template.main')
@section('title', 'Empleados')
@section('sub-title', 'Nuevo Empleado')

@section('content')

	{!! Form::open(['route'=>['users.update', $user], 'method'=>'PUT', 'class'=>'form-horizontal', 'id'=>'form']) !!}

		<div class="form-group">
			{!! Form::label('username','Indicador:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('username', $user->username, ['class'=>'form-control', 'placeholder'=>'Indicador de Red', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('name','Nombre:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::text('name', $user->name, ['class'=>'form-control', 'placeholder'=>'Nombre del empleado', 'required']) !!}
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
			{!! Form::label('group','Grupo:', ['class' => 'control-label col-md-3']) !!}
			<div class="col-md-7">
				{!! Form::select('group_id', $groups, $user->group_id, ['class'=>'form-control', 'placeholder'=>'Seleccione una opción..', 'required']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-3	col-md-7">
				{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
			
				{!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-primary']) !!}
			</div>
		</div>

	{!! Form::close() !!}

@endsection

@section('script')
	<<script>
		$(function(){
		   $("#username").blur(function(){
		   		var form = $(this).parents('form');
				var url = form.attr('action');
				var data = form.serialize();
				var username = $('#username').val();	
    			
  				if(username!=""){
  					bloqueaControl('username');
					buscandoInicio('name');
  					buscandoInicio('lastname');
  					buscandoInicio('ext');
  					buscandoInicio('phone');
					$.post(url, data, function(result){


				       	$('#name').val(result.name);
				       	$('#lastname').val(result.lastname);
				       	$('#ext').val(result.ext);
				       	$('#phone').val(result.phone);

				       	buscandoFin('username');
				       	buscandoFin('name');
				       	buscandoFin('lastname');
				       	buscandoFin('ext');
				       	buscandoFin('phone');

				       	if(result.name==""){
				       		alert('Usuario no existe en el Ldap');
				       		$("#name").focus();
				       	}else if(result.lastname==null){
				       		$("#lastname").focus();
				       	}else if(result.ext==null){
				       		$("#ext").focus();
				       	}else if(result.phone==null){
							$("#phone").focus();
						}else{
							$("#group").focus();
						}
					}).fail(function(){
					    alert('Hubo un error en la busqueda en el Ldap');
					    buscandoFin('username');
				       	buscandoFin('name');
				       	buscandoFin('lastname');
				       	buscandoFin('ext');
				       	buscandoFin('phone');
					});

  				}

		   });
		});

		function bloqueaControl(control)
		{
		    $('#'+control).prop('disabled', true);
		}
		function buscandoInicio(control)
		{
		    $('#'+control).val('Buscando	...');
		    bloqueaControl(control);
		}
		function buscandoFin(control)
		{
		    $('#'+control).prop('disabled', false);
		}

	</script>
@endsection