<?php
	
	$apt = $_SESSION['apt'];
	$sql = "SELECT * FROM zawartosc WHERE nazwa_apt='$apt'";
	$rezultat = @$polaczenie->query($sql);
	$ile_lekow = $rezultat->num_rows;
	
	if($ile_lekow > 0)
	{
		echo '<br>';
		
		while($wiersz = $rezultat->fetch_assoc())
		{
			$data = $wiersz['data_waznosci'];
			$id_lek = $wiersz['id_lek'];
			$lek = $wiersz['lek'];
						
			if($data < date('Y-m-d'))
			{
				$komunikat = "<span style='color:red'> -- PRZETERMINOWANY </span>";
				$table = "%s %d %s %s %s %s %s";
				printf($table,"<b>ID:</b> ", $id_lek, "| <b>Nazwa:</b> ", $lek, "| <b>Data ważności:</b> ", $data, $komunikat);
				echo '<br>';
			}

		}
		echo '<br>';
		
		
	}
	
	
?>
