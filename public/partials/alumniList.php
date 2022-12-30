<div class="container">
<div class="row">
	<?php
		global $wpdb;
		$alumniTableName = $wpdb->prefix."alumniInfo";

		if(isset($_GET["alumID"])){
			$sql = "SELECT * from $alumniTableName where id='%d'";
			$results = $wpdb->get_results($wpdb->prepare($sql, $_GET["alumID"]));
			$usr = $results[0];
			echo "
				<div class=\"col-4\">

				</div>
				<div class=\"col-8\">
					<h2>".$usr->displayName."</h2>
				</div>
			";
		}
		else{
			echo '<table class="table">
			<thead>
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Graduation Year</th>
					<th scope="col">Area of Expertise</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody>';
			$sql = "SELECT * from $alumniTableName";
			$results = $wpdb->get_results($sql);
			for ($i=0; $i < count($results); $i++) { 
				echo "<tr>";
				echo "<td scope=\"row\">".$results[$i]->displayName."</td>";
				echo "<td>".$results[$i]->graduationYear."</td>";
				echo "<td>".$results[$i]->areaOfExpertise."</td>";
				$newUrl = $_SERVER['REQUEST_URI']."&alumID=".$results[$i]->id;
				echo "<td><a href=\"$newUrl\">view</a></td>";
				echo "</tr>";
			}
			echo '</tbody>
			</table>';
		}
	?>
</div>
</div>
