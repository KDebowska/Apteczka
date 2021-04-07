<?php
	
	session_start(); //żeby sesja działała
	
	//Jeśli nie odebrano loginu i hasła przekierowanie do strony logowania
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}
	
	//dołączenie pliku zawierającego informację do połączenia się z bazą
	require_once "inc/polaczBD.php";
	//dołączenie pliku ze zmiennymi tekstowymi
	include "lang/pl/txt.php";
	

	//otwarcie połączenia z bazą
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		
	//sprawdzenie czy połączono się z bazą
	if($polaczenie->connect_errno!=0) //False, gdy uda się połączyć
	{
		echo $txtBladSerwera;
		//echo "Error: " .$polaczenie->connect_errno;
		//wyświetlanie błędu o połączeniu
	}
	else
	{
		//Sprawdzanie czy taki login i hasło są w bazie
		
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				
		
		$sql = "SELECT * FROM uzytkownicy WHERE BINARY user='$login'";
		
		if($rezultat = @$polaczenie->query($sql))
		{
			$ilu_userow = $rezultat->num_rows;
			
			if($ilu_userow>0)
			{
				//wyciąganie rekordu z bazy (całego wiersza)
				$wiersz = $rezultat->fetch_assoc(); //tablica asocjacyjna
				
				//weryfikacja hasha hasła
				if(password_verify($haslo, $wiersz['pass'])) //true dla takich samych hashy
				{
					$_SESSION['zalogowany'] = true;
				
					$_SESSION['user'] = $wiersz['user'];
				
					//usuwamy zmienną błąd z sesji, gdy udało się zalogować
					unset($_SESSION['blad']);
				
					//wyczyszczenie z pamięci niepotrzebnych już rezultatów zapytania
					$rezultat->close();
				
					//przekierowanie do strony aplikacji 
					header('Location: apka.php');
				}
				else //dobry login, ale złe hasło
				{
					$_SESSION['blad'] = $txtBladLogowania;
				
					header('Location: index.php');
				}
				
			}
			else
			{
				$_SESSION['blad'] = $txtBladLogowania;
				
				header('Location: index.php');
			}
			
		}
		
		$polaczenie->close();
	}	
?>