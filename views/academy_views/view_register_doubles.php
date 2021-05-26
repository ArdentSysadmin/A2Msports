

<script>
	$(document).ready(function(){

		var baseurl = "<?php echo base_url();?>";
		
$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
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
  	autoFocus: true,	      	
  	minLength: 1,
  	select: function( event, ui ) {
		var names = ui.item.data.split("|");						
		$('#created_users_id').val(names[1]);
	//	$('#phone_code_1').val(names[2]);
		//$('#country_code_1').val(names[3]);
	}		      	
});

});

</script>


	<section id="single_player" class="container secondary-page">


	<div class="top-score-title right-score col-md-9">
        <!-- start main body -->
		<h3></h3>
	<?php
	if($match_det)
	{ 
	?>
		<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>play/register/<?php echo $match_det['GeneralMatch_id'] ;?>"> 

			<input type="hidden" name="id" value="<?php echo $match_det['GeneralMatch_id'];?>" /> 

		  <div class="col-md-12 league-form-bg">

           		<div class="fromtitle"><?php echo $match_det['Match_Title']; ?></div>

                <div class="col-md-12">
                    
                    

						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Match Type :</b> </label>
						<div class="col-md-6 form-group internal">
						<?php 
							 echo "Doubles";?>
						</div>
						</div>
						
						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Match Initiator:</b> </label>
						<div class="col-md-7 form-group internal" style="font-size:16px; color:#ff8a00; font-weight:bold; padding-bottom:10px">
						<?php $match_init_name = play::get_user($match_det['users_id']);
							 echo ucfirst($match_init_name['Firstname'])." ".ucfirst($match_init_name['Lastname']);?>
							-- Partner(<?php $match_partner = play::get_user($match_det['Player1_Partner']);
							 echo ucfirst($match_partner['Firstname'])." ".ucfirst($match_partner['Lastname']);?>)
						</div>
						
						</div>

						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Sport :</b> </label>
						<div class="col-md-6 form-group internal">
						<?php $sport_name = play::get_sport($match_det['Sports']);
							 echo $sport_name['Sportname'];?>
						</div>
						</div>
						
						
						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Partner :</b> </label>
						<div class="col-md-6 form-group internal">
						<input class='ui-autocomplete-input col-md-3 form-control' id='created_by' name='created_by' type='text' placeholder="Player Name" value=""  required/>
						<input class='ui-autocomplete-input form-control' id='created_users_id' name='created_users_id' type='hidden' placeholder="user id" value="" size="5" />
						</div>
						</div>

						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>preferable Date:</b> </label>
						<div class="col-md-6 form-group internal">
						
						<?php if($match_det['Match_Date'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date']);
						$date0 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date'])) : date("m-d-Y", strtotime($match_det['Match_Date'])); ?>
						 <input type="radio" name="reg_date" value="<?php echo $match_det['Match_Date'];?>">  <?php echo $date0 ."<br />";?> 
						
						<?php } ?>

						<?php if($match_det['Match_Date2'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date2']);
						$date1 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date2'])) : date("m-d-Y", strtotime($match_det['Match_Date2'])); ?>
						 <input type="radio" name="reg_date" value="<?php echo $match_det['Match_Date2'];?>">  <?php echo $date1 ."<br />";?> 
						
						<?php } ?>

						<?php if($match_det['Match_Date3'] != ""){ 
						
						$split_date = explode(" ",$match_det['Match_Date3']);
						$date2 = ($split_date[1] != "00:00:00.000") ?
						 date("m-d-Y h:i A", strtotime($match_det['Match_Date3'])) : date("m-d-Y", strtotime($match_det['Match_Date3'])); ?>
						 <input type="radio" name="reg_date" value="<?php echo $match_det['Match_Date3'];?>">  <?php echo $date2 ."<br />";?> 
						
						<?php } ?>

						 <input type="radio" name="reg_date" value="">  None <br />

						</div>
						</div>
						
						 <div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Description:</b> </label>
						<div class="col-md-6 form-group internal">
						<?php echo $match_det['Message']; ?>
						
						</div>
						</div>

						<div class='form-group'>
						<label class='control-label col-md-3 padtop' for='id_accomodation'><b>Comments:</b> </label>
						<div class="col-md-6 form-group internal">
						<textarea name="comments" id="" rows="4" cols="50"></textarea>
						</div>
						</div>

                        
						<div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'></label>
						<div class='col-md-7 form-group internal'>
						<?php if(( $this->session->userdata('users_id') == $match_det['Player1_Partner'])){ ?>
							<div class="col-md-12 form-group internal">
							<h4 style="color:red">You have already selected as partner,not able to register this match .</h4>
							</div>
						<?php } else if($match_det['users_id'] == $this->session->userdata('users_id')){ ?>

							<a href="<?php echo base_url();?>play/match/<?php echo $match_det['GeneralMatch_id'];?>">Edit Details</a>
						<?php } else {  ?>

					    <input name="doubles_match" type="submit" value="Register" class="league-form-submit1" style="margin:20px 0px"/>

						<?php } ?>
						</div>
						</div>

                   
               </div>
        </div>

		</form>
	<?php 
	}
	else
	{ 
	?>
		<p style="line-height:20px; font-size:13px"><h5>Oops! Invalid Access. Please contact admin@a2msports.com</h5></p>
	<?php
	}
	?>
             
   </div><!--Close Top Match-->
