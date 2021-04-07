<?php

	if(isset($_POST['id']))
	{
		$id = $_POST['id'];
		$sql = "SELECT NazwaHandlowa FROM listalekow WHERE id=$id";
		$rezultat = @$polaczenie->query($sql);
		$ile_odp =  $rezultat->num_rows;
		
		//if($ile_odp > 0)
		//{
			
			if(is_numeric($_POST['cena']))
			{
				$cena = (float)$_POST['cena'];
				
				$id = $_POST['id'];
				$sql = "SELECT NazwaHandlowa, Postac, Dawka, Opakowanie FROM listalekow WHERE id=$id";
				$rezultat = @$polaczenie->query($sql);
				$wiersz = $rezultat->fetch_assoc();
				$nazwa_leku = $wiersz['NazwaHandlowa'];
				$postac = $wiersz['Postac'];
				$dawka = $wiersz['Dawka'];
				$opakowanie = $wiersz['Opakowanie'];
				$ilosc = (int)$wiersz['Opakowanie'];
				$i = rand(30,400);
				$data = date('Y-m-d', time()+($i*24*60*60)); //Losowanie daty ważności
				$nazwa_apt = $_SESSION['apt'];
				$user = $_SESSION['user'];
				
				if($polaczenie->query("INSERT INTO zawartosc VALUES (NULL, '$nazwa_apt', '$nazwa_leku', '$postac', '$dawka', '$opakowanie', '$ilosc', '$data', '$cena')"))
				{
					echo $txtDodano;
				}
					
			}
			else if((int)$_POST['cena'] > 0)
			{
				echo $txtBladCeny;
			}

		//}
		
		unset($_POST['id']);
	}
?>