<script>
"<?php $set_or_game = 'Set'; ?>"

$(document).ready(function(){
		var baseurl = "<?php echo base_url();?>";
		
		//$("#player1_partner").prop('disabled', true);
		//$("#player1_partner_id").prop('disabled', true);

		//$("#created_by1_partner").prop('disabled', true);
		//$("#created_by1_partner_id").prop('disabled', true);


$('#match_type').on('change',function(){

$mt = $('#match_type').val();
	if($mt == "Doubles"){
		
		//$("#player1_partner").prop('disabled', false);
		//$("#player1_partner_id").prop('disabled', false);

		//$("#created_by1_partner").prop('disabled', false);
		//$("#created_by1_partner_id").prop('disabled', false);   

		
		$("#partner1_show").show();
		$("#partner2_show").show();
	
		$("#format").text("Teams");
		$("#format1").text("Teams");

		$("#player_label1").text("Team-1");
		$("#player_label2").text("Team-2");

		var p = $('#player').val();
		var p2 = '; ' +  $('#player1_partner').val();

		$("#player1").text( p  + p2);
		$("#mob_player1").text( p  + p2);

		var p3 = $('#created_by1').val();
		var p4 = '; ' + $('#created_by1_partner').val();
		
		$("#player2").text(p3  +  p4);
		$("#mob_player2").text(p3  +  p4);
	}
	else{
		
		$("#partner1_show").hide();
		$("#partner2_show").hide();

		$("#player1_partner_id").val("");
		$("#created_by1_partner_id").val("");


		$("#format").text("Players");
		$("#format1").text("Players");

		$("#player_label1").text("Player-1");
		$("#player_label2").text("Player-2");

		var p = $('#player').val();
		//alert(p);
		var p3 = $('#created_by1').val();
		$("#player1").text(p);
		$("#mob_player1").text(p);

		$("#player2").text(p3);
		$("#mob_player2").text(p3);

	}
});


//------------------------------------------------------------------------------------------

$('#player1_partner').autocomplete({
	source: function( request, response ) {
  		$.ajax({
  			url:baseurl+'addscore/autocomplete/',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: false,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#player1_partner_id').val(names[1]);
		var p1 = "<?php echo $this->session->userdata('user');?>";
		var MT = $('#match_type').val(); 
		if(MT == "Doubles")
		{
		var p1_r = '; '+names[0];
		var op = p1 + p1_r;
		$("#player1").text(op);
		$("#mob_player1").text(op);
		$("#format").text("Teams");
		}
		else
		{
		$("#player1").text(p1);
		$("#mob_player1").text(p1);
		$("#format").text("Players");
		}
		
	}		      	
});

//------------------------------------------------------------------------------------------

$('#created_by1_partner').autocomplete({
	source: function( request, response ) {
  		$.ajax({
  			url:baseurl+'addscore/autocomplete/',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: false,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#created_by1_partner_id').val(names[1]);
		
		var p2 = $('#created_by1').val(); 
		var MT = $('#match_type').val(); 
		if(MT == "Doubles")
		{
		var p2_r = '; '+names[0];
		var op = p2 + p2_r;
		$("#player2").text(op);
		$("#mob_player2").text(op);
		}
		else
		{
		$("#player2").text(p2);
		$("#mob_player2").text(p2);
		}
	}		      	
});

//------------------------------------------------------------------------------------------


	});
</script>

<script>
	$(document).ready(function(){

		var baseurl = "<?php echo base_url();?>";
		
$('#created_by1').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url:baseurl+'addscore/autocomplete/',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   type: 'users',
			   row_num : 1
			},
			 success: function( data ) {
				 response( $.map( data, function( item ) {
				 	var code = item.split("|");
					return {
						label: code[0],
						value: code[0],
						data : item
					}
				}));
			}
  		});
  	},
  	autoFocus: false,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#created_users_id1').val(names[1]);
		$('#player2').html(names[0]);
		$('#mob_player2').html(names[0]);
		//$('#country_code_1').val(names[3]);
	}		      	
});

//------------------------------------------------------------------------------------------


	});
</script>

<script>
	/*$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#Sport').on('change',function(){
	
		var Sport = $(this).val();

	   var Player2 = $('#created_users_id1').val();
	   var Player1_Partner = $('#player1_partner_id').val();
	   var Player2_Partner = $('#created_by1_partner_id').val();
	   var MT = $('#match_type').val(); 
		
        if(Sport!=""){
            $.ajax({
                type:'POST',
                url:baseurl+'Addscore/table_view/',
                data:{ sport_id:Sport,p2:Player2,p1_r:Player1_Partner,p2_r:Player2_Partner,mt:MT},    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
                    $('#set_game').html(html);
                }
            }); 
        }
		
     });
	 });*/
</script>

<script>
$(document).ready(function(){

	var MT = $('#match_type').val();
	if(MT == "Doubles")
	{
		$("#format").text("Teams");
		
	}else
	{
		$("#format").text("Players");	
	}
	$('#Sport').on('change',function(){
	
		var Sport = $(this).val(); 
		var MT = $('#match_type').val();
		var rows = $('table.score-cont tr');
		if(Sport == 1){

			"<?php $set_or_game = 'Set'; ?>"
			
			if(MT == "Doubles")
			{
				$("#format").text("Teams");
				$("#format1").text("Teams");
			}else
			{
				$("#format").text("Players");
				$("#format1").text("Players");
			}
			var set = rows.filter('#tr_set').show();
			var game = rows.filter('#tr_game').hide();
				
		}else
		{

			"<?php $set_or_game = 'Game'; ?>"

			if(MT == "Doubles")
			{
				$("#format").text("Teams");
				$("#format1").text("Teams");
			}else
			{
				$("#format").text("Players");
				$("#format1").text("Players");
			}
			var game = rows.filter('#tr_game').show();
			var set = rows.filter('#tr_set').hide();
		}

	});
 });

</script>

<script type="text/javascript">
$(function(){
  $("#created_by1").change(function(){
   $("#player2").html($(this).val());
 });

 $('#player1_partner').bind('blur', function(){
     
	 $mt = $('#match_type').val(); 

	var p = $('#player').val();
	var p2 = '; ' + $('#player1_partner').val();
	
	if($mt == "Doubles"){
	$("#player1").text( p  +  p2);
	$("#mob_player1").text( p  +  p2);
	}
	else
	{
		$("#player1").text(p);
		$("#mob_player1").text(p);
	}

});

 $('#created_by1_partner').bind('blur', function(){

	  $mt = $('#match_type').val(); 
	
	var p3 = $('#created_by1').val();
	var p4 = '; ' + $('#created_by1_partner').val();
	if($mt == "Doubles"){
	$("#player2").text(p3  +  p4);
	$("#mob_player2").text(p3  +  p4);
	}else
	 {
		$("#player2").text(p3);
		$("#mob_player2").text(p3);
	 }
});
})
</script>



<!-- start main body -->
<!-- <div class="col-md-12 league-form-bg" style="margin-top:40px;">-->

<form class='form-horizontal' name='form-op-users' id='form-op-users' method="post" action='<?php echo base_url();?>addscore/add'>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title'></label>
	<div class='col-md-5 form-group internal'>

	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title'>Sport Type</label>
	<div class='col-md-5 form-group internal'>

	<select name="Sport" id="Sport" class='form-control' required>
	<option value="">Select</option>
	<?php foreach($sports as $row) { ?>
		<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname; ?></option>
	<?php } ?>
	</select>

	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_accomodation'> Name of the match you played </label>
	<div class='col-md-5 form-group internal'>
	<input type="text" id="match_title" name="match_title" class='form-control' required />
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_accomodation'> Match Type </label>
	<div class='col-md-5 form-group internal'>
	<select name="match_type" id="match_type" class='form-control' required>
	<option value="Singles">Singles</option>
	<option value="Doubles">Doubles</option>
	</select>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title'>When did you play?</label>
	<div class='col-md-4 form-group internal'>
<input  type="text" class='form-control datepicker' id="sdate"  name="match_date" placeholder="MM/DD/YYYY" value="<?php echo date("m/d/y");?>" required/>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title'><span id="player_label1">Player-1</span></label>
	<div class='col-md-4 form-group internal'>	
	<?php
		$get_user_name = addscore::get_name($this->session->userdata('users_id'));
		$player1_name = $get_user_name['Firstname']." ".$get_user_name['Lastname'];
		echo $player1_name;
		?>
  <input id='player' name='player' type='hidden' value="<?php echo $player1_name;?>" /> 

	</div>
	</div>


	<div class='form-group' id="partner1_show" style="display:none">
		<label class='control-label col-md-4' for='id_title'></label>
	<div class='col-md-4 form-group internal'>

		<input class='ui-autocomplete-input form-control' id='player1_partner' name='player1_partner' type='text' placeholder="Doubles Partner" value="<?php //echo $created_by; ?>" size="25" />
		<input class='ui-autocomplete-input form-control' id='player1_partner_id' name='player1_partner_id' type='hidden' placeholder="user id" value="" size="25" /> 
	</div>
	</div>



	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title'><span id="player_label2">Player-2</span></label>
	<div class='col-md-4 form-group internal'>

<input class='ui-autocomplete-input form-control' id='created_by1' name='player2_user' type='text' placeholder="Player2" value="<?php //echo $created_by; ?>" size="25" />
<input class='ui-autocomplete-input form-control' id='created_users_id1' name='player2_user_id' type='hidden' placeholder="user id" value="" size="25" /> 
	</div>
	</div>

<div class='form-group' id="partner2_show" style="display:none">
<label class='control-label col-md-4' for='id_title'></label>
	<div class='col-md-4 form-group internal'>	
	
	<input class='ui-autocomplete-input form-control' id='created_by1_partner' name='player2_user_partner' type='text' placeholder="Player2 Doubles Partner" value="<?php //echo $created_by; ?>" size="25" />
	<input class='ui-autocomplete-input form-control' id='created_by1_partner_id' name='player2_user_partner_id' type='hidden' placeholder="user id" value="" size="25" /> 
	</div>
</div>


	<div class='form-group'>
	<div class='col-md-12 form-group internal scoretable-web'>
	<div id="set_game">
	  <table class="score-cont">
                                
								  <tr id='tr_set'>
                                  	<th><span id="format"></span></th>
									<th>Set1</th>
                                  	<th>Set2</th>
                                  	<th>Set3</th>
                                  	<th>Set4</th>
                                    <th>Set5</th>
									<!-- <th>Set6</th> -->
                                 </tr>
								
								 <tr id='tr_game' style="display:none">
                                  	<th><span id="format1"></span></th>
									<th>Game1</th>
                                  	<th>Game2</th>
                                  	<th>Game3</th>
                                  	<th>Game4</th>
                                    <th>Game5</th>
									<!-- <th>Game6</th> -->
                                 </tr>
									
                                 <tr>
                                  	<td bgcolor="#fdd7b0" style="width:10%"><b><span id="player1"><?php echo $player1_name;?></span></b></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
									<!-- <td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td> -->
								 </tr>
                                  <tr>
                                  	<td bgcolor="#fdd7b0"><b><span id="player2">Player2</span></b></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                  	<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
                                    <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
									<!-- <td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td> -->
								 </tr>
      </table> 
	  </div>

	</div>
	 <div class="scoretable-mob">
	<table class="score-cont">
						<tr>
							<th><span id="format"></span></th>
							<th bgcolor="#fdd7b0"><b><span id="mob_player1"><?php echo $player1_name;?></span></b></th>
							<th bgcolor="#fdd7b0"><b><span id="mob_player2">Player 2</span></b></th>
							<?php /*if(1==2){ 
									$set_or_game = 'Set';
								   }
								  else
								  {
									  $set_or_game = 'Game';
								  }*/
								  echo $set_or_game;
							?>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "1"; ?>
						</td>
						<td><input id='set1_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set1_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "2"; ?>
						</td>
						<td><input id='set2_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set2_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "3"; ?>
						</td>
						<td><input id='set3_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set3_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "4"; ?>
						</td>
						<td><input id='set4_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set4_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>
						<tr>
						<td>
							<?php echo $set_or_game . "5"; ?>
						</td>
						<td><input id='set5_1' name='player1[]' style = "width:65%" type='text' maxlength='2' /></td>
						<td><input id='set5_2' name='player2[]' style = "width:65%" type='text' maxlength='2' /></td>
						</tr>

					</table>
	</div>
	 <div align="center"><input type="submit" value=" Add Score " style="margin-top:10px" class="league-form-submit" /></div>
	</div>

	</form>