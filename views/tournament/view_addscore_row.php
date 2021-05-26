<td valign="center" style="padding-left:15px;"><b>
<?php if($match_details['P1_Users_ID']){
	echo "<a href='".base_url()."player/".$match_details['P1_Users_ID']."'>".$match_details['P1_Firstname']." ".$match_details['P1_Lastname']."</a>"; 
	if($match_details['P1P_Users_ID']){ echo "; <a href='".base_url()."player/".$match_details['P1P_Users_ID']."'>".$match_details['P1P_Firstname']." ".$match_details['P1P_Lastname']."</a>"; }
	} else { echo "----"; }
	if($match_details['Winner'] == $match_details['Player1'] and $match_details['Winner'] != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	}
?>
</b>
<script>
/*
$('.edit_score').on('click',function(){
	var tab_row_id = $(this).attr('name');

	if($("#escore"+tab_row_id).css('display')=='none'){
	$("#escore"+tab_row_id).show();
	}
	else{
	$("#escore"+tab_row_id).hide();
	}
});

$(".rr_edit_score").click(function(){
	var pid = $(this).attr('name');

	if($("#rr_escore"+pid).css('display')=='none'){
	$("#rr_escore"+pid).show();
	}
	else{
	$("#rr_escore"+pid).hide();
	}
});
*/
</script>
</td>
<td valign="center" style="padding-left:15px;"><b>
<?php if($match_details['P2_Users_ID']){ 
		echo "<a href='".base_url()."player/".$match_details['P2_Users_ID']."'>".$match_details['P2_Firstname']." ".$match_details['P2_Lastname']."</a>"; 
		if($match_details['P2P_Users_ID']){ echo "; <a href='".base_url()."player/".$match_details['P2P_Users_ID']."'>".$match_details['P2P_Firstname']." ".$match_details['P2P_Firstname']."</a>"; }
		} else { echo "----"; }
		if($match_details['Winner'] == $match_details['Player2'] and $match_details['Winner'] != '') {
		echo "<img id='img-winner' src='".base_url()."images/gold_medal_small.png' width='20' height='20'></img>";
	    }
?>
</b></td>

<?php
 if($match_details['Winner'] == ''){
?>
		<td valign="center" style="padding-left:15px;">
		<div>
		<a id="add" class="add_score" href="#reg_matches" name="<?php echo $match_details['Tourn_match_id']; ?>">Add score</a> 
		</div>
		</td>
<?php 
} 
else { ?>
		<td valign="center" style="padding-left:15px;">
	<?php 
		if($match_details['Player1_Score'] !=""){
		$p1=array();$p2=array();
		$p1 = json_decode($match_details['Player1_Score']);
		$p2 = json_decode($match_details['Player2_Score']);

		$cnt = count(array_filter($p1));
		$cnt2 = count(array_filter($p2));

			if($cnt > 0){
					for($i=0; $i<count(array_filter($p1)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
			}
			else if($cnt2 > 0)
			{	
					for($i=0; $i<count(array_filter($p2)); $i++)
					{
						echo "($p1[$i] - $p2[$i]) ";
					}
				
			}
			else if($cnt == 0 and $match_details['Player1_Score'] != "Bye Match" and $match_details['Player2_Score'] != "Bye Match"){
						echo "Win by Forfeit ";
			}

		}

		if(($match_details['Player1_Score'] != "Bye Match" or $match_details['Player2_Score'] != "Bye Match")){
		?>
			<?php echo "\t"; ?><img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' 
			href='#edit_score' name='<?php echo $match_details['Tourn_match_id']; ?>' width='30px' height='30px' style='cursor:pointer' />
			

		<?php } else if($match_details['Player1_Score'] == "Bye Match" or $match_details['Player2_Score'] == "Bye Match"){
		
			echo "Bye Match";
		}
		?>
  
		</td>
	   <?php } ?>