<?php
	/*
	Vikram Sringari
	6/2/2016
	CSE 154 AC
	HW8: MYMDb
	This php page displays front first page users see. It includes a picture of Kevin Bacon
	It has the forms for searching actors. This is the page that users see when the click on
	the MYMDb icon on the top left.
	*/
	include("common.php");
	top_bar();
	?>	
		<h1>The One Degree of Kevin Bacon</h1>
		<p>Type in an actor's name to see if he/she was ever in a movie with Kevin Bacon!</p>
		<p>
			<img src="https://webster.cs.washington.edu/images/kevinbacon/kevin_bacon.jpg" alt="Kevin Bacon" />
		</p>
	<?php
	bottom_bar();
?>