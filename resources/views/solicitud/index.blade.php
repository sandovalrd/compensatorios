@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title', 'Solicitud de Compensatorios')

@section('content')

	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<table class="table table-striped">
				<thead>
					<th>Nombre</th>
					<th>Apellido</th>
					<th class="text-center">Compensatorios</th>
					<th class="text-center">Dias Solicitados</th>
					<th class="text-center" width="120px">{{ 'Aprobación' }}</th>	
				</thead>
				<tbody>
					
						<tr>
							<td>Rafael</td>
							<td>Sandoval</td>
							<td class="text-center">2</td>
							<td class="text-center">2</td>
							<td class="text-center">
								<a href="#" class="btn"><i class="fa fa-street-view fa-2x" aria-hidden="true"></i></a>
							</td>
						</tr>
						<tr>
							<td>Javier</td>
							<td>Duque</td>
							<td class="text-center">0</td>
							<td class="text-center">0</td>
							<td class="text-center">
								<a href="#" class="btn"><i class="fa fa-street-view fa-2x" aria-hidden="true"></i></a>
							</td>
						</tr>
						<tr>
							<td>Susa</td>
							<td>Vera</td>
							<td class="text-center">4</td>
							<td class="text-center">0</td>
							<td class="text-center">
								<a href="#" class="btn"><i class="fa fa-street-view fa-2x" aria-hidden="true"></i></a>
							</td>
						</tr>
					
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-2	col-md-8"">
			<a href="#" class="btn btn-primary">Solicitar</a>
		</div>
	</div>
@endsection