<div class="container">

<!-- Przycisk menu Apteczki -->   
    <div class="btn-group">
        <hr>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="menu1Lista"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php 
                echo $txtApteczka;
            ?>
        </button>
    
        <div class="dropdown-menu" aria-labelledby="menu1Lista">
            <a class="dropdown-item" href="WyswietlApteczke.php?operacja=103"><?php echo $txtUdostepnij ?></a>
            <a class="dropdown-item" href="WyswietlApteczke.php?operacja=104"><?php echo $txtZawartosc ?></a>
			<a class="dropdown-item" href="WyswietlApteczke.php?operacja=105"><?php echo $txtRozchody ?></a>
			<a class="dropdown-item" href="WyswietlApteczke.php?operacja=106"><?php echo $txtPrzyjmowanie ?></a>
        </div>
	</div>	
		
	<div class="btn-group">	
		<button class="btn btn-secondary dropdown-toggle" type="button" id="menu2Lista"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php 
                echo $txtSpisLekow;
            ?>
        </button>
    
        <div class="dropdown-menu" aria-labelledby="menu2Lista">
            <a class="dropdown-item" href="WyswietlApteczke.php?operacja=201"><?php echo $txtLista ?></a>
            <a class="dropdown-item" href="WyswietlApteczke.php?operacja=202"><?php echo $txtWyszukaj ?></a>
        </div>	
    </div> 
	
	<!-- Wylogowanie -->
	<div class="btn-group">	
		<?php
			echo "<form action='wyloguj.php' method=post>
					<input type='submit' value=$txtWyloguj />
				</form>";
		?>
    </div> 
	

</div>