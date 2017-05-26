@if(count($errors)>0)
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="alert alert-danger" role="alert">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endif