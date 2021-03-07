<?php
// Template Name: خشکشویی ها

get_header();
?>
	<div class="container">
		<div class="featured-posts">
			<?php
			$request = wp_remote_get( 'http://46.209.137.18:96/shop-data/laundry/' );
			if( is_wp_error( $request ) ) {?>
				<table class="table table-bordered">
					<thead>
					  <tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td>John</td>
						<td>Doe</td>
						<td>john@example.com</td>
					  </tr>
					  <tr>
						<td>Mary</td>
						<td>Moe</td>
						<td>mary@example.com</td>
					  </tr>
					  <tr>
						<td>July</td>
						<td>Dooley</td>
						<td>july@example.com</td>
					  </tr>
					</tbody>
				  </table>
			<?php }
			$body = wp_remote_retrieve_body( $request );
			$data = json_decode( $body );		
			$return = $data->rows;
			foreach ($return as $r) {
				foreach ( $r as $e ) { ?>
					<div dir="ltr">
						<p class="alert alert-info"><?php var_dump($e); ?></p>
						<p class="alert alert-danger"><?php echo $e->phone_numbers[0]; ?></p>
						<p class="alert alert-warning"><?php echo $e->laundry__title; ?></p>
						<p class="alert alert-success"><?php echo $e->laundry__town__state; ?></p>
						<p class="well"><?php echo $e->address; ?></p>
						<hr>
					</div>
				<?php }
			}

		
			
			
			

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_URL, 'http://46.209.137.18:96/shop-data/laundry/');
// $result = curl_exec($ch);
// // curl_close($ch);
// // $obj = json_decode($result);
// var_dump($result);
			
			
			
			?>
		</div>
	</div>


<script>
// jQuery(document).ready(function($) {
//     $.getJSON( 'http://46.209.137.18:96/shop-data/laundry/', ( results ) => {
//         $( ".featured-posts" ).html('Hi');
//     });
// });
	
	
// jQuery(document).ready(function($) {	
// 	$.getJSON( "http://192.168.15.77/shop-data/laundry/", function( data ) {
// 	  var items = [];
// 	  $.each( data, function( key, val ) {
// 		items.push( "<li id='" + key + "'>" + val + "</li>" );
// 	  });

// 	  $( "<ul/>", {
// 		"class": "my-new-list",
// 		html: items.join( "" )
// 	  }).appendTo( "body" );
// 	});
// });	
	
	
	
</script>


<?php get_footer();