@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Edit</div>
				<div class="panel-body">
				@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('editPost') }}" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $client["id"]?>}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="<?php echo $client["name"]?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Last Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="lastname"  value="<?php echo $client["lastname"]?>">
							</div>
						</div>
                        <div class="form-group">
							<label class="col-md-4 control-label">Date of Birth</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="dob" id="dob"  value="<?php echo $client["dob"]?>">
							</div>
						</div>
                        <div class="form-group">
							<label class="col-md-4 control-label">Phone</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="phone"  value="<?php echo $client["phone"]?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Photos</label>
							<div class="col-md-6">
								<input type="file" class="form-control" name="photos[]"  accept="image/*" multiple>
							</div>
						</div>
                        
				  <div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									edit
								</button>
							</div>
						</div>
                        Actual Photos:<br /><br />
                        <?php 
						$g=0;
										foreach($client["photos"] as $photo){
											
											?>
                                            	<a href="uploads/<?php echo $photo->path;?>" data-lightbox="image-<?php echo $g;?>" ><img src="uploads/<?php echo $photo->path;?>" style="margin-right:5px" width="80" /></a> <a href="deletePhoto?id=<?php echo $photo->id?>&client=<?php echo $client["id"]?>">delete this photo</a><br /><br />
                                            <?php	
										}
									?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="js/datepicker/js/bootstrap-datepicker.js"></script>
<script>
	$(function(){
		$('#dob').datepicker({
			format: 'yyyy-mm-dd'
		});
	});
</script>
@endsection
