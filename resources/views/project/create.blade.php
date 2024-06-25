@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
	<div class="container-fluid py-4">
		<div class="row mt-4">
			<div class="col-lg-12 mb-lg-0 mb-4">
				<div class="card z-index-2 h-100">
					<div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Create Project</h6>
                    </div>
					<div class="card-body p-3">
						@if($errors->any())
							<div class="alert alert-danger">
								@foreach ($errors->all() as $error)
									{{ $error }} <br>
								@endforeach
							</div>
						@endif

						{!! Form::open(['route' => 'project.store']) !!}

							<div class="row">
								<div class="col-md-6 form-group">
									{{ Form::label('project_name', 'Project Name', ['class'=>'form-label']) }}
									{{ Form::text('project_name', null, array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group">
									{{ Form::label('project_description', 'Project Description', ['class'=>'form-label']) }}
									{{ Form::textarea('project_description', null, array('class' => 'form-control', 'rows' => 3)) }}
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-6 form-group">
									{{ Form::label('subtest_id', 'Subtest', ['class'=>'form-label']) }}
									{{ Form::select('subtest_id[]', $subtests->pluck('subtest_name', 'id')->toArray(), null, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
								</div>
							</div>


							<div class="mt-3">
								{{ Form::submit('Create', array('class' => 'btn btn-primary')) }}
							</div>

						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endsection

@push('js')
<script>
    $(document).ready(function() {
		$(`.select2`).select2();
	});

</script>
@endpush