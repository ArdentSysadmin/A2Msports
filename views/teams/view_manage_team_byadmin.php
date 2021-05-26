<script>
$(document).ready(function(){ 
	$("#sel_all").change(function(){
		$(".checkbox1").prop('checked', $(this).prop("checked"));
	});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
var team = $('#team_id').val();
var tour = $('#tourn_id').val();

$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'teams/autocomplete',
  			dataType: "json",
			method: 'post',
			data: {
			   name_startsWith: request.term,
			   tour_id: tour,
			   team_id: team,
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
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		//$('#created_users_id').val(names[1]);
		//alert(names);
		$('#team_table').append('<tr><td style="padding-left:20px;"><input type="checkbox" name="sel_team_player[]" class="checkbox1" value="'+names[1]+'" /></td><td style="padding-left:10px"><b><a href="'+baseurl+'player/'+names[1]+'" target="_blank">'+names[0]+'</a></b></td><td style="padding-left:10px">'+names[2]+'</td></tr>');

		$('#sel_team_players').append($('<option/>', { 
			value: names[1],
			text : names[0] 
		}));

		$('#created_by').val(''); 
		$('#created_by').focus();

	}
});

$('.upd_team_players').click(function (e) {
  var tid     = $(this).attr('id');
  //var team_name = $('#frm_manage_team_'+tid).find('input[name="team_name"]').val();
  var formData = new FormData($("#frm_manage_team_"+tid)[0]);
  //var form_data = new FormData($('#frm_manage_team_'+tid)[0]);
  //alert(form_data);
  //if(team_name){
    $.ajax({
    type: 'POST',
    url: baseurl+'teams/update_byadmin',
    data: formData,
        async: false,
  //  data: form_data,
    success: function (res) {
     // alert(res);die();
       location.reload();
    },
    cache: false,
        contentType: false,
        processData: false
    });
  //}
  //else{
   // alert("Team Name should not empty!");
  //}
  e.preventDefault();
  });

    $('.reg_player, .btn_register_cancel').click(function(){

		if($('#rpform').css('display')=='none'){
			$('#rpform').show();
			//$('.reg_players').hide();
		}
		else{
			$('#rpform').hide();
			//$('.reg_players').show();
		}
	});

$('.btn_register').click(function(){
var baseurl       = "<?php echo base_url();?>";
var tournament_id = $("#tournament_id").val();
var sportstype    = $("#sportstype").val();
var lname	      = $("#txtlname").val();
var email	      = $("#txtemail").val();
var gender        = $("input[name='gender']:checked").val();
var zipcode       = $("#zipcode").val();
//alert(tournament_id);die();

if(lname != "" && email != ""){
var fname	= $("#txtfname").val();
var phone	= $("#txtphone").val();
$('#btn_register').prop("disabled", true);
$('#btn_register').attr('value', 'Please wait...');

    $.ajax({
		type:'POST',
		url:baseurl+'register/instant_register/',
		data:{fname:fname, lname:lname, email:email, phone:phone, gender:gender, Zipcode:zipcode,tourn_id:tournament_id, sportstype:sportstype},
		success:function(res){
			if(res != '0' && res != "User with this email id already exists!"){
			alert('User created successfully!');
            $("#txtfname").val('');
			$("#txtlname").val('');
			$("#txtemail").val('');
			$("#txtphone").val('');
			$("#zipcode").val('');
			$('#rpform').hide();
			$('#btn_register').prop("disabled", false);
			$('#btn_register').attr('value', 'Register');
			}
			else if(res == "User with this email id already exists!"){
				alert('User with this email id already exists!');
			}
			else{
				alert('Something went wrong! Please try again.');
			}
		}
    });
}
else {
  alert("Last Name, Email & Zipcode should not be empty!");
}

});

$('.txt_email').blur(function(){
	var baseurl = "<?php echo base_url();?>";
    var email_id = $(this).val();
	
		if(email_id!=""){
            $.ajax({
                type:'POST',
                url:baseurl+'register/email_check/',
                data:'email_id='+email_id,
                success:function(html){
					var stat = html;
					if(stat!=""){
                    $('#email_stat').html(stat);
					$('#txtemail').val("");
					}
					else{
					$('#email_stat').html('');	
                    $('#txtemail').html("");
					}
                }
            }); 
        }
    });
});
</script>
<form name='frm_manage_team' id="frm_manage_team_<?=$team_id;?>" method="POST"  enctype='multipart/form-data'>

<input type='hidden' name='team_id' id='team_id' value='<?=$team_id;?>' />
<input type='hidden' name='tourn_id' id='tourn_id' value='<?=$tourn_id;?>' />
<input type='hidden' name='oteam' id='oteam' value='<?php echo htmlentities(serialize($team_players)); ?>' />
<p><label>Team: </label><?=$team_name;?>
<!-- <input style='width:40%' class='form-control' name='team_name' type='text' value="<?=$team_name;?>" readonly="" /> -->
</p>
<br />
<p><label>Team Logo</label>
<?php if($team_logo!=''){?>
<img src="<?=base_url();?>team_logos/cropped/<?=$team_logo;?>">
<?php } ?>
<input type="hidden" value="<?=$team_logo;?>" name="team_old_logo_<?=$team_id;?>" id="team_old_logo_<?=$team_id;?>">
<input name='team_logo_<?=$team_id;?>' id="team_logo_<?=$team_id;?>" type='file' />	
</p>
<br />
<p><label>Search Player & Add:</label>
<input class='ui-autocomplete-input form-control inwidth' id='created_by' name='created_by' type='text' placeholder="Player Name" value="" /></p>
<br />
<p>
<div id="team_players" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:auto;width: auto;">
<table id='team_table' class="tab-score">
<tr class="">
	<th style="padding-left:20px;"><input type='checkbox' name="sel_all" id="sel_all" /></th>
	<th style="padding-left:40px;">Player</th>
	<th style="padding-left:20px;">Contact#</th>
</tr>

<?php
$build_select = "";

if(count($team_players) > 0){
foreach($team_players as $player => $status)
{
?>
<tr>
<td style="padding-left:20px;">
<?php
if($status == 1)
{?>
<img src="<?=base_url();?>icons/info_ico.png" title="Player is already part of another team for this Tournament" style="width:13px;height:13px;" />
<?php
} else {?>
<input type="checkbox" name="sel_team_player[]" class="checkbox1" value="<?php echo $player;?>" <?php if($status == 2) { echo "checked='checked'"; }?> />
<?php
} ?>
</td>

<td style="padding-left:10px">
<?php
$user = teams::get_username($player);
$selected = '';
$captain_ico = "";
if($player == $team_captain){
	$selected = 'selected';
	$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
	}

echo "<b><a href='".base_url()."player/".$user['Users_ID']."' target='_blank'>" . $user['Firstname'] . " " . $user['Lastname'] . "</a></b> &nbsp;{$captain_ico}";
?>
</td>

<td style="padding-left:10px"><?php echo $user['Mobilephone']; ?></td>
</tr>
<?php

$build_select .= "<option value='".$player."'".$selected.">".$user['Firstname']." ".$user['Lastname']."</option>";
}
}
else
{
?>
<tr><td colspan='3'>No Players found in your team!</td></tr>
<?php
}
?>
</table>
</div>
</p>
<br />
<!-- Register a new Player by tournament admin -->
<p><b>Note:</b> Click 
	<input type="button" id="rp" value="Register Player" class="reg_player league-form-submit1"> if you want to add a new player to our site.</p>
	<div class='form-group' id="rpform" style="display:none">
			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>First Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtfname" name="txt_fname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Last Name </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtlname" name="txt_lname" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Gender </label>
			<div class='col-md-5 form-group internal'>
			<input type="radio" name="gender" value="1" checked/> Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="gender" value="0" /> Female
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Email </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="txtemail" name="txt_email" class='form-control txt_email' />
			<span id='email_stat' style='color:red'></span>
			</div>
		</div>

		<!-- <div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Phone </label>
			<div class='col-md-5 form-group internal'> -->
			<input type="hidden" id="txtphone" name="txt_phone" class='form-control' />
			<!-- </div>
		</div> -->

		<!-- <div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip/Postal Code </label>
			<div class='col-md-5 form-group internal'> -->
			<input type="hidden" id="zipcode" name="Zipcode" class='form-control' />
			<!-- </div>
		</div> -->

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="hidden" value="<?php echo $r->tournament_ID ;?>" name="tournament_id" id="tournament_id" />
			<input type="hidden" value="<?php echo $r->SportsType ;?>" name="sportstype" id="sportstype" />
			<input type="button" id="btn_register" name="btn_register" value=" Register " class="btn_register league-form-submit1" />
			<input type="button" id="cancel" name="btn_register_cancel" value=" Cancel " class="league-form-submit1 btn_register_cancel" />
			</div>
		</div>

	</div>

<!-- Register a new Player by tournament admin -->

<p><label>Change Captain:</label>
<select name='team_captain' id='sel_team_players' class='form-control' style='width:30%'>
<option value=''>Select</option>
<?=$build_select;?>
</select>
</p>

<br />
<input type="submit" value="Update Team" id='<?=$team_id;?>' name='upd_team_players' style="margin-top:20px" class="upd_team_players league-form-submit" />
</div>
</form>