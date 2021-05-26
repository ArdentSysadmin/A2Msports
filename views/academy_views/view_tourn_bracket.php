<script language="javascript" type="text/javascript">
function myWin(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $bracket_id; ?>';
window.open(path+'league/pdf/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
</script>

<script>
$(document).ready(function(){
	$('#delete').click(function(e){

		var r = confirm("Once draws are deleted, can't revert back. Are you sure to delete?");

		if(r == false){
			 e.preventDefault();
			 return false;	
		}else
		{
			return true;
		}

    });
});
</script>



<section id="login" class="container secondary-page">  

<!-- LOGIN BOX -->
<div class="top-score-title right-score col-md-12">
<h4 style="text-align:center;padding:5px;text-transform: uppercase;font-size: 20px;">
<b>View Draws for <?php echo $tourn_det->tournament_title; ?></b></h4>

<div class="col-md-12 login-page">

<table class="tab-score">
<?php

if(count(array_filter($brackets)) > 0){  ?>
<!-- <tr class="top-scrore-table">

 <th width="15%">Draw Title</th>
<th width="15%">Match Type</th>
<th width="15%">Age Group</th>
<th width="15%">Action</th> 
</tr> -->
	<?php foreach($brackets as $bk)
    {
?>

<tr>
<form id="your_form" action="<?php echo base_url(); ?>league/viewbracket/" method="post">

<td>

<b><?php echo $bk->Draw_Title; ?> </b>

</td>
<td>
<b><?php echo $bk->Match_Type; ?> </b>
</td>
<td>
<b><?php echo $bk->Age_Group; ?> </b>
</td>

<td>
<b><?php echo '<input type="submit" name="tour_draw_show'.$bk->BracketID.'" id="submit" value="Show Draws" class="league-form-submit1"/>'; ?> </b>
&nbsp;&nbsp;
<?php $users_id = $this->session->userdata('users_id');
if($tourn_det->Usersid == $users_id)    /// tournament admin access links
{ ?>
<b><?php echo '<input type="submit" name="tour_draw_delete'.$bk->BracketID.'" id="delete" value="Delete Draws" class="league-form-submit1"/>'; ?> </b>
<?php }
?>
</td>

<input type='hidden' name='tourn_id' value="<?php echo $bk->Tourn_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $bk->Bracket_Type; ?>">
<input type='hidden' name='match_type' value="<?php echo $bk->Match_Type; ?>">
<input type='hidden' name='age_group' value="<?php echo $bk->Age_Group; ?>">
<input type='hidden' name='bracket_id' value="<?php echo $bk->BracketID; ?>">
<input type='hidden' name='template' value="">

</form>
</tr>
<?php
    }

 }else
 {
	echo "<tr><td>No Brackets are available</td></tr>";
 }
?>
</table>


<?php
/*echo "<pre>";
print_r($get_rr_tourn_matches);
exit;*/

if(isset($no_bracket)) { ?>
<div class="name" align='left' id="no_result">

<label for="name_login" style="color:red"><?php 
echo $no_bracket; 
unset($no_bracket);
?></label>
</div>
<?php } 
else if(isset($bracket_matches) or isset($get_tourn_matches) or isset($rr_bracket_matches) or isset($get_rr_tourn_matches) or isset($bracket_matches_main))
{
?>

<div class="general general-results players" >
<div class="brackets" id="brackets">

<!-- --------------------------------------------- -->
<?php
if(isset($get_tourn_matches)){
$this->load->view('view_se_draws');
}
else if(isset($get_rr_tourn_matches)){
$this->load->view('view_rr_draws');
}
?>
</div>
</div>
</div><!--Close Login-->

<?php
}
?>

</div> 
</section>