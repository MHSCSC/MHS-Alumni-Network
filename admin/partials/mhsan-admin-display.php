

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wrap" class="mhsan">
	<h1>MHSAN Admin Console</h1>
		<?php
			// get current page uri		  		
			$uri = $_SERVER['REQUEST_URI'];
			$homeURL = substr($uri, 0, strpos($uri, "uid")-1);

			echo "<form method=\"post\" action=\"$uri\" id=\"admin\">";

			// get database handler
		 	global $wpdb;
		  	$charset_collate = $wpdb->get_charset_collate();
		  	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		 	$alumni_tablename = $wpdb->prefix."alumniInfo";
		 	$student_tablename = $wpdb->prefix."studentInfo";

			// view details for user with id
			if(isset($_GET['uid']) && isset($_GET['type'])){

				//get user id
				$uid = $_GET['uid'];

				//get type
				$type = $_GET['type'];

				//pull user info
				$sql = "SELECT * from " . ($type == "a" ? $alumni_tablename : $student_tablename) . " where id='%d'";
				$results = $wpdb->get_results($wpdb->prepare($sql, $uid));
				$user = $results[0];

				//approve alumni
				if(isset($_POST['approve_alumni'])){
					$wpdb->update($alumni_tablename, array('status'=>'Approved'), array('id'=>$uid));
					$user_id = wp_insert_user( array(
					  'user_login' => $user->email,
					  'user_pass' => NULL,
					  'user_email' => $user->email,
					  'display_name' => $user->displayName,
					  'role' => 'subscriber'
					));
					wp_new_user_notification( $user_id, null, 'both' );
				}

				//disapprove alumni
				if(isset($_POST['disapprove_alumni'])){
					$wp_user = get_user_by('login', $user->email);
					if($wp_user) wp_delete_user($wp_user->ID);
					$wpdb->update($alumni_tablename, array('status'=>'Rejected'), array('id'=>$uid));
				}

				//delete user
				if(isset($_POST['delete_user'])){
					$wp_user = get_user_by('login', $user->email);
					if($wp_user) wp_delete_user($wp_user->ID);

					if($type == "a"){
						$wpdb->delete( $alumni_tablename, array( 'id' => $uid ) );
					}
					if($type == "s"){
						$wpdb->delete( $student_tablename, array( 'id' => $uid ) );
					}
				}

				//edit user
				if(isset($_POST['editUser'])){
					if($type == "a"){
						$updatedData = array(
							'displayName' => $_POST['displayName'],
							'graduationYear' => $_POST['graduationYear'],
							'areaOfExpertise' => $_POST['areaOfExpertise'],
							'email' => $_POST['email'],
							'college' => $_POST['college'],
							'job' => $_POST['job'],
							'status' => $_POST['status']
						);
						$wpdb->update($alumni_tablename, $updatedData, array('id'=>$uid));
					}
					if($type == "s"){
						$updatedData = array(
							'displayName' => $_POST['displayName'],
							'graduationYear' => $_POST['graduationYear'],
							'areaOfExpertise' => $_POST['areaOfExpertise'],
							'email' => $_POST['email'],
							'status' => $_POST['status']
						);
						$wpdb->update($student_tablename, $updatedData, array('id'=>$uid));
					}
				}

				//breadcrumb
				$breadcrumb = "<a href=\"$homeURL\">Admin Home</a> > User Details - $user->displayName";
				echo $breadcrumb;

				//list user info
				echo '
				<div class="container">
					<div class="row">
						';
						echo '<div class="rounded" style="background-color: #FFE4C4; padding: 20px; margin-top: 20px">';
						if($type == "s"){
							echo "
								<label class=\"form-label\" for=\"displayName\">
									Display Name
								</label>
								<input class=\"form-control\" type=\"text\" id=\"displayName\" name=\"displayName\" value=\"$user->displayName\">
								<label class=\"form-label\" for=\"graduationYear\">
									Graduation Year
								</label>
								<input class=\"form-control\" type=\"text\" id\"graduationYear\" name=\"graduationYear\" value=\"$user->graduationYear\">
								<label class=\"form-label\" for=\"areaOfExpertise\">
									Area of Expertise
								</label>
								<input class=\"form-control\" type=\"text\" id=\"areaOfExpertise\" name=\"areaOfExpertise\" value=\"$user->areaOfExpertise\">
						
								<label class=\"form-label\" for=\"email\">
									Email
								</label>
								<input class=\"form-control\" type=\"text\" id=\"email\" name=\"email\" value=\"$user->email\">
								<label class=\"form-label\" for=\"status\">
									Status
								</label>
								<input class=\"form-control\" type=\"text\" id=\"status\" name=\"status\" value=\"$user->status\">
								";
						}
						if($type == "a"){
							echo "
								<input class=\"btn-success\" type=\"submit\" name=\"approve_alumni\" value=\"Approve\" style=\"margin-right: 20px\">
								<input class=\"btn-danger\" type=\"submit\" name=\"disapprove_alumni\" value=\"Disapprove\">
								<br>
								<label class=\"form-label\" for=\"displayName\">
									Display Name
								</label>
								<input class=\"form-control\" type=\"text\" id=\"displayName\" name=\"displayName\" value=\"$user->displayName\">
								<label class=\"form-label\" for=\"graduationYear\">
									Graduation Year
								</label>
								<input class=\"form-control\" type=\"text\" id\"graduationYear\" name=\"graduationYear\" value=\"$user->graduationYear\">
								<label class=\"form-label\" for=\"areaOfExpertise\">
									Area of Expertise
								</label>
								<input class=\"form-control\" type=\"text\" id=\"areaOfExpertise\" name=\"areaOfExpertise\" value=\"$user->areaOfExpertise\">
								<label class=\"form-label\" for=\"email\">
									Email
								</label>
								<input class=\"form-control\" type=\"text\" id=\"email\" name=\"email\" value=\"$user->email\">
								<label class=\"form-label\" for=\"college\">
									College
								</label>
								<input class=\"form-control\" type=\"text\" id=\"college\" name=\"college\" value=\"$user->college\">
								<label class=\"form-label\" for=\"job\">
									Job
								</label>
								<input class=\"form-control\" type=\"text\" id=\"job\" name=\"job\" value=\"$user->job\">
								<label class=\"form-label\" for=\"status\">
									Status
								</label>
								<input class=\"form-control\" type=\"text\" id=\"status\" name=\"status\" value=\"$user->status\">
								";
						}
						echo "<input class=\"btn-primary\" type=\"submit\" name=\"editUser\" value=\"Save Changes\">";
						echo "<input class=\"btn-danger\" type=\"submit\" name=\"delete_user\" value=\"Delete User\" style=\"float: right;\">";
						echo '</div>
					</div>
				</div>
				';

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
				<th>Account Type</th>
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
					echo "<td>".$student_results[$i]->email."</td>";
					echo "<td>Student</td>";
					echo "<td>".$student_results[$i]->status."</td>";	
					echo '<td><a href="'.$uri.'&uid='.$student_results[$i]->id.'&type=s'.'">View Details</a></td>';		
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
					echo "<td>Alumni</td>";
					echo "<td>".$alumni_results[$i]->status."</td>";	
					echo '<td><a href="'.$uri.'&uid='.$alumni_results[$i]->id.'&type=a'.'">View Details</a></td>';		
					echo "</tr>";
				}
			  	echo "</table>";
				echo "</form>";
		    }
		?>
</div>