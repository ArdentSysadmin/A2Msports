<script>
	/*$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#match').on('change',function(){
	
		var $match = $(this).val();

		if($match == "new-match"){
			$("#new_match").show();
		    
	    }else
		{
		  $("#new_match").hide();  
		}
	  });  
	 });*/
</script>

<script>
/*	$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#match').on('change',function(){
	
		var Tourn_id = $(this).val();

        if(Tourn_id == "new-match"){
			
			$("#loading").hide();
			$("#new_match").show();
			$("#no_result").hide();
			$("#load-draws").style('display','none');
			
		}
		else if(Tourn_id != "" && Tourn_id != "new-match"){
			
			$("#new_match").hide();
			 $("#loading").show();
			 $("#no_result").hide();
            $.ajax({
                type:'POST',
                url:baseurl+'Addscore/draws_view/',
                data:{ tourn_id:Tourn_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
					 $("#loading").hide();
					 $('#load-draws').html(html);

				}
            }); 
        }
		else
		{
			$("#loading").hide();
			$("#new_match").hide();
			$("#no_result").hide();
			$("#load-draws").style('display','none');
		}
		
     });
	 });  */
</script>

<script>
	$(document).ready(function(){
		$('#go').click(function(){
			var club_val = $('#match').val();
			if(club_val == ''){
				alert('Please select a club.');
				return false;
			}
			else{
				window.location.href = '<?php echo base_url();?>'+club_val+'/courts/reserve';
			}
		})
	});
</script>

<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">

<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Reserve a Court, Table or Any Space</div>
<p style="line-height:20px; font-size:13px">You can reserve a Court for any Racket Sport, a Table for Table Tennis or any space your club allows you reserve.
<?php if($this->session->userdata('user')== "") { ?>
<br>
Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>Reserve a Court.</p>
<?php } ?>
</div>

<?php if($this->session->userdata('user')!= "") { ?>	

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
<div class="fromtitle">Select a Club where you want to Reserve</div>

<div class='form-group'>
				<!-- <label class='control-label col-md-4' for='id_title' align='right'>Select a Club</label>
				<div class='col-md-5 form-group internal'>

				<select name="match" id="match" class='form-control'>
					<option value="" readonly>Select</option>
					<?php foreach($clubs as $row) { $row->Aca_logo; ?>
						<option value="<?php echo $row->Aca_URL_ShortCode;?>">
						<?php 
							//$get_title = $this->model_addscore->get_tournment_title($row->Tournament_ID); 
							//echo $get_title['tournament_title'];
						?>
						<?=$row->Aca_name;?>
					</option>
					<?php } ?>
				</select>

				</div>
				<div class='col-md-3 form-group internal'>
					<input class='league-form-submit1' type='button' name='go' id='go' value='Go' style='margin-top: 3px;' />
				</div> -->

<?php
foreach($clubs as $row) {
?>
<div class='col-md-4 form-group internal' style='text-align:center; padding:10px;'>
<a href="<?=base_url().$row->Aca_URL_ShortCode;?>/courts/reserve">
<img id = '' src='<?=base_url()."org_logos/".$row->Aca_logo; ?>' style="width:80px; height:70px;" />
</a>
<br /><br />
<a href="<?=base_url().$row->Aca_URL_ShortCode;?>/courts/reserve" style='cursor: pointer;'>
<span style="font-family:'Open Sans', sans-serif; font-size:12px;font-weight:bold;"><?=$row->Aca_name;?></span>
</a>
</div>
<?php
}
?>
</div>

<br /><br />
	
	<!-- -----------------User draws results --------------------------------------------- -->
	<div id="load-draws">
		<br />
		<!-- <img src='<?php //echo base_url();?>images/ajax_loader.gif' width='50px' height='60px' id='loading' style="display:none;margin-left:360px;" align="middle" /> -->

	</div>
	<!-- -----------------end of user draws --------------------------------------------- -->

</div>
<?php } ?>

<!-- end main body -->
<div style="clear:both"></div>
</div><!--Close Top Match-->