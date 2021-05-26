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
	$(document).ready(function(){
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
	 });
</script>


<section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9">

<!-- start main body -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Add Match Score</div>
<p style="line-height:20px; font-size:13px">You played a match without actually creating or registering it, you can still add it to your profile here.
<?php if($this->session->userdata('user')=="") { ?>
<br>
Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to add score.</p>
<?php } ?>
</div>

<?php if($this->session->userdata('user')!="") { ?>	

	
<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
	<div class="fromtitle">Add Score for played match</div>


	<div class='form-group'>
	<label class='control-label col-md-4' for='id_title' align='right'>Select Tournament</label>
	<div class='col-md-5 form-group internal'>

	<select name="match" id="match" class='form-control'>
		<option value="" readonly>Select</option>
		<option value="new-match">New Match</option>
		<option value="" disabled>----------------------------------------------------</option>
		<?php foreach($tournaments as $row) { ?>
			<option value="<?php echo $row->Tournament_ID;?>">
			<?php $get_title = $this->model_addscore->get_tournment_title($row->Tournament_ID); 
				echo $get_title['tournament_title'];?>
		</option>
		<?php } ?>
	</select>

	</div>
	</div>

	<div id="new_match" style="display:none">
	
	<?php 
		$this->load->view('view_addscore_newmatch.php');	
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