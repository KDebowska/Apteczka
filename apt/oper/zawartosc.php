<?php
	
	$apt = $_SESSION['apt'];
	$sql = "SELECT * FROM zawartosc WHERE nazwa_apt='$apt'";
	$rezultat = @$polaczenie->query($sql);
	$ile_lekow = $rezultat->num_rows;
	
	
	if($ile_lekow == 0)
	{
		echo $txtPusta;
	}
	else
	{
		//Sprawdzanie czy dane z przycisków przyszły --------------------------------------
		if(isset($_POST['zazyj']))
		{
			//echo $_POST['zazyj'];
			$id = $_POST['zazyj'];
			
			$sql = "SELECT * FROM zuzycie WHERE id_lek='$id'";
			$rezultat = @$polaczenie->query($sql);
			$ile_dzisiaj = $rezultat->num_rows; //sprawdzam czy ten lek już był używany
			
			$kod = 11;
			
			// Sprawdzam czy użytkownik zażył już dzisiaj ten lek
			if($ile_dzisiaj > 0)
			{

				while($wiersz = $rezultat->fetch_assoc())
				{
					$dzisiaj = $wiersz['data_uzycia'];
					$ostatniUser = $wiersz['user'];
					
					if($dzisiaj == date('Y-m-d') && $ostatniUser == $_SESSION['user'])
					{
						$ile = $wiersz['ile'];
						$id_zuz = $wiersz['id_zuz'];
						$kod = 10;
						break;
					}
					
				}
				
			}
			
			$sql = "SELECT * FROM zawartosc WHERE id_lek='$id'";
			$rezultat = @$polaczenie->query($sql);
			$wiersz = $rezultat->fetch_assoc();
			$ilosc = $wiersz['ilosc'];
			$ilosc -= 1;
			
			switch($kod)
			{
				case 10: // Jeśli dany użytkownik tego dnia używał ten lek to doda ilość w istniejącym rekordzie
					$ile += 1;
					$polaczenie->query("UPDATE zuzycie SET ile='$ile' WHERE id_zuz='$id_zuz'");
					break;
					
				case 11: // Jeśli ten użytkownik nie używał tego leku dzisiaj to dodajemy nowy rekord
					$nazwa_apt = $_SESSION['apt'];
					$lek = $wiersz['lek'];
					$user = $_SESSION['user'];
					$ile = 1;
					$data = date('Y-m-d');
					$polaczenie->query("INSERT INTO zuzycie VALUES (NULL, '$nazwa_apt', '$id', '$lek', '$data', '$ile', '$user')");
					break;
			}
			
			//Usuwanie rekordu po zużyciu leku
			if($ilosc == 0)
			{
				//$id = $wiersz['id_lek'];			
				$lek = $wiersz['lek'];
				$nazwa_apt = $_SESSION['apt'];
				$data = date('Y-m-d');
				
				$polaczenie->query("INSERT INTO utylizacja VALUES (NULL, '$nazwa_apt', '$id', '$lek', '$data')");
				
				$sql = "DELETE FROM zawartosc WHERE id_lek='$id'";
				$polaczenie->query($sql);				
			}
			else
			{	
				$polaczenie->query("UPDATE zawartosc SET ilosc='$ilosc' WHERE id_lek='$id'");			
			}
			unset($_POST['zazyj']);
			header('Location: WyswietlApteczke.php?operacja=104');
			
		}
		
		if(isset($_POST['usun']))
		{
			//echo $_POST['usun'];
			$id = $_POST['usun'];
			$sql = "SELECT lek FROM zawartosc WHERE id_lek='$id'";
			$rezultat = @$polaczenie->query($sql);
			$wiersz = $rezultat->fetch_assoc();	
			
			$lek = $wiersz['lek'];
			$nazwa_apt = $_SESSION['apt'];
			$data = date('Y-m-d');
			
			$polaczenie->query("INSERT INTO utylizacja VALUES (NULL, '$nazwa_apt', '$id', '$lek', '$data')");
			
			$sql = "DELETE FROM zawartosc WHERE id_lek='$id'";
			$polaczenie->query($sql);
			
			unset($_POST['usun']);
			header('Location: WyswietlApteczke.php?operacja=104');
		}
		
		
		//Wyświetlanie danych ----------------------------------------------------------
		include 'inc/TabZawartosc.php';
		while($wiersz = $rezultat->fetch_assoc())
		{
			$id = $wiersz['id_lek'];
			
			$table = "<tr><td> %d </td><td> %s </td><td> %s </td><td> %s </td><td> %s </td><td> %d </td><td> %s </td><td> %.2f </td><td> %s </td><td> %s </td></tr>";
			
			printf($table, $wiersz['id_lek'], $wiersz['lek'], $wiersz['postac'],
				$wiersz['dawka'], $wiersz['opakowanie'], $wiersz['ilosc'],
				$wiersz['data_waznosci'], $wiersz['cena'],
				"<form method=post>
					<input type='hidden' id='id' name='usun' value=$id>
					<input type='submit' value=$txtUsunPrzycisk />
				</form>", 
				"<form method=post>
					<input type='hidden' id='id' name='zazyj' value=$id>
					<input type='submit' value=$txtZazyjPrzycisk />
				</form>");
		}
		
	
		
	}


?>
</tbody></table>