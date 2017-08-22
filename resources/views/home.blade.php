@extends('admin.template.front')
@section('title', 'Inicio')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="text-info">
					@php
						if($guardias->count()!=0)
							$fecha = Date::createFromFormat('Y-m-d', $guardias[0]->date_begin)->format('l d \\d\\e F Y'); 
						else
							$fecha ='';
					@endphp
						Guardias de la semana actual {{ $fecha }}
					</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<th>Empleado</th>
							<th>Equipo</th>
							<th>Estatus</th>
						</thead>
						<tbody>
							@foreach($guardias as $guardia)
								<tr>
									<td>{{ $guardia->name . ' ' . $guardia->lastname }}</td>
									<td>{{ $guardia->grupo }}</td>
									@if($guardia->estatus_guardia_id==1)
										<td><span class="label label-danger">{{ $guardia->description }}</span></td>
									@else
										<td><span class="label label-success">{{ $guardia->description }}</span></td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="text-info">
					@php
						if($proximas->count()!=0)
							$fecha = Date::createFromFormat('Y-m-d', $proximas[0]->date_begin)->format('l d \\d\\e F Y'); 
						else
							$fecha ='';
					@endphp
						Guardias de la semana próxima {{ $fecha }}
					</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<th>Empleado</th>
							<th>Equipo</th>
							<th>Estatus</th>
						</thead>
						<tbody>
							@foreach($proximas as $proxima)
								<tr>
									<td>{{ $proxima->name . ' ' . $proxima->lastname }}</td>
									<td>{{ $proxima->grupo }}</td>
									@if($proxima->estatus_guardia_id==1)
										<td><span class="label label-danger">{{ $proxima->description }}</span></td>
									@else
										<td><span class="label label-success">{{ $proxima->description }}</span></td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="text-info">{{ $grupo->name }}</h5>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<th>Empleado</th>
							<th>Días</th>
						</thead>
						<tbody>
							@foreach($compensatorios as $compensatorio)
								@php
									if($compensatorio->days<=3)
										$clase='info';
									elseif ($compensatorio->days> 3 && $compensatorio->days <=6 )
										$clase='warning';
									else
										$clase='danger';
								@endphp

								<tr class= {!! $clase !!} >
									<td>{{ $compensatorio->name . ' ' . $compensatorio->lastname }}</td>
									<td>{{ $compensatorio->days }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
