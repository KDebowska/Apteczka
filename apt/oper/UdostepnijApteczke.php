<?php
	$apt = $_SESSION['apt'];
	
	// Sprawdzenie czy użytkownik jest administratorem danej apteczki
	$sql = "SELECT user FROM apteczki WHERE nazwa_apt='$apt'";
	$rezultat = @$polaczenie->query($sql);
	$row = mysqli_fetch_row($rezultat);
	$user =  $row[0];
	
	$wszystko_OK = true;
	
	if($user != $_SESSION['user'])
	{
		echo $txtNieAdmin;
	}
	else
	{
		if(isset($_POST['login']))
		{
			$login = $_POST['login'];
			
			//sprawdzenie czy jest taki użytkownik w bazie
			$sql = "SELECT id_user FROM uzytkownicy WHERE user='$login'";
			$rezultat = @$polaczenie->query($sql);
			$ile_userow =  $rezultat->num_rows;
			
			if($ile_userow == 0)
			{
				$wszystko_OK = false;
				$_SESSION['e_upr'] = $txtBladUser;
			}
			
			if($wszystko_OK == true)
			{
				if($polaczenie->query("INSERT INTO uprawnienia VALUES (NULL, '$login', '$apt')"))
				{
					echo "<br>".$login.$txtUdostepnione;				
				}
			}
		}
	}

?>

<form method="post">

	<?php echo $txtPodajLogin; ?> <br/> <input type="text" name="login"/><br/>
	
	<?php
		if(isset($_SESSION['e_upr']))
		{
			echo '<div class="error">'.$_SESSION['e_upr'].'</div>';
			unset($_SESSION['e_upr']);
		}
	?>
		
	<input type="submit" value="<?php echo $txtWybierz; ?>"/>
		
</form>
