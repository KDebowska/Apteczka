<!--<br/>
<h4> Wybierz jedno z dwóch </h4> -->
<br/>
<form method="post">
	<?php echo $txtPodajNazweLeku; ?> <br/> 
	<input type="text" name="lek"/>
	<input type="submit" value=<?php echo $txtSzukaj; ?> />
	<br/>
</br>

<?php
	

	
	if(isset($_POST['id']))
	{
		include "Dodajlek.php";
	}
	else
	{
		if(isset($_POST['lek']))
		{
				
			$nazwa = $_POST['lek'];
			$sql = "SELECT id, NazwaHandlowa, Postac, Opakowanie FROM listalekow WHERE NazwaHandlowa='$nazwa'";
			$rezultat = @$polaczenie->query($sql);
			$ile_lekow = $rezultat->num_rows;
			
			if($ile_lekow > 0)
			{
				include "inc/TabSpisLekow.php";
				
				while($wiersz = $rezultat->fetch_assoc())
				{
					$id = $wiersz['id'];
					$tabela = "<tr><td> %d </td><td> %s </td><td> %s </td><td> %s </td><td> %s </td></tr>";
					printf($tabela, $wiersz['id'], $wiersz['NazwaHandlowa'], 
							$wiersz['Postac'], $wiersz['Opakowanie'],
							"<form method=post>
								<input type='hidden' id='id' name='id' value=$id>
								<input type='text' name='cena'>
								<input type='submit' value='Dodaj lek'/>
							</form>");
				}
				echo "</tbody></table>";			
				
			}
			else
			{
				echo $txtBrakLeku;
			}	
		}
	}
	
?>

