<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/ShawnLi14/AYDN-forms
 * @since      1.0.0
 *
 * @package    Aydn_Forms
 * @subpackage Aydn_Forms/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="wrap" class="aydn">
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

				// display volunteer personal information
				echo "$breadcrumb<br><br>";
				echo '<input class="ui-button ui-widget ui-corner-all" name="approve_volunteer" type="submit" value="Approve Volunteer" onclick="return confirm('."'Do you want to approve $volunteer->firstname $volunteer->lastname as an official AYDN volunteer? This will create an Wordpress account for them.'".')" style="background-color: aquamarine;">
				<input class="ui-button ui-widget ui-corner-all" name="disapprove_volunteer" type="submit" value="Disapprove Volunteer" onclick="return confirm('."'Do you want to DENY $volunteer->firstname $volunteer->lastname from being an official AYDN volunteer?'".')" style="background-color: darkred;color:white;">
				<input class="ui-button ui-widget ui-corner-all" name="editing" type="submit" value="Edit Volunteer" style="background-color: yellow;float: right;"> 
				<input class="ui-button ui-widget ui-corner-all" name="delete_volunteer" type="submit" value="Delete Volunteer" onclick="return confirm('."'Do you want to DELETE $volunteer->firstname $volunteer->lastname from the AYDN database? This will remove all records of their submitted courses and hours.'".')" style="background-color: darkred;color:white;float: right;">&nbsp;&nbsp;<br /><br />';
				echo "<div class=\"row\">";
				echo "<div class=\"col-6\">";
				echo "<span class=\"title\">First Name:</span>";
				if($editing) echo "<input type='text' name='edit_firstname' value='$volunteer->firstname' />";
				else echo $volunteer->firstname;
				echo "<br /><span class=\"title\">Last Name:</span>";
				if($editing) echo "<input type='text' name='edit_lastname' value='$volunteer->lastname' />";
				else echo $volunteer->lastname;
				echo "<br /><span class=\"title\">Display Name:</span>";
				if($editing) echo "<input type='text' name='edit_name' value='$volunteer->name' />";
				else echo $volunteer->name;
				echo "<br /><span class=\"title\">AYDN #:</span>";
				if($editing) echo "<input type='text' name='edit_aydn_number' value='$volunteer->aydn_number' />";
				else echo $volunteer->aydn_number;
				echo "<br /><span class=\"title\">Total Approved Hours:</span>$total_hours_approved<br>";
				echo "</div>";
				echo "<div class=\"col-6\">";
				echo "<span class=\"title\">Email:</span>";
				if($editing) echo "<input type='text' name='edit_email' value='$volunteer->email' />";
				else echo $volunteer->email;
				echo "<br /><span class=\"title\">Status:</span>";
				if($editing) echo "<input type='text' name='edit_status' value='$volunteer->status' />";
				else echo $volunteer->status;
				echo "<br /><span class=\"title\">Birth Date:</span>";
				if($editing) echo "<input type='text' name='edit_birthdate' value='$volunteer->birthdate' />";
				else echo $volunteer->birthdate;
				echo "<br /><span class=\"title\">Parent Contact:</span>";
				if($editing) echo "<input type='text' name='edit_parent_contact' value='$volunteer->parent_contact' />";
				else echo $volunteer->parent_contact;				
				echo "<br /></div></div>";
				echo "<div class=\"row\" id=\"resume\">";
				echo "<h3>Resume:</h3><div>";
				if($editing) echo "<textarea name='edit_resume' style='width:100%;'>".nl2br($volunteer->resume)."</textarea>";
				else echo nl2br($volunteer->resume);
				echo "</div></div>";
				if($editing) echo "<br /><input class='button button-primary' type='submit' name='update_volunteer' value='Save Volunteer Changes' onclick=\"return confirm('Do you want to save the changes you made on $volunteer->firstname $volunteer->lastname? ')\" /><br /><br />";
			else{
				// pull students list
				$sql = "SELECT * from $student_tablename";
                $student_results = $wpdb->get_results($wpdb->prepare($sql));

				// pull alumni list
				$sql = "SELECT * from $alumni_tablename";
                $alumni_results = $wpdb->get_results($wpdb->prepare($sql));

				echo '<table class="table"><tr style="background-color:cornsilk;">
			  	<th>Display Name</th>
			  	<th>Graduaton Year</th>
				<th>Area of Expertise</th>
			  	<th>Email</th>
			  	<th>Status</th>
			  	<th></th>
			  	</tr>';
			  	$bgcolor = '#fff';
			  	for($i = 0; $i < count($students_results); $i++){
			  		if($i % 2 == 0) $bgcolor = '#eee';
			  		else $bgcolor = '#fff';
					echo "<tr style=\"background-color:$bgcolor;\">";
					echo "<td>".$students_results[$i]->displayName."</td>";
					echo "<td>".$students_results[$i]->graduationYear."</td>";	
					echo "<td>".$students_results[$i]->areaOfExpertise."</td>";	  
					echo "<td>".$students_results[$i]->email."</td>";
					echo "<td>".$students_results[$i]->status."</td>";	
					echo '<td><a href="'.$uri.'&vid='.$students_results[$i]->id.'&type=s'.'">View Details</a></td>';		
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
		}
		?>
</div>