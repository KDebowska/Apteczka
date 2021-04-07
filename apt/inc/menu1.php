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
            <a class="dropdown-item" href="apka.php?operacja=101"><?php echo $txtStworzApt; ?></a>
            <a class="dropdown-item" href="apka.php?operacja=102"><?php echo $txtWybierzApt; ?></a>
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