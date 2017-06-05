@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title', 'Listado de Guardias')

@section('content')

	<div class="row">
		<div class="col-md-offset-1	col-md-10">
			<table class="table table-striped">
				<thead>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Fecha Inicio</th>
					<th>Fecha Fin</th>
					<th>Estatus</th>
					
				</thead>
				<tbody>
					
						<tr>
							<td>Rafael</td>
							<td>Sandoval</td>
							<td>30/06/2017</td>
							<td>07/07/2017</td>
							<td><span class="label label-success">Aceptada</span></td>
					
						</tr>
						<tr>
							<td>Javier</td>
							<td>Duque</td>
							<td>09/07/2017</td>
							<td>15/07/2017</td>
							<td><span class="label label-warning">Pendiente</span></td>
					
						</tr>
						<tr>
							<td>Susa</td>
							<td>Vera</td>
							<td>16/07/2017</td>
							<td>20/07/2017</td>
							<td><span class="label label-warning">Pendiente</span></td>
					
						</tr>
					
				</tbody>
			</table>
		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-1	col-md-10">
			<a href="#" class="btn btn-primary">Estado</a>
		</div>
	</div>
@endsection
