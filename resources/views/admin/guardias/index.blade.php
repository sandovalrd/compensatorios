@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title', 'Orden de Guardias por grupo de trabajo')

@section('content')
	<div class="row">
		<div class="form-inline col-md-10">
			{!! Form::open(['route'=>'guardias.index', 'method'=>'GET']) !!}
				{!! Form::select('group', $groups, $group_id, [ 'id'=>'group', 'class'=>'form-control select-group', 'placeholder'=>'Seleccione una opción..', 'onchange'=>'this.form.submit()', 'name'=>'group_id']) !!}
			{!! Form::close() !!}
		</div>
	</div>
	{!! Form::open(['route'=>['guardias.getChange'], 'method'=>'GET', 'id'=>'form']) !!}
	{!! Form::close() !!}
	<hr>
	<div class="row">
		<div class="col-md-offset-0 col-md-12">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Fecha próxima Guardia</th>
					<th>Días</th>
					<th class="text-center" width="90px">Orden</th>
					<th class="text-center" width="160px">Acción</th>
				</thead>
				<tbody id='tabla'>
					@foreach($guardias as $guardia)
						<tr>
							@php
								$fecha = Date::createFromFormat('Y-m-d', $guardia->date_begin)->format('l d \\d\\e F Y'); 
							@endphp
							<td>{{ $guardia->id }}</td>
							<td>{{ $guardia->name }}</td>
							<td>{{ $guardia->lastname }}</td>
							<td>{{ $fecha }}</td>
							<td>{{ $guardia->days }}</td>
							<td>
								<img class="btn" src="{!! asset('plugins/moverfilas/arriba.gif') !!}" alt="subir fila" /><img class="btn" src="{!! asset('plugins/moverfilas/abajo.gif') !!}" alt="bajas fila"/>
							</td>
							<td class="text-center">
								<a href="{{ route('guardias.edit', $guardia->id) }}" class="btn btn-warning"><i class="fa fa-wrench" aria-hidden="true"></i></a>
								<a href="{{ route('guardias.destroy', $guardia->id) }}" onclick="return confirm('Seguro que desea Elimnarlo?')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-0	col-md-12"">
			<a href="{{ route('guardias.create', $group_id) }}" class="btn btn-primary">Nuevo</a>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset ('plugins/moverfilas/codigo.js') }}"></script>
	<script>
		$(function(){ 
			iniciarTabla();
			$('.select-group').chosen({});
		});
	</script>
@endsection
