<!DOCTYPE html>
<html>
    <head>
		<title> ShortUrl</title>
        <!--Import Google Icon Font-->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<?php
			
			$layout = "view/vInicio.php";

			if (isset($_GET['location']) && isset($vistas[$_GET['location']])) {
				$layout = $vistas[$_GET['location']];
			}

			include $layout;
			
        ?>
		
		<!--Import jQuery before materialize.js-->
		<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){		
				$('.modal').modal({
					dismissible: true, // Modal can be dismissed by clicking outside of the modal
					opacity: .5, // Opacity of modal background
					inDuration: 300, // Transition in duration
					outDuration: 200, // Transition out duration
					startingTop: '4%', // Starting top style attribute
					endingTop: '10%', // Ending top style attribute
				});
				
				$('.dropdown-button').dropdown({
					inDuration: 300,
					outDuration: 225,
					constrainWidth: false, // Does not change width of dropdown to that of the activator
					hover: true, // Activate on hover
					gutter: 0, // Spacing from edge
					belowOrigin: false, // Displays dropdown below the button
					alignment: 'left', // Displays dropdown with edge aligned to the left of button
					stopPropagation: false // Stops event propagation
				});
				
				$(".button-collapse").sideNav();
			});
			
		</script>
		<script src="js/particles.js"></script>
		<script src="js/app.js"></script>
	</body>
</html> 
