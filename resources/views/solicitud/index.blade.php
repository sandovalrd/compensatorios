@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title')
	{{ 'Solicitud de compensatorios de ' . $group->name  }}
@endsection

@section('content')

	{!! Form::open(['route'=>['solicitud.aprobar'], 'method'=>'GET', 'id'=>'form']) !!}
	{!! Form::close() !!}

	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<table class="table table-striped">
				<thead>
					<th>Nombre</th>
					<th>Apellido</th>
					<th class="text-center">Compensatorios</th>

					<th class="text-center">Dias Solicitados</th>
					<th class="text-center" width="120px">Aprobar</th>	
				</thead>
				<tbody>
					@foreach($compensatorios as $compensatorio)
						<tr data-id={{ $compensatorio->id }}>
							<td>{{ $compensatorio->name }}</td>
							<td>{{ $compensatorio->lastname }}</td>
							@if(Auth::user()->id==$compensatorio->user_id)
								<td class="text-center"><a href="{{ route('solicitud.edit', $compensatorio->user_id) }}" class="btn btn-primary">{{ $compensatorio->days }}</td></a>
							@else
								<td class="text-center"><a href="{{ route('solicitud.edit', $compensatorio->user_id) }}" class="btn btn-info">{{ $compensatorio->days }}</td></a>
							@endif
							<td class="text-center td-solicitado">{{ $compensatorio->days_request }}</td>
							@if($compensatorio->days_request > 0)
								<td class="text-center btn-check">
									<a href="#" class="btn btn-primary" id='btn'><i class="fa fa-check" aria-hidden="true"></i></a>
								</td>
							@else
								<td class="text-center">
									<a href="#" class="btn"><i class="fa fa-times" aria-hidden="true"></i></a>
								</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	{!! Form::hidden('user_id', $user_id, ['class'=>'user_id']) !!}
@endsection
@section('script')
	<script>
		$(function(){
			$('.btn-check').click(function(){
				var row = $(this).parents('tr');
				var user_id = parseInt($('.user_id').val());
				var url = $('#form').attr('action');
				var data = { user_id: user_id };
				$.get(url, data, function(resul){ 
					row.find(".fa").removeClass('fa-check');
					row.find("#btn").removeClass('btn-primary');
					row.find(".fa").addClass('fa-times');
					row.find(".td-solicitado").html(0);
					alert('Aprobación exitosa');
					$('.btn-primary').focus();
				}).fail(function(){
				    alert('Hubo un error en la aprobación');
				});
				
			});
		});		
	</script>
@endsection

		
