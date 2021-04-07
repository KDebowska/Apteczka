<?php
	//plik z namiarami na bazę
	$host = "localhost";
		$db_user = "root";
		$db_password = "";
		$db_name = "apteczka";
	
	/*function polaczenie()
	{
		global $txtBladSerwera;
	    
		$host = "localhost";
		$db_user = "root";
		$db_password = "ff";
		$db_name = "apteczka";
		
		if(isset($_SESSION['bladPolaczenia'])) 
			unset($_SESSION['bladPolaczenia']);
        
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if($polaczenie->connect_errno!=0) //False, gdy uda się połączyć
		{
			$_SESSION['bladPolaczenia'] = $txtBladSerwera;
			return NULL; //Nie udało się połączyć z bazą
		}
		else
		{
			//$polaczenie->set_charset("utf8");
            return $polaczenie; //Udało się połączyć
		}
		
	}*/

?>