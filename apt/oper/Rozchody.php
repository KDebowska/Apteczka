<?php

	$nazwa_apt = $_SESSION['apt'];
	
	$sql = "SELECT * from zuzycie WHERE nazwa_apt='$nazwa_apt'";
	$rezultat = @$polaczenie->query($sql);
	$ile_zuz = $rezultat->num_rows;
	
	if($ile_zuz > 0)
	{
		echo "<br><h4> $txtZuzycie </h4>";
		echo "<table class='table'>
				<thead>
					<th> $txtID </th>
					<th> $txtNazwa </th>
					<th> $txtUser </th>
					<th> $txtIlosc</th>
					<th> $txtDataUzycia </th>
				</thead>
				<tbody>";
			
		while($wiersz = $rezultat->fetch_assoc())
		{
			$tabela = "<tr><td> %d </td><td> %s </td><td> %s </td><td> %s </td><td> %s </td></tr>";
			printf($tabela, $wiersz['id_lek'], $wiersz['lek'], $wiersz['user'], $wiersz['ile'],
			$wiersz['data_uzycia']);
		}
				
		echo "</tbody></table>";
			
	}
	else
	{
		echo $txtBrakZuzycia;
	}
	
	$sql = "SELECT * from utylizacja WHERE nazwa_apt='$nazwa_apt'";
	$rezultat = @$polaczenie->query($sql);
	$ile_zuz = $rezultat->num_rows;
	
	if($ile_zuz > 0)
	{
		echo "<br><h4> $txtZutyl </h4>";
		echo "<table class='table'>
				<thead>
					<th> $txtID </th>
					<th> $txtNazwa </th>
					<th> $txtDataUtyl </th>
				</thead>
				<tbody>";
			
		while($wiersz = $rezultat->fetch_assoc())
		{
			$tabela = "<tr><td> %d </td><td> %s </td><td> %s </td></tr>";
			printf($tabela, $wiersz['id_leku'], $wiersz['lek'], $wiersz['data_utylizacji']);
		}
				
		echo "</tbody></table>";
			
	}
	else
	{
		echo $txtBrakUtyl;
	}	

?>