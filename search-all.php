<?php
	/*
	Vikram Sringari
	6/2/2016
	CSE 154 AC
	HW8: MYMDb
	This PHP page takes the first and last name searched by the user and displays
	the table of all movies of the actor. The User is able
	to search after that for another actor.
	*/
	include("common.php");
	top_bar();
	$data_base = pdo();
	$first_name = $_GET["firstname"]; # gets first name from input
	$last_name = $_GET["lastname"]; # gets last name from input
	$actor = full_name($first_name, $last_name);
	$id = search_id($data_base, $first_name, $last_name);
	
	# If the actor did not have any movies then text reporting that will be shown
	# Otherwise a table of actor's movies with a caption above
	if ($id == null) {
		not_actor($actor);
	} else {

		# This Query searches the database for all the movies (including its year)
		# For movies by the actor's (First and Last Name)
		# It searches for the roles that that actor has played in movies
		# It Orders the movies in the table by latest to earliest year
		# then it orders by the movie title
		$table = $data_base->query("SELECT mov.name, mov.year 
									FROM movies mov
									JOIN roles r ON r.movie_id = mov.id
									WHERE r.actor_id = $id
									ORDER BY mov.year DESC, mov.name;");
		?>
			<h1>Results for <?=$actor?></h1>
		<?php
		create_table(false, $actor, $table);
	}
	bottom_bar();
?>
