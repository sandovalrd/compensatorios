@extends('admin.template.main')
@section('title', 'Grupos')
@section('sub-title', 'Lista de Grupos')

@section('content')
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Grupo</th>
					<th class="text-center" width="120px">{{ 'Acción' }}</th>
				</thead>
				<tbody>
					@foreach($groups as $group)
						<tr>
							<td>{{ $group->id }}</td>
							<td>{{ $group->name }}</td>
							<td class="text-center">
								<a href="{{ route('groups.edit', $group->id) }}" class="btn btn-warning"><spam class="glyphicon glyphicon-pencil" aria-hidden="true"></spam></a> <a href="{{ route('groups.destroy', $group->id) }}" onclick="return confirm('Seguro que desea Elimnarlo?')" class="btn btn-danger"><spam class="glyphicon glyphicon-trash" aria-hidden="true"></spam></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-12 text-right">
					{!! $groups->render() !!}
				</div>
			</div>
		</div>
	</div>
		<div class="row">
		<div class="col-md-offset-1	col-md-10"">
			<a href="{{ route('groups.create') }}" class="btn btn-primary">Nuevo</a>
		</div>
	</div>
@endsection