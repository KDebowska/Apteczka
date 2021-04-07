<?php

	session_start();
	
	if(isset($_SESSION['apt'])) unset($_SESSION['apt']);

	//sprawdzanie czy zalogowany
	if(!isset($_SESSION['zalogowany']))
    {    
		header('Location: index.php');
		exit();
	}
	
	require_once "inc/polaczBD.php";
	include "inc/nagl.php";
?>
	
<div class="container">
    <h2>
	<?php 
		echo $txtNazwaProjektu; 
		echo "<p>Witaj ".$_SESSION['user'].'!</p>';
	?>
	<h2>
</div>


<?php
	include "inc/menu1.php";
?>

<div class="container">
<?php	
	//sprawdzanie polaczenia z bazą ----------------------------------
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	/*Wyciąganie id z tabeli - na zaś, przyda się potem przy wyświetlaniu nazw apteczek ;)
	$rezultat = @$polaczenie->query("SELECT id_user FROM uzytkownicy WHERE user='kazik'");
	$wiersz = $rezultat->fetch_assoc();
	echo $wiersz['id_user'];*/
	
	if($polaczenie->connect_errno!=0) //False, gdy uda się połączyć
	{
		echo $txtBladSerwera;
		//echo "Error: " .$polaczenie->connect_errno;
		//wyświetlanie błędu o połączeniu
	}
	else
	{
		
		if(isset($_GET['operacja']))
		{
			
		
			//odbieranie kodu operacji z menu
			$kodOperacji = $_GET['operacja'];
						
			//wybranie odpowiedniej akcji dla kodu operacji
			switch($kodOperacji)
			{
					
				//menu 1
				case 101:
					include "oper/StworzApteczke.php";
					break;
				
				case 102:
					include "oper/WybierzApteczke.php";
					
					if(isset($_SESSION['e_apt']))
					{	
						echo $_SESSION['e_apt'];
						unset($_SESSION['e_apt']);
					}
					break;
					
				//menu 2
				case 201:
					echo $kodOperacji;
					break;
				
				case 202:
					echo $kodOperacji;
					break;
				
				default:
					//Nieobsługiwany kod operacji -> powrót do strony głównej
					header("Location: apka.php");
				
			}
			
		}
		
		$polaczenie->close();
	}
		
	
	
	
	

?>		
<div>



<?php	
	include "inc/stopka.php";
?>