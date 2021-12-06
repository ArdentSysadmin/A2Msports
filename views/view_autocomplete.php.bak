

	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.autocomplete.css" />
	
	<script type="text/javascript" src="<?php echo base_url();?>include/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>include/jquery.autocomplete.js"></script>

	<script>
	
	$(document).ready(function(){
		$("#player_name").autocomplete("<?php echo base_url();?>autocomplete.php", {
		selectFirst: true
		});
	});
	</script>


	<form action="<?php echo base_url();?>" method="POST" id="feedback">
		<h2>Search Player</h2><hr />

		
		<p>
            <label for="player_name">Player name:</label>
            <input name="player_name" id="player_name" type="text" value="<?php echo set_value('player_name');?>" class="formbox">
        </p>
		
		 <p>
               <input name="submit" id="submit" type="submit" value="Submit">
        </p>
		
	</form>