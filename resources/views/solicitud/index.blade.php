@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title')
	{{ 'Solicitud de compensatorios de ' . $group->name  }}
@endsection

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
					@foreach($compensatorios as $compensatorio)
						<tr>
							<td>{{ $compensatorio->name }}</td>
							<td>{{ $compensatorio->lastname }}</td>
							<td class="text-center"><a href="#" class="btn">{{ $compensatorio->days }}</td></a>
							<td class="text-center">{{ $compensatorio->days_request }}</td>
							<td class="text-center">
								<a href="#" class="btn"><i class="fa fa-street-view fa-2x" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach
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