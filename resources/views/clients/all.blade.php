@extends('app')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">All Clients</div>
				<div class="panel-body">
					

					<table width="100%">
                    	<tr>
                       	  <th>Name</th>
                          <th>LastName</th>
                          <th>BirthDate</th>
                          <th>Phone</th>
                          <th>Photos</th>
                          <th></th>
                          <th></th>
                            
                        </tr>
                    	<?php
							$g=0;
							foreach($clients as $client){
								$g++;
						?>
                                <tr>
                                	<td><?php echo $client["name"];?></td>
                                	<td><?php echo $client["lastname"];?></td>
                                	<td><?php echo $client["dob"];?></td>
                                	<td><?php echo $client["phone"];?></td>
                                	<td style="max-width:50"><?php 
										foreach($client["photos"] as $photo){
											
											?>
                                            	<a href="uploads/<?php echo $photo->path;?>" data-lightbox="image-<?php echo $g;?>" ><img src="uploads/<?php echo $photo->path;?>" style="margin-right:5px" width="40" /></a>
                                            <?php	
										}
									?>
                                    </td>
                                    <td><a href="edit?id=<?php echo $client["id"];?>">Edit</a></td>
                           			<td><a href="delete?id=<?php echo $client["id"];?>">Delete</a></td>
                                </tr>
						<?php
							}
						?>
                    
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
