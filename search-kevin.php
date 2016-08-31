<?php
	/*
	Vikram Sringari
	6/2/2016
	CSE 154 AC
	HW8: MYMDb
	This PHP page takes the first and last name searched by the user and displays
	the table of all movies of the actor searched with kevin bacon. The User is able
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
	# Otherwise a table of actor's movies with Kevin Bacon will be shown with a caption above
	# If there were no movies with Kevin Bacon Text showing this will be displayed
	if ($id == null) {
		not_actor($actor);
	} else {
		
		# This Query searches the database for all the movies (including its year)
		# For movies shared by the actor's (First and Last Name) searched and Kevin Bacon
		# It searches for the roles that both actors have played in a movies
		# It Orders the movies in the table by latest to earliest year
		# then it orders by the movie title
		$table = $data_base->query("SELECT m.name, m.year 
									FROM movies m
									JOIN roles r ON r.movie_id = m.id
									JOIN roles r2 ON r2.movie_id = m.id
									JOIN actors a ON a.id = r2.actor_id
									WHERE r.actor_id = $id
									AND a.first_name = 'Kevin'
									AND a.last_name = 'Bacon'
									ORDER BY m.year DESC, m.name;");
		
		if ($table->rowCount() > 0){
			?>
				<h1>Results for <?=$actor ?> and Kevin Bacon</h1>
			<?php
			create_table(true, $actor, $table);
		} else {
			?>
				<p><?=$actor ?> wasn't in any films with Kevin Bacon.</p>
			<?php
		} 
	}
	bottom_bar();
?>
