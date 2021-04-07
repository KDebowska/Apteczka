<?php
	session_start();
	include "inc/nagl.php";
	
	if(!isset($_SESSION['udanaRejestracja'])) //gdy nie uda się zarejestrować
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanaRejestracja']);
	}	
	
?>
<div class="container">	
<br/>

<center>
<h4> <?php echo $txtWitamy ?></h4>

<br/>

<a href="index.php"><?php echo $txtPowrot ?></a>
</center>

<?php	
	include "inc/stopka.php";
?>
</div>