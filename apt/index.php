<div class="container">
<?php
	session_start();
	
	//Sprawdzenie czy zalogowany, jeśli tak przekierowanie do strony głównej
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: apka.php');
		exit();
	}
	
	include "inc/nagl.php";
?>
<center>
<h2><b> <?php echo $txtNazwaProjektu ?> </b><h2>

<br/>
<h4> <?php echo $txtLogowanie; ?> </h4> 

<form action="zaloguj.php" method="post">

	<?php echo $txtLogin; ?> <br/> <input type="text" name="login"/><br/>
	<?php echo $txtHaslo; ?> <br/> <input type="password" name="haslo"/><br/><br/>
	<input type="submit" value="<?php echo $txtZaloguj; ?>"/>
		
</form>

<br/>

<a href="rejestracja.php"><?php echo $txtRejLink; ?></a>
<br/><br/>

<?php
	//Wyswietlanie błędów logowania
	if(isset($_SESSION['blad']))
	{
		echo $_SESSION['blad'];
	}
?>
	
</center>


	
	
<?php	
	include "inc/stopka.php";
?>
</div>
