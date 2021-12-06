<style>
.input-box1{ width: 40%; }
.input-box2{ width: 10%; }
.input-box3{ width: 40%; }

.form-control{ display: inline; }

/*body{
	table > th {font-size: 14px;}
}*/
</style>

<script>
$(document).ready(function(){
	$('#priv_ls_price').blur(function(e){
		if($(this).val()){
			var pp = $(this).val();
			if(confirm("Do you want to apply this price for all the Private lesson slots?")){
				//$('.input-box1').val($(this).val());
				$("input:checkbox:not(:checked)").each(function () {
				var id = $(this).attr("id");
				var y		= id.split('_');
				$('#p_'+y[1]).val(pp);
				});

				e.preventDefault();
			}
		}
	});

	$('#grp_ls_price').blur(function(e){
		if($(this).val()){
			var gp = $(this).val();
			if(confirm("Do you want to apply this price for all the Group lesson slots?")){
				$("input:checked").each(function () {
				var id = $(this).attr("id");
				var y		= id.split('_');
				$('#p_'+y[1]).val(gp);
				});

				e.preventDefault();
			}
		}
	});

$('.check-box').click(function(e){
		var prt_price  = $('#priv_ls_price').val();
		var grp_price = $('#grp_ls_price').val();

				var cid  = $(this).attr('id');
		var x		= cid.split('_');

		if($(this).is(":checked") && grp_price != '')
			$('#p_'+x[1]).val(grp_price);
		else if(!$(this).is(":checked") && prt_price != '')
			$('#p_'+x[1]).val(prt_price);
});

	$('.check-box1').click(function(e){
		//alert($(this).is(":checked"));
		var cid  = $(this).attr('id');
		var x		= cid.split('_');

		if(confirm("Do you want to apply this change on all Days?")){
			$('.cb_'+x[1]).prop('checked', $(this).is(":checked"));
		}


		var prt_price  = $('#priv_ls_price').val();
		var grp_price = $('#grp_ls_price').val();

		//if($('#p_'+x[1]).val() == ''){
			if($(this).is(":checked") && grp_price != ''){
				$('#p_'+x[1]).val(grp_price);
			}
			else if(!$(this).is(":checked") && prt_price != ''){
				$('#p_'+x[1]).val(prt_price);
			}
		//}



		/*else{
			if($(this).is(":checked") && $('#p_'+x[1]).val() == prt_price){
				$('#p_'+x[1]).val(grp_price);
			}
			else if(!$(this).is(":checked") && $('#p_'+x[1]).val() == grp_price){
				$('#p_'+x[1]).val(prt_price);
			}
		}*/

	});


	$('.input-box1').blur(function(e){
		//alert($(this).is(":checked"));
		var cid  = $(this).attr('id');
		var x		= cid.split('_');

		if($(this).val()){
			if(confirm("Do you want to apply this price on all Days?")){
				$('.ib_'+x[1]).val($(this).val());
			}
		}


		/*var prt_price  = $('#priv_ls_price').val();
		var grp_price = $('#grp_ls_price').val();

			if($(this).is(":checked") && grp_price != ''){
				$('#p_'+x[1]).val(grp_price);
			}
			else if(!$(this).is(":checked") && prt_price != ''){
				$('#p_'+x[1]).val(prt_price);
			}*/

	});

});
</script>
<?php
			/*	$list_type		  = $this->input->post('bracket_size');

				if($list_type == 'participants'){
					$participants	  = $this->input->post('tournament_participants');
					$players		  = explode("\n", str_replace("\r", "", $participants));
				}
				else {
					$num_participants = $this->input->post('no_of_participants');
					$players		  = array();
					
					for($i = 0; $i < $num_participants; $i++) {
						$players[$i] = ($i+1).")"; 
					}
				}*/
?>

<section id="single_player" class="container secondary-page"> 
<div class="top-score-title right-score col-md-12"> 
<!-- Google AdSense -->
<!-- <div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9772177305981687"
     data-ad-slot="1273487212"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> -->
<!-- Google AdSense -->
<form class="form-horizontal" name='free_bracket_form' id='free_bracket_form' method='post' action="<?php echo base_url().'coach/update';?>">  

<div class="col-md-12 league-form-bg" style="margin-top:30px;"> 
<div class="fromtitle">Schedule</div>

<div class="table-responsive">
	<div class="col-md-12" style="padding-bottom: 15px;">
	<label>Price for private lesson? &nbsp;</label>
	<input type='number' class="form-control input-box2" name='priv_ls_price' id='priv_ls_price' style='width:10%;' value='' />
	</div>
	<div class="col-md-12" style="padding-bottom: 15px;">
	<label>Price for group lesson? &nbsp; &nbsp;</label>
	<input type='number' class="form-control input-box2" name='grp_ls_price' id='grp_ls_price' style='width:10%;' value='' />
	</div>
	<div class="col-md-12" style="padding-bottom: 15px;">
	<label>Club members discount for Private lesson?  &nbsp;</label>
	<input type='number' class="form-control input-box2" name='priv_mem_discount' id='priv_mem_discount' value='<?php if($get_coach['Coach_Priv_Members_Disc']) echo $get_coach['Coach_Priv_Members_Disc']; else '0'; ?>' />
	</div>
	<div class="col-md-12" style="padding-bottom: 15px;">
	<label>Club members discount for Group lesson?  &nbsp; &nbsp;</label>
	<input type='number' class="form-control input-box2" name='grp_mem_discount' id='grp_mem_discount' value='<?php if($get_coach['Coach_Grp_Members_Disc']) echo $get_coach['Coach_Grp_Members_Disc']; else '0'; ?>' />
	</div>
</div>
<div class="table-responsive">
                                 <table class="tab-score caltable">
                                  <tr>
                                  	<th style="width: 6%;">&nbsp;</th>
									<th style="font-size: 14px;">Monday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
                                  	<th style="font-size: 14px;">Tuesday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
                                  	<th style="font-size: 14px;">Wednesday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
                                  	<th style="font-size: 14px;">Thursday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
									<th style="font-size: 14px;">Friday&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
									<th style="font-size: 14px;">Saturday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
									<th style="font-size: 14px;">Sunday&nbsp;&nbsp;&nbsp;<i class="fa fa-users" aria-hidden="true" title="Group Lesson"></i></th>
                                 </tr>
<?php
//echo "<pre>"; print_r($coachTimings); exit;
//$x = array_column($coachTimings, 'first_name');
$j = 1;
for($i = 5; $i<=22; $i++){
	$st_time  = date('H:i:s', strtotime($i.":00:00"));
?>
                                 <tr>
                                  	<td style='font-weight:700'>&nbsp;<?php if($i==12){ echo $i; } else { echo ($i % 12); }?> <?php echo ($i >= 12) ? "PM" : "AM"; ?></td>
									<td><input type="text" id="p_mo<?=$j;?>" name="price[<?=$i.'-0';?>]" class='form-control input-box1' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Mon_Price) { echo number_format($coachTimings[$i-5]->Mon_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_mo<?=$j;?>" name="c1[<?=$i.'-0';?>]"  class='check-box1' value="1" <?php if($coachTimings[$i-5]->Mon_Is_Group) { echo "checked"; } ?> /></td>
                                  	
									<td><input type="text" id="p_tu<?=$j;?>" name="price[<?=$i.'-1';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Tue_Price) { echo number_format($coachTimings[$i-5]->Tue_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_tu<?=$j;?>" name="c1[<?=$i.'-1';?>]" class='check-box cb_mo<?=$j;?>' value="1" <?php if($coachTimings[$i-5]->Tue_Is_Group) { echo "checked"; } ?>></td>

									<td><input type="text" id="p_wd<?=$j;?>" name="price[<?=$i.'-2';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Wed_Price) { echo number_format($coachTimings[$i-5]->Wed_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_wd<?=$j;?>" name="c1[<?=$i.'-2';?>]" class='check-box cb_mo<?=$j;?>' value="1" <?php if($coachTimings[$i-5]->Wed_Is_Group) { echo "checked"; } ?>></td>

									<td><input type="text" id="p_th<?=$j;?>" name="price[<?=$i.'-3';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Thu_Price) { echo number_format($coachTimings[$i-5]->Thu_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_th<?=$j;?>" name="c1[<?=$i.'-3';?>]" class='check-box cb_mo<?=$j;?>' value="1" <?php if($coachTimings[$i-5]->Thu_Is_Group) { echo "checked"; } ?>></td>

									<td><input type="text" id="p_fr<?=$j;?>" name="price[<?=$i.'-4';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Fri_Price) { echo number_format($coachTimings[$i-5]->Fri_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_fr<?=$j;?>" name="c1[<?=$i.'-4';?>]" class='check-box cb_mo<?=$j;?>' value="1" <?php if($coachTimings[$i-5]->Fri_Is_Group) { echo "checked"; } ?>></td>

									<td><input type="text" id="p_sa<?=$j;?>" name="price[<?=$i.'-5';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Sat_Price) { echo number_format($coachTimings[$i-5]->Sat_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_sa<?=$j;?>" name="c1[<?=$i.'-5';?>]" class='check-box cb_mo<?=$j;?>'value="1" <?php if($coachTimings[$i-5]->Sat_Is_Group) { echo "checked"; } ?>></td>

									<td><input type="text" id="p_su<?=$j;?>" name="price[<?=$i.'-6';?>]" class='form-control input-box3 ib_mo<?=$j;?>' placeholder='n/a' value="<?php if($coachTimings[$i-5]->Sun_Price) { echo number_format($coachTimings[$i-5]->Sun_Price, 1); } ?>" />
									&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="c_su<?=$j;?>" name="c1[<?=$i.'-6';?>]" class='check-box cb_mo<?=$j;?>' value="1" <?php if($coachTimings[$i-5]->Sun_Is_Group) { echo "checked"; } ?>></td>
								 </tr>
<?php
$j++;
}
?>
                                 </table>
								 <br>
								 </div>
<div align="center"><input type="submit" value="Update" style="margin-top:10px" class="league-form-submit"></div>
</div> 
</div> 
</form>

<!-- ------------------------- -->

<script>

$('html, body').animate({
scrollTop: ($('#bracket_result').offset().top)
}, 500);

</script>
<!-- ------------------------- -->
<div style="clear:both"></div>
</div>
<!--Close Top Match -->