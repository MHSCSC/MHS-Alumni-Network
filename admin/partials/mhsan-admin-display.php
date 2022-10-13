

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wrap" class="mhsan">
	<h1>MHSAN Admin Console</h1>
		<?php
			// get current page uri		  		
			$uri = $_SERVER['REQUEST_URI'];
			$homeURL = substr($uri, 0, strpos($uri, "vid")-1);

			echo "<form method=\"post\" action=\"$uri\" id=\"admin\">";

			// get database handler
		 	global $wpdb;
		  	$charset_collate = $wpdb->get_charset_collate();
		  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		 	$alumni_tablename = $wpdb->prefix."alumniInfo";
		 	$student_tablename = $wpdb->prefix."studentInfo";

			// view details for volunteer with vid
			if(isset($_GET['vid']) && isset($_GET['type'])){

				//get volunteer id
				$vid = $_GET['vid'];

				//get type
				$type = $_GET['type'];

				//pull user info
				$sql = "SELECT * from " . $type == "a" ? $alumni_tablename : $student_tablename . " where id='%d'";
				$volunteer_results = $wpdb->get_results($wpdb->prepare($sql, $vid));
				$user = $volunteer_results[0];

				//approve volunteer
				if(isset($_POST['approve_volunteer'])){
					$wpdb->update($volunteers_tablename, array('status'=>'Approved'), array('id'=>$vid));
					$user_id = wp_insert_user( array(
					  'user_login' => $volunteer->email,
					  'user_pass' => NULL,
					  'user_email' => $volunteer->email,
					  'first_name' => $volunteer->firstname,
					  'last_name' => $volunteer->lastname,
					  'display_name' => $volunteer->name,
					  'role' => 'subscriber'
					));
					wp_new_user_notification( $user_id, null, 'both' );
				}

				//disapprove volunteer
				if(isset($_POST['disapprove_volunteer'])){
					$user = get_user_by('login', $volunteer->email);
					if($user) wp_delete_user($user->ID);
					$wpdb->update($volunteers_tablename, array('status'=>'Rejected'), array('id'=>$vid));
				}

				//delete volunteer
				if(isset($_POST['delete_volunteer'])){
					$user = get_user_by('login', $volunteer->email);
					if($user) wp_delete_user($user->ID);

					$wpdb->delete( $courses_tablename, array( 'volunteer_id' => $vid ) );
					$wpdb->delete( $hours_tablename, array( 'volunteer_id' => $vid ) );
					$wpdb->delete( $volunteers_tablename, array( 'id' => $vid ) );
				}

				//breadcrumb
				$breadcrumb = "<a href=\"$homeURL\">Admin Home</a> > User Details - $user->name";

			}
			else{
				// pull students list
				$sql = "SELECT * from $student_tablename";
                $student_results = $wpdb->get_results($sql);

				// pull alumni list
				$sql = "SELECT * from $alumni_tablename";
                $alumni_results = $wpdb->get_results($sql);

				echo '<table class="table"><tr style="background-color:cornsilk;">
			  	<th>Display Name</th>
			  	<th>Graduaton Year</th>
				<th>Area of Expertise</th>
			  	<th>Email</th>
			  	<th>Status</th>
			  	<th></th>
			  	</tr>';
			  	$bgcolor = '#fff';
			  	for($i = 0; $i < count($student_results); $i++){
			  		if($i % 2 == 0) $bgcolor = '#eee';
			  		else $bgcolor = '#fff';
					echo "<tr style=\"background-color:$bgcolor;\">";
					echo "<td>".$student_results[$i]->displayName."</td>";
					echo "<td>".$student_results[$i]->graduationYear."</td>";	
					echo "<td>".$student_results[$i]->areaOfExpertise."</td>";	  
					echo "<td>".$student_results[$i]->schoolEmail."</td>";
					echo "<td>".$student_results[$i]->status."</td>";	
					echo '<td><a href="'.$uri.'&vid='.$student_results[$i]->id.'&type=s'.'">View Details</a></td>';		
					echo "</tr>";
			  	}
				for($i = 0; $i < count($alumni_results); $i++){
					if($i % 2 == 0) $bgcolor = '#eee';
					else $bgcolor = '#fff';
					echo "<tr style=\"background-color:$bgcolor;\">";
					echo "<td>".$alumni_results[$i]->displayName."</td>";
					echo "<td>".$alumni_results[$i]->graduationYear."</td>";	
					echo "<td>".$alumni_results[$i]->areaOfExpertise."</td>";	  
					echo "<td>".$alumni_results[$i]->email."</td>";
					echo "<td>".$alumni_results[$i]->status."</td>";	
					echo '<td><a href="'.$uri.'&vid='.$alumni_results[$i]->id.'&type=a'.'">View Details</a></td>';		
					echo "</tr>";
				}
			  	echo "</table>";
				echo "</form>";
		    }
		?>
</div>