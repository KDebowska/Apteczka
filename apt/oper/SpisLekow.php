<?php
	include "inc/TabSpisLekow.php";
	include "Dodajlek.php";

	$limit = 25;
	$offset = 0;
	
	//Wyświetlanie leków
	$sql = "SELECT id, NazwaHandlowa, Postac, Opakowanie FROM listalekow LIMIT $limit OFFSET $offset";
	
	$rezultat = @$polaczenie->query($sql);
		
	while($wiersz = $rezultat->fetch_assoc())
	{
		//echo (int)$wiersz['Opakowanie'].'<br>';
		$id = $wiersz['id'];
		$tabela = "<tr><td> %d </td><td> %s </td><td> %s </td><td> %s </td><td> %s </td></tr>";
		printf($tabela, $wiersz['id'], $wiersz['NazwaHandlowa'],
			$wiersz['Postac'], $wiersz['Opakowanie'],
			"<form method=post>
				<input type='hidden' id='id' name='id' value=$id>
				<input type='text' name='cena'>
				<input type='submit' value=$txtDodaj />
			</form>");
	}




?>
</tbody></table>


