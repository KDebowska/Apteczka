<div class="container">
<?php
	session_start();
	
	include "inc/nagl.php";
	
	if(isset($_POST['email'])) //jeśli ktoś nie wpisał emaila to jest tam pusta wartość, ale jest, więc isset zwróci true
	{
		//ustanawianie flagi
		//zakładamy, że walidacja jest udana
		$wszystko_OK = true;
		
		//przeprowadzamy testy
		//Sprawdź poprawność loginu ----------------------------------------
		$nick = $_POST['nick'];
		
		//sprawdzenie długości loginu
		if(strlen($nick)<3 || strlen($nick)>20)
		{
			$wszystko_OK = false;
			$_SESSION['e_nick'] = $txtLoginDlugosc;
		}
		//sprawdzenie znaków loginu (mają być alfanumeryczne)
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick'] = $txtLoginZnaki;
		}
		
		//Sprawdź poprawność adresu email -----------------------------------
		$email = $_POST['email'];
		//sanityzowanie maila
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL); 
		
		if(filter_var($emailB, FILTER_VALIDATE_EMAIL) == false || ($emailB != $email))
		{
			$wszystko_OK = false;
			$_SESSION['e_email'] = $txtPoprawnyEmail;
		}
			
		//Sprawdź poprawność haseł ------------------------------------------
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		//sprawdzenie długości (8-20 znaków)
		if((strlen($haslo1) < 6) || (strlen($haslo1) > 20))
		//oba mają być takie same, więc wystarczy sprawdzić dla jednego
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = $txtHasloDlugosc;
		}
		
		if($haslo1 != $haslo2)
		{
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = $txtHasloPotwierdz;
		}
		
		//Hashowanie hasła --------------------------------------------------
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//Sprawdzanie akceptacji regulaminu ---------------------------------
		if(!isset($_POST['regulamin']))
		{
			$wszystko_OK = false;
			$_SESSION['e_regulamin'] = $txtZatwRegulamin ;
		}
		
		//Sprawdzanie reCAPTCHY - Bot or not Bot? ---------------------------
		$sekret = "6LeSA_0UAAAAAG9Mx1ZV5lzWmK-NY7j4UGB4mP9G";
		
		//sprawdzamy na serwerze Google - odpowiedź zakodowana w formacie json
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if($odpowiedz->success == false)
		{
			$wszystko_OK = false;
			$_SESSION['e_bot'] = $txtBot;
		}
		
		//Sprawdzenie czy konto jest już w bazie ------------------------------
		require_once "inc/polaczBD.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT); //rzucanie Exception zamiast Warning
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			
			if($polaczenie->connect_errno!=0) //False, gdy uda się połączyć
			{
				throw new Exception(mysqli_connect_errno());
				
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id_user FROM uzytkownicy WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili > 0)
				{
					$wszystko_OK = false;
					$_SESSION['e_email'] = $txtEmailIstnieje ;
				}
				
				//Czy login jest już zarezerwowany?
				$rezultat = $polaczenie->query("SELECT id_user FROM uzytkownicy WHERE user='$nick'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nicków = $rezultat->num_rows;
				if($ile_takich_nicków > 0)
				{
					$wszystko_OK = false;
					$_SESSION['e_nick'] = $txtLoginZajety;
				}
				
				//Sprawdzenie czy walidacja się udała -----------------------------------
				if($wszystko_OK == true)
				{
					//Testy zaliczone, dodajemy użytkownika do bazy
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['udanaRejestracja'] = true;
						header('Location: witamy.php');
					}	
					
				}
				//gdy walidacja się nie uda zostajemy na stronie
					
				$polaczenie->close();
			}
			
		}
		catch(Exception $e) //$e rodzaj błędu
		{
			echo $txtBladSerweraRej;
			//echo '<br/>Informacja developerska '.$e;
		}
		
	}
		
?>
<!-- reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
<!-- Formularz -->	
<center>
<h2><b> <?php echo $txtNazwaProjektu ?> </b><h2> 

<br/>
<h4> <?php echo $txtRejestracja; ?> </h4> 
	
<form method="post">
	
	<!-- Login -->
	<?php echo $txtLogin; ?> <br/><input type="text" name="nick" /><br/>
	<!-- Błędy loginu -->
	<?php
		if(isset($_SESSION['e_nick']))
		{
			echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
			unset($_SESSION['e_nick']);
		}
	?>
	
	<!-- E-mail -->
	<?php echo $txtEmail; ?> <br/><input type="text" name="email" /><br/>
	<!-- Błędy emaila -->
	<?php
		if(isset($_SESSION['e_email']))
		{
			echo '<div class="error">'.$_SESSION['e_email'].'</div>';
			unset($_SESSION['e_email']);
		}
	?>
	
	<!-- Podaj hasło -->
	<?php echo $txtHaslo1; ?> <br/><input type="password" name="haslo1" /><br/>
	<!-- Błędy hasła -->
	<?php
		if(isset($_SESSION['e_haslo']))
		{
			echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
			unset($_SESSION['e_haslo']);
		}
	?>
	
	<!-- Powtórz hasło -->
	<?php echo $txtHaslo2; ?> <br/><input type="password" name="haslo2" /><br/>
	
	<!-- Regulamin -->
	<label>
		<input type="checkbox" name="regulamin"/> <?php echo $txtRegulamin; ?>
	</label>
	<!-- Błędy akceptacji regulaminu -->
	<?php
		if(isset($_SESSION['e_regulamin']))
		{
			echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
			unset($_SESSION['e_regulamin']);
		}
	?>
		
	<!-- reCAPTCHA -->	
	<div class="g-recaptcha" data-sitekey="6LeSA_0UAAAAAP4XKnv2J6RNK6Iy8UmoSkrsfwU9"></div>
	<!-- Błędy akceptacji reCAPTCHA -->
	<?php
		if(isset($_SESSION['e_bot']))
		{
			echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
			unset($_SESSION['e_bot']);
		}
	?>	
	<br/>
	
	<!-- Przycisk rejestracji -->
	<input type="submit" value="<?php echo $txtRejestruj; ?>"/>
	
	<br/><br/>
	
	<a href="index.php"><?php echo $txtPowrot; ?></a>

		
</form>
</center>
	
<?php	
	include "inc/stopka.php";
?>
</div>