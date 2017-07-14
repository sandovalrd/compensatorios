@extends('admin.template.main')
@section('title', 'Guardias')
@section('sub-title')
	{{ 'Solicitud de compensatorios de ' . $user->name .' ' . $user->lastname }}
@endsection

@section('content')

	{!! Form::open(['route'=>['solicitud.solicitar'], 'method'=>'GET', 'id'=>'form']) !!}
	{!! Form::close() !!}

	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<table class="table table-striped">
				<thead>
					<th>Fecha de la Guardia</th>
					<th class="text-center">Disponibles</th>
					<th class="text-center">Solicitados</th>
					<th class="text-center">Disfrutados</th>
					@if(Auth::user()->id==$user->id)
						<th class="text-center">Fecha Inicio</th>
						<th>Días</th>
						<th class="text-center">Acción</th>
					@endif
				</thead>
				<tbody>
					@php
						$total = 0;
						$i=0;
					@endphp
					@foreach($disponibles as $disponible)
						<tr data-id='{{ $disponible->id }}'>
							@php
								$fecha = Date::createFromFormat('Y-m-d', $disponible->date_begin)->format('l d \\d\\e F Y'); 
							@endphp
							<td class="td-fecha">{{ $fecha }}</td>
							<td class="text-center td-disponible">{{ $disponible->days }}</td>
							<td class="text-center td-solicitado">{{ $disponible->days_request }}</td></a>
							<td class="text-center td-disfrutados">{{ $disponible->days_take }}</td></a>
							@php
								$total = $total + $disponible->days_request;
								$i++;
								if($disponible->days_request>0){
									$clase = 'fa-times';
									$dias = 0;
								}else{
									$clase = 'fa-check';
									$dias = $disponible->days;
								}
							@endphp
							@if(Auth::user()->id==$disponible->user_id)
								<td class="text-center" width="160px">
									<div class='input-group date' id={!! 'datetimepicker' . $i !!}>
										{!! Form::text('fecha-inicio', null, ['class'=>'form-control', 'id'=>'desde']) !!}
										<span class="input-group-addon btn-calendar">
                        					<span class="glyphicon glyphicon-calendar"></span>
                    					</span>
									</div>
								</td>
								
								<td class="text-center" width="60px">{!! Form::text('days', $dias, ['class'=>'form-control', 'placeholder'=>'', 'id'=>$disponible->id]) !!}</td></a>
								<td class="text-center btn-check">
									<a href="#" class="btn btn-primary"><i class="fa {{ $clase }}" aria-hidden="true"></i></a>
								</td>
							@endif
						</tr>
					@endforeach
				</tbody>
				@if(Auth::user()->id==$user->id)
				    <tfoot>
					    <tr>
					      <td class="text-info"><h4>Total días solicitados</h4></td>
					    </tr>
				    </tfoot>
				@endif
			</table>
			<a href="{{ route('solicitud.index') }}" class="btn btn-primary">Atras</a>
			@if(Auth::user()->id==$disponible->user_id && $notificar !=0)
				<a href="{{ route('solicitud.notificar') }}" class="btn btn-primary" id='notificar'>Notificar</a>
			@else
				<a href="{{ route('solicitud.notificar') }}" class="btn btn-primary" id='notificar' style="display: none;">Notificar</a>
 	      	@endif
 	      	
		</div>
	</div>
	{!! Form::hidden('user_id', $user->id, ['class'=>'user_id']) !!}
	{!! Form::hidden('maximo', $i, ['class'=>'maximo']) !!}
@endsection
@section('script')
	<script>
		function fecha(a,b){
			$('#datetimepicker'+a).on('dp.change', function(e){
            	//var row 	= $(this).parents('tr');
            	//var i 		= row.data('id');
            	//var valor 	= parseInt($('#'+i).val());
            	var day = e.date.add('days', 1)
                $('#datetimepicker'+b).data('DateTimePicker').minDate(day);
                //$('#datetimepicker'+id).data('DateTimePicker').maxDate(day);
                $('#datetimepicker'+b).data("DateTimePicker").show();
            });	
		}
	</script>
	<script>
		$(function(){ 
			$('.date').datetimepicker({
                format: 'DD/MM/YYYY',
                daysOfWeekDisabled: [0, 6],
                minDate: new Date()

            });
            var j = 0;
            var maximo = parseInt($('.maximo').val());

           for(i=1;i<maximo;i++){
            	j=i+1;
           		fecha(i,j);
            }
            
            
            
			$('.btn-check').click(function(){
				var url 	= $('#form').attr('action');
				var row 	= $(this).parents('tr');
				var id 		= row.data('id');
				var user_id = parseInt($('.user_id').val());
				var valor 	= parseInt($('#'+id).val());
				var total 	= parseInt($('.total').html());
				var disponible =  parseInt(row.find(".td-disponible").html());   
				var solicitado =  parseInt(row.find(".td-solicitado").html());
				var desde 	=	row.find('.date').data("DateTimePicker").date().format('DD/MM/YYYY');
				var fecha	=  row.find('.td-fecha').html();
				var data 	= { id: id, valor: valor, tipo: 1, user_id: user_id, fecha:fecha, desde: desde };

				if (row.find('.fa').hasClass('fa-check') && valor>0){
					if (valor > disponible) {
						alert('No puede solicitar más días de los disponibles'); 
						$('#'+id).focus();  
					}else{
						
						$.get(url, data, function(resul){ 
							//console.log(resul);
		          			row.find(".td-solicitado").html(valor+solicitado);
							row.find(".td-disponible").html(disponible-valor);
							row.find(".fa").removeClass('fa-check');
							row.find(".fa").addClass('fa-times');
							$('#notificar').show();
							$('#'+id).val(0);
							total = total + valor;
							$('.total').html(total);
							$('.btn-primary').focus();
							alert('Solicitud creada con exito!')
					    }).fail(function(){
					        alert('Hubo un error en la solicitud');
					    });
					}
				}
				if (row.find('.fa').hasClass('fa-times')){
					data.tipo=2;
					data.valor=solicitado;
					$.get(url, data, function(resul){
						total=total-solicitado;
						row.find(".td-solicitado").html(0);
						$('.total').html(total);
						row.find(".td-disponible").html(disponible+solicitado);
						$('#'+id).val(disponible+solicitado);
						row.find(".fa").removeClass('fa-times');
						row.find(".fa").addClass('fa-check');
						$('#notificar').show();
						alert('Solicitud anulada!')
					}).fail(function(){
					    alert('Hubo un error en la eliminación de la solicitud');
					});
				}
				
			})

		});
	</script>
@endsection