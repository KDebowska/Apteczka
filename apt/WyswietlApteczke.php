<?php
	session_start();
	
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
<?php	
	echo '<h2>'.$_SESSION['apt'].'</h2>';	
?>
<a href="apka.php"><?php echo $txtPowrot; ?></a>
</div>

<?php	
	include "inc/menu2.php";
?>

<div class="container">	
<?php	
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno!=0) //False, gdy uda się połączyć
	{
		echo $txtBladSerwera;
		//echo "Error: " .$polaczenie->connect_errno;
		//wyświetlanie błędu o połączeniu
	}
	else
	{
		
		include "inc/utylizacjaKomunikat.php";
		
		
		if(isset($_GET['operacja']))
		{
			
			//odbieranie kodu operacji z menu
			$kodOperacji = $_GET['operacja'];
						
			//wybranie odpowiedniej akcji dla kodu operacji
			switch($kodOperacji)
			{
					
				//menu 1
				case 103:
					include "oper/UdostepnijApteczke.php"; 
					break;
				
				case 104:
					include "oper/zawartosc.php";
					break;
					
				case 105:
					include "oper/Rozchody.php";
					break;
					
				case 106:
					include "oper/PrzyjmowanieLekow.php";
					break;
					
				//menu 2
				case 201:										
					include "oper/SpisLekow.php"; 
					break;
				
				case 202:
					include "oper/Wyszukaj.php";
					break;
				
				default:
					//Nieobsługiwany kod operacji -> powrót do strony głównej
					header("Location: apka.php");
				
			}
			
		}
		
		$polaczenie->close();
	}
	
	
	include "inc/stopka.php";
?>
</div>
