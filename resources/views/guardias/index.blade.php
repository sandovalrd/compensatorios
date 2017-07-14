@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title')
	{{ 'Listado de Guardia de ' . $group->name  }}
@endsection

@section('content')

	<div class="row">
		<div class="col-md-offset-1	col-md-10">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Próxima Guardia</th>
					<th>Estatus</th>
				</thead>
				@php
					$i=0;
				@endphp
				<tbody id='tabla'>
					@foreach($guardias as $guardia)
						@php
							if($i==0 && $guardia->estatus_guardia_id==1)
								$clase="danger"; 
							elseif ($i==0 && $guardia->estatus_guardia_id==2)
								$clase="success";
							elseif ($guardia->estatus_guardia_id ==3 )
								$clase="info"; 
							else
								$clase="";
							$fecha = Date::createFromFormat('Y-m-d', $guardia->date_begin)->format('l d \\d\\e F Y'); 
							if($guardia->estatus_guardia_id!=3)
								$i++;
						@endphp

						<tr class="{{ $clase }}">
							<td>{{ $guardia->user_id }}</td>
							<td>{{ $guardia->name }}</td>
							<td>{{ $guardia->lastname }}</td>
							<td>{{ $fecha }}</td>
							@if ($i==1 && $guardia->estatus_guardia_id==1 && $guardia->user_id==Auth::user()->id )
								<td>
									<a href="{{ route('guardia.edit', $guardia->user_id) }}" class="label label-primary">{{ $guardia->description }} </a>
								</td>
							@else
								<td>{{ $guardia->description }} </td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection

