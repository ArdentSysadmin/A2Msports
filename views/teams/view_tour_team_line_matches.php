<div class="fromtitle">Team Players Line matches</div>
<br />
<div>
<div class="col-md-6">
<select class="form-control" id="brackets_list" onchange="getlines('<?php echo $team_id;?>');">
<option value=''>Select Draw</option>
<?php
foreach($brackets as $key=>$bracket){ 
	if($bracket->BracketID==$bracket_id){?>
	<option selected="selected" value="<?php echo $bracket->BracketID;?>" >
	<?php echo $bracket->Draw_Title;?>
	</option>
	<?php 
	}
	else{?>
	<option value="<?php echo $bracket->BracketID;?>" >
	<?php echo $bracket->Draw_Title;?>
	</option>
	<?php
	}
}
?>
</select>
</div>
<div class="col-md-6">
<select class="form-control" id="teams_list" onchange="getlines(this.value);">
<option value=''>Select Team</option>
<?php
foreach($teams as $key=>$team){ 
  if($team->Team_ID==$team_id){?>
  <option selected="selected" value="<?php echo $team->Team_ID;?>" >
  <?php echo $team->Team_name;?>
  </option>
  <?php 
  }
  else{?>
  <option value="<?php echo $team->Team_ID;?>" >
  <?php echo $team->Team_name;?>
  </option>
  <?php
  }
}
?>
</select>
</div>
</div>
<div style="clear:both;"></div>
<br />
<div class="tab-content" id="team_players" style=" margin: auto;overflow-y: scroll;overflow-x: scroll;height:auto;width: auto;">
<table id='team_table' class="tab-score">
<?php if($rounds_cnt!=0){?>
<tr class="top-scrore-table">
	<td style="padding-left:40px;">Player</td>
	<?php 
   $rounds_arry=array();
  for ($i=1; $i<=$rounds_cnt; $i++) {
    $rounds_arry[]=$i;
    ?>
		<td style="padding-left:20px;">Match <?php echo $i;?></td>
	<?php }
  ?>
	
</tr>
<?php 

foreach ($lines as $player => $line) {
	$captain_ico="";
	$user = league::get_username($player);
	 if($player==$team_captain){
	   $captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
    }?>
    <tr>
    <td style="padding-left:20px;">
	<a href='<?=base_url();?>player/<?=$user['Users_ID'];?>' target='_blank'><?php echo $user['Firstname'].' '.$user['Lastname']."&nbsp;".$captain_ico; ?></a>
    </td>
    
<?php 
foreach ($line as $round_num => $ln) {
  ?>
      <td style="padding-left:20px; font-weight:normal" align='center'>
<?php 
     //echo "<pre>";print_r($round_num);
      if(count($ln)>0){
      	$ln_mtch=array();
        foreach ($ln as $key => $l) {
        	if($ln[$key]->Match_Type=='Singles'){
              $ln[$key]->Match_Type="S";
        	}else if($ln[$key]->Match_Type=='Doubles'){
              $ln[$key]->Match_Type="D";
        	}
          $ln_mtch[$key]=$ln[$key]->Match_Type.$ln[$key]->Line_num;
        }
        echo implode($ln_mtch, ',');

      }else{
        echo "-";
      }
    ?>
    </td>
   <?php 
   } }?>

  </tr>
<?php }else{
  echo '<tr><td colspan="'.$rounds_cnt.'">No Records Found</td></tr>';
}?>
</table>
</div>