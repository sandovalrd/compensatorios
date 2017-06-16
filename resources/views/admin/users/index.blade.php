@extends('admin.template.main')
@section('title', 'Empleados')
@section('sub-title', 'Lista de Empleados')

@section('content')
	<div class="row">
		<div class="form-inline col-md-10">
			{!! Form::open(['route'=>'users.index', 'method'=>'GET']) !!}
				{!! Form::select('group', $groups, $group_id, [ 'id'=>'group', 'class'=>'form-control select-group', 'placeholder'=>'Seleccione una opción..', 'onchange'=>'this.form.submit()', 'name'=>'group_id']) !!}
			{!! Form::close() !!}
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-offset-0 col-md-12">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Idicador</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Extensión</th>
					<th>Teléfono</th>
					<th>Grupo</th>
					<th class="text-center" width="160px">{{ 'Acción' }}</th>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{ $user->id }}</td>
							<td>{{ $user->username }}</td>
							<td>{{ $user->name }}</td>
							<td>{{ $user->lastname }}</td>
							<td>{{ $user->ext }}</td>
							<td>{{ $user->phone }}</td>
							<td>{{ $user->group->name }}</td>
							<td class="text-center">
								<a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="fa fa-wrench" aria-hidden="true"></i></a>
								<a href="{{ route('users.destroy', $user->id) }}" onclick="return confirm('Seguro que desea Elimnarlo?')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
								<a href="{{ route('roles.index', $user->id) }}" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-12 text-right">
					{!! $users->render() !!}
				</div>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-0	col-md-12"">
			<a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo</a>
		</div>
	</div>
@endsection
@section('script')
	<script>
		$(function(){
			$('.select-group').chosen({});
		});
	</script>
@endsection