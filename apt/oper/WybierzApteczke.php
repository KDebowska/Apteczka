<?php
	
	if(isset($_SESSION['apt'])) unset($_SESSION['apt']);
	
	$wszystko_OK = true;
	
	if(isset($_SESSION['apt']))
	{
		unset($_SESSION['apt']);
	}
	
	//sprawdzanie do jakich apteczek ma dostęp użytkownik
	$user = $_SESSION['user'];
	$sql = "SELECT nazwa_apt FROM uprawnienia WHERE BINARY user='$user'";
	$rezultat = @$polaczenie->query($sql);
	$ile_apt =  $rezultat->num_rows; // zwraca ilość
	
	
	if($ile_apt == 0)
	{
		$wszystko_OK = false;
		$_SESSION['e_apt'] = $txtBrakApteczki;	
	}
	else
	{
		echo "<br><h4>$txtTwojeApt</h4>";
		
		echo '<table class="table">
					<tbody>';
		//Lista apteczek do wyboru
		while($wiersz = $rezultat->fetch_assoc())
		{
			$apt = $wiersz['nazwa_apt'];
			$tabela = "<tr><td> %s </td><td> %s </td></tr>";
			printf($tabela, $wiersz['nazwa_apt'],
				"<form method=post>
					<input type='hidden' id='id' name='apt' value=$apt>
					<input type='submit' value=$txtWybierz />
				</form>");	
		}
		echo "</tbody></table>";
	}	
	
	//Po wybraniu przekierowanie do strony z apteczką
	if(isset($_POST['apt']))
	{
		$_SESSION['apt'] = $_POST['apt'];
		echo $_SESSION['apt'] ;
		header('Location: WyswietlApteczke.php');
	}
	

?>
