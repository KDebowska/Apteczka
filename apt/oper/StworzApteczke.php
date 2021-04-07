<?php
	
	if(isset($_POST['nazwa_apt']))
	{
		//flaga walidacji
		$wszystko_OK = true;
		
		$nazwa_apt =  $_POST['nazwa_apt'];
		$nazwa_apt = htmlentities($nazwa_apt, ENT_QUOTES, "UTF-8");
		
		//sprawdzenie długości nazwy
		if(strlen($nazwa_apt)<3)
		{
			$wszystko_OK = false;
			$_SESSION['e_nazwa_apt'] = $txtNazwaAptDlugosc;
		}
		
		//sprawdzenie znaków nazwy (mają być alfanumeryczne)
		if(ctype_alnum($nazwa_apt)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwa_apt'] = $txtNazwaAptZnaki;
		}
		

		//czy taka nazwa już istnieje w bazie?
		$sql = "SELECT id_apt FROM apteczki WHERE nazwa_apt='$nazwa_apt'";
		$rezultat = @$polaczenie->query($sql); // wysyłanie zapytania do bazy
		$ile_userow = $rezultat->num_rows; // wyciąganie ilości rezultatów zapytania (ile rekordów)
		
		if($ile_userow > 0)
		{
			$wszystko_OK = false;
			$_SESSION['e_nazwa_apt'] = $txtNazwaAptIstnieje;	
		}
		
		//Sprawdzenie czy walidacja się udała 
		if($wszystko_OK == true)
		{
			$user = $_SESSION['user'];
			// dodanie do bazy

			if($polaczenie->query("INSERT INTO apteczki VALUES (NULL, '$user', '$nazwa_apt')") && $polaczenie->query("INSERT INTO uprawnienia VALUES (NULL, '$user', '$nazwa_apt')"))
			{
				echo $txtAptGotowa;				
			}
			
		}
		//gdy walidacja się nie uda zostajemy na stronie
		
	}
	

?>
<br/>
<form method="post">

	<?php echo $txtNazwaApt; ?> <br/> <input type="text" name="nazwa_apt"/><br/>
	<?php
		if(isset($_SESSION['e_nazwa_apt']))
		{
			echo '<div class="error">'.$_SESSION['e_nazwa_apt'].'</div>';
			unset($_SESSION['e_nazwa_apt']);
		}
	?>
	<input type="submit" value="<?php echo $txtUtworz; ?>"/>	
</form>
