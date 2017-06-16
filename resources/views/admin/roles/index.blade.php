@extends('admin.template.main')
@section('title', 'Roles')
@section('sub-title')
	{{ 'Rol del usuario: ' . $user->name . ' ' . $user->lastname }}
@endsection

@section('content')
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Rol</th>
					<th class="text-center" width="120px">{{ 'Acción' }}</th>
				</thead>
				<tbody>
					@foreach($user->roles as $rol)
						<tr>
							<td>{{ $rol->id }}</td>
							<td>{{ $rol->name }}</td>
							@if($rol->id === 1)
								<td class="text-center">-</td>							
							@else
								<td class="text-center">
									<a href="{{ route('roles.destroy', [$user->id, $rol->id]) }}" onclick="return confirm('Seguro que desea Elimnarlo?')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
								</td>
							@endif 
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-3	col-md-6">
		@if(count($user->roles) !== 3)
			<a href="{{ route('roles.create', $user->id) }}" class="btn btn-primary">Nuevo</a>
		@endif 
			<a href="{{ route('users.index', 'group_id=' . $user->group_id) }}" class="btn btn-primary">Atras</a>
		</div>
	</div>
@endsection