@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title', 'Orden de Guardias')

@section('content')
	<div class="row">
		<div class="form-inline col-md-10">
			{!! Form::label('name','Grupos:', ['class' => 'control-label']) !!}
			
				{!! Form::select('group', $groups, null, ['class'=>'form-control select-group', 'placeholder'=>'Seleccione una opción..']) !!}
		</div>
		{!! Form::close() !!}
	</div>
	<hr>
	<div class="row">
		<div class="col-md-offset-0 col-md-12">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Fecha Inicio</th>
					<th>Días</th>
					<th class="text-center" width="160px">Orden</th>
					<th class="text-center" width="160px">{{ 'Acción' }}</th>
				</thead>
				<tbody>
					<?php $i=1; ?>
					@foreach($groups as $group)
						<tr>
							<td>#</td>
							<td>#</td>
							<td>#</td>
							<td>#</td>
							<td>#</td>
							<td class="text-center">
								@if($i==1)
									<a href="#" class="btn"><i class="fa fa-arrows-h" aria-hidden="true"></i></a>
									<?php $i++; ?>
								@else
									<a href="#" class="btn"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
									
								@endif
								<a href="#" class="btn"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
							</td>
							<td class="text-center">
								<a href="#" class="btn btn-warning"><i class="fa fa-wrench" aria-hidden="true"></i></a>
								<a href="#" onclick="return confirm('Seguro que desea Elimnarlo?')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-0	col-md-12"">
			<a href="#" class="btn btn-primary">Nuevo</a>
		</div>
	</div>
@endsection
@section('script')
	<script>
		$('.select-group').chosen({

		});
	</script>
@endsection