<?php
	/*
	Vikram Sringari
	6/2/2016
	CSE 154 AC
	HW8: MYMDb
	This PHP page contains all common functions seen in other php pages
	It includes functions for html of top and bottom bar of the page, 
	a function to produce a full name, function to tell if the actor was
	not found, function for searching actor's ids, a function the creates
	tables and a function that produces a pdo object.
	*/
	
	
	# creates and returns the pdo object for imbd database so that its data can be accessed
	function pdo() {
		$data_base = new PDO("mysql:dbname=imdb;host=localhost", "stripes7", "eEa9t7TJYf");
		$data_base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $data_base;
	}
	
	# Takes in the first and last name searched
	# Combines the names for display purposes 
	# Returns this combined name
	function full_name($first_name, $last_name){
		return $first_name . " " . $last_name;
	}
	
	# Displays if whatever actor that was searched is not found in the database
	# takes in the value of the actor which is the name
	function not_actor($actor) {
		?>
			<p>Actor <?=$actor?> not found.</p>
		<?php
	}

	# searches the id of the actor taken from the parameters 
	# of the actors first and last name.
	# It uses the database to access the actor's ID. 
	# It returns the actor's id
	# If the actor searched doesnt have a single movie, it returns nothing
	function search_id($data_base, $actor_first_name, $actor_last_name) {
		$actor_first_name = $data_base->quote($actor_first_name . '%');
		$actor_last_name = $data_base->quote($actor_last_name);
		
		# This is a query for the actor's id from the imbd
		# This dettermines if the actor's first name is similar 
		# and if the actor's last name is exact
		# If there are multiple actors found it takes first one
		# This is dettermined by the number films the actor has done
		# and then the actor's id.
		$data_lines = $data_base->query("SELECT a.id 
										 FROM actors a
										 WHERE a.last_name = $actor_last_name
										 AND a.first_name LIKE $actor_first_name
										 ORDER BY a.film_count DESC, a.id
										 LIMIT 1;");
		if ($data_lines->rowCount() > 0) {
  			$data = $data_lines->fetch();
  			return $data_base->quote($data["id"]);
		} else  {
			return null;
		}
	}

	# This creates a table of movies, its movie number and year.
	# It takes in a boolean value to dettermine if the table is
	# the one with the actor and kevin bacon, as opposed to all 
	# movies with just the actor. It takes in a value of the actor's name
	# It takes in the data from the query.
	# It Uses these to create a table where the first column is the movie number,
	# the second column is the movie title and the third is the year
	# above the table is the caption describing the table
	function create_table($with_kevin, $actor, $table) {
		$caption = "";
		if ($with_kevin) {
			$caption = "Films with " . $actor . " and Kevin Bacon";
		} else {
			$caption = "All Films";
		}
		?>
			<caption><?=$caption?></caption>
			<table>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Year</th>
				</tr>
				<?php
					$number = 1;
					foreach ($table as $line) {
						list($title, $year) = $line;
						$title = htmlspecialchars($title);
				?>
					<tr>
						<td><?=$number ?></td>
						<td><?=$title ?></td>
						<td><?=$year ?></td>
					</tr>
				<?php
						$number++;
					}
				?>		
			</table>
		<?php
	}


	# Shows the bottom bar of part of the pages displayed
	function top_bar() {
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>My Movie Database (MyMDb)</title>
				<meta charset="utf-8" />
				<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" 
					type="image/png" rel="shortcut icon" />
				<link href="bacon.css" type="text/css" rel="stylesheet" />
			</head>

			<body>
				<div id="frame">
					<div id="banner">
						<a href="mymdb.php">
						<img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" />
						</a>
						My Movie Database
					</div>
					<div id="main">

		<?php
	}
	
	# Shows the bottom bar of part of the pages displayed
	function bottom_bar() {
		?>
						<!-- form to search for every movie by a given actor -->
						<form action="search-all.php" method="get">
							<fieldset>
								<legend>All movies</legend>
								<div>
									<input name="firstname" type="text" size="12" placeholder="first name"/> 
									<input name="lastname" type="text" size="12" placeholder="last name" /> 
									<input type="submit" value="go" />
								</div>
							</fieldset>
						</form>

						<!-- form to search for movies where a given actor was with Kevin Bacon -->
						<form action="search-kevin.php" method="get">
							<fieldset>
								<legend>Movies with Kevin Bacon</legend>
								<div>
									<input name="firstname" type="text" size="12" placeholder="first name" /> 
									<input name="lastname" type="text" size="12" placeholder="last name" /> 
									<input type="submit" value="go" />
								</div>
							</fieldset>
						</form>
					</div>
					<div class="banner" id="w3c">
						<a href="https://webster.cs.washington.edu/validate-html.php">
							<img src="https://webster.cs.washington.edu/images/w3c-html.png" 
								alt="Valid HTML5" />
						</a>
						<a href="https://webster.cs.washington.edu/validate-css.php">
							<img src="https://webster.cs.washington.edu/images/w3c-css.png" 
								alt="Valid CSS" />
						</a>
					</div>
				</div>
			</body>
		</html>

		<?php		
	}
?>
