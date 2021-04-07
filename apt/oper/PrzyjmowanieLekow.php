<!-- Formularz wyboru -->

<form method="post">
	<!-- Lista rozwijana leków -->
	<?php echo $txtWybierzLek ?> <br/> 
	<select name="id_lek"><br/>
<?php
	$nazwa_apt = $_SESSION['apt'];
	$sql = "SELECT id_lek, lek from zawartosc WHERE nazwa_apt='$nazwa_apt'";
	$rezultat = @$polaczenie->query($sql);
	
	while($wiersz = $rezultat->fetch_assoc())
	{
		$lek = $wiersz['lek'];
		$id_lek = $wiersz['id_lek'];
		echo "<option value='$id_lek'>$id_lek: $lek</option>";
	}
?>	
	</select><br/>

	<!-- Lista rozwijana użytkowników -->
	<?php echo $txtWybierzUsera ?> <br/>
	<select name="user">
<?php
	$nazwa_apt = $_SESSION['apt'];
	$sql = "SELECT user from uprawnienia WHERE nazwa_apt='$nazwa_apt'";
	$rezultat = @$polaczenie->query($sql);
	
	while($wiersz = $rezultat->fetch_assoc())
	{
		$user = $wiersz['user'];
		echo "<option value='$user'>$user</option>";
	}
?>	
	</select><br/>
	
	<?php echo $txtDataPocz ?> <br/> 
	<input type="date" name="data1"/><br/> 
	
	
	<?php echo $txtDataKon ?> <br/> 
	<input type="date" name="data2"/><br/> 
	<?php
		if(isset($_SESSION['e_data']))
		{
			echo $_SESSION['e_data'];
			unset($_SESSION['e_data']);
		}
	
	?>
	<br/>
	<input type="submit" value=<?php echo $txtSprawdz; ?> />
	<br/>
</br>
</form>


<?php

	$nazwa_apt = $_SESSION['apt'];
		
	if(isset($_POST['user']))
	{
		$user =  $_POST['user'];
		$id_lek = $_POST['id_lek'];
		
		//wyciąganie leku z listy tabeli zuzycie
		$sql = "SELECT lek FROM zuzycie WHERE id_lek='$id_lek'";
		$rezultat = @$polaczenie->query($sql);
		$wiersz = $rezultat->fetch_assoc();
		
		$lek = $wiersz['lek'];
		
		if($_POST['data1'] != NULL && $_POST['data2'] != NULL)
		{
			$data1 = $_POST['data1'];
			$data2 = $_POST['data2'];
			$data = $data1;
			$tabIle = []; // tabela ilosci zażytego leku w danym dniu
			$tabData = []; // tabela dat
			$kolory = []; // tabela kolorów wykresu
			//$razem_wart = 0;
			
			$i = 0;	

			echo $txtZuz1.$lek.$txtZuz2.$user.$txtZuz3.$data1.$txtZuz4.$data2.$txtZuz5;
			
			while($data <= $data2)
			{
				$sql = "SELECT ile FROM zuzycie WHERE data_uzycia='$data' AND user='$user' AND id_lek='$id_lek'";
				$rezultat = @$polaczenie->query($sql);
				$ile_rezultatow = $rezultat->num_rows;
				$tabData[$i] = $data;

				if($ile_rezultatow > 0)
				{
					$wiersz = $rezultat->fetch_assoc();
					$tabIle[$i] = $wiersz['ile'];
					$kolory[$i] = '#809aeb';
				}
				else 
				{
					$tabIle[$i] = 0;
					$kolory[$i] = '#809aeb';
				}
				
				//$razem_wart += $tabIle[$i];
				$i += 1;
				$data = date('Y-m-d', strtotime($data .'+1 day'));
			}
			
			echo "<table class='table'>
					<thead>
					<th> $txtData </th>
					<th> $txtIlosc </th>
					</thead>
					<tbody>";
					
			$table = "<tr><td width='160'>  %s </td><td> %s </td></tr>";
			for($i = 0; $i < count($tabIle); $i++)
			{
							
				//$pre = number_format(($tabIle[$i]), 2, ",", " ");
				$wysokosc = floor($tabIle[$i])*50;
				//$kolor = $kolory[$i];

				$kol1 = "<font face='tahoma' size='4' color='#000000'>".$tabData[$i]."</font></p>";
				$kol2 = "<p style='width:".$wysokosc."px; background-color:".$kolory[$i]."; padding:4px;'>
				<font face='tahoma' size='4' color='#000000'>".$tabIle[$i]."</font></p>"; 
				
				printf($table, $kol1, $kol2);
				
			}
			
			echo "</tbody></table>";
		
			unset($_POST['user']);
		}
		else
		{
			$_SESSION['e_data'] = $txtDataBlad;
		}
	}


?>

