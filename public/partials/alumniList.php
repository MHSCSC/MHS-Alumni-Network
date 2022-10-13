<div class="container">
<div class="row">
<table>
	<tr>
		<th>Name</th>
		<th>Graduation Year</th>
		<th>Area of Expertise</th>
		<th></th>
	</tr>
	<?php
		global $wpdb;
		$alumniTableName = $wpdb->prefix."alumniInfo";
		$sql = "SELECT * from $alumniTableName";
		$results = $wpdb->get_results($sql);
		for ($i=0; $i < count($results); $i++) { 
			echo "<tr>";
			echo "<td>".$results[$i]->displayName."</td>";
			echo "<td>".$results[$i]->graduationYear."</td>";
			echo "<td>".$results[$i]->areaOfExpertise."</td>";
			$newUrl = $_SERVER['REQUEST_URI']."&alumID=".$results[$i]->id;
			echo "<td><a href=\"$newUrl\">view</a></td>";
			echo "</tr>";
		}
	?>
</table>
</div>
</div>