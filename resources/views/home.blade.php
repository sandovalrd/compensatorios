@extends('admin.template.front')
@section('title', 'Inicio')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="text-info">Guardias de la Semana 30/05/2017 al 06/06/2017</h5>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<th>Empleado</th>
						<th>Equipo</th>
						<th>Estatus</th>
					</thead>
					<tbody>
						<tr>
							<td>Rafael Sandoval</td>
							<td>Soporte Tecnico Especializado</td>
							<td><span class="label label-success">Aceptada</span></td>
						</tr>
						<tr>
							<td>Jorge Achong</td>
							<td>Servidores Linux</td>
							<td><span class="label label-warning">Pendiente</span></td>
						</tr>
						<tr>
							<td>Felix Rodriguez</td>
							<td>Servidores Windows</td>
							<td><span class="label label-warning">Pendiente</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="text-info">Soporte Tecnico Especializado</h5>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
					<thead>
						<th>Empleado</th>
						<th>Días</th>
					</thead>
					<tbody>
						<tr class="danger">
							<td>Rafael Sandoval</td>
							<td>8</td>
						</tr>
						<tr class="warning">
							<td>Javier Duque</td>
							<td>4</td>
						</tr>
						<tr class="info">
							<td>Susana Vera</td>
							<td>2</td>
						</tr>
						<tr class="info">
							<td>Gladiola Caldera</td>
							<td>2</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
