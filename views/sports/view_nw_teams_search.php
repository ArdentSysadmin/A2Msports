<table class="table table-striped">
<thead>
<tr>
<th scope="col" style="font-weight: bold !important; padding: 20px 30px;">Team Name</th>
<th scope="col" style="font-weight: bold !important; padding: 20px 30px;">(Win - Loss)</th>
<th scope="col" style="font-weight: bold !important; padding: 20px 30px;">City</th>
<th scope="col" style="font-weight: bold !important; padding: 20px 30px;">State</th>
<?php if($this->logged_user){ ?>
<!-- <th scope="col" style="font-weight: bold !important;">Action</th> -->
<?php } ?>
</tr>
</thead>
<tbody>
<?php
if($teams_result){
$k=1;
foreach($teams_result as $key => $unp) {
?>
<tr>
<td class="sp_team_acc">
<div class="accordion-item header names_table align-items-center d-flex">
<?php if($unp->Team_Logo != NULL || $unp->Team_Logo != ""){
$team_logo = "<img style='object:contain;' src='".base_url()."/team_logos/cropped/$unp->Team_Logo' alt=''>";
}
else{ 
$team_logo = "<img style='object:contain;' src='".base_url()."/team_logos/default_team_logo.png' alt=''>";
}
echo $team_logo;
?>
<p class="mb-0 accordion-header" id="panelsStayOpen-heading<?=$unp->Team_ID;?>">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?=$unp->Team_ID;?>" aria-expanded="false" aria-controls="panelsStayOpen-collapse<?=$unp->Team_ID;?>"><?php echo $unp->Team_name."&nbsp;"; ?></button>
</p>
</div>
    <div id="panelsStayOpen-collapse<?=$unp->Team_ID;?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading<?=$unp->Team_ID;?>">
			<div class='accordion-body'><ul>

			<?php $team_players = json_decode($unp->Players);

			foreach($team_players as $tp){
				$player		 = league::get_username($tp);
				if($player['Gender'] == 1){
					$gender = "(M)";
				}
				else if($player['Gender'] == 0){
					$gender = "(F)";
				}

				$captain_ico = '';
				if($uc->Captain == $tp){
					$captain_ico = "<img src='".base_url()."icons/letter_c.png' title='Captain' style='width:15px; height:15px;' />";
				}

				echo "<li style='padding-left:25px;padding-bottom:5px;list-style:none;'>
				<a href='".base_url()."player/".$player['Users_ID']."' target='_blank'>".ucfirst($player['Firstname'])." ".ucfirst($player['Lastname'])."</a> ".$gender."&nbsp;{$captain_ico}</li>";
			}

			echo "</ul></div>";
			?>
			</div>
</td>

<td><p class="mt-3 mb-0">
<?php 
$get_team_stats = league :: get_team_stats($unp->Team_ID);
echo $get_team_stats['wins']." - ".$get_team_stats['loss']; ?>
</td>
<td><p class="mt-3 mb-0">
<?php
if($unp->hcl_city){
echo $unp->hcl_city;
}
else{
echo "< None >";
}
?></p></td>

<td><p class="mt-3 mb-0">
<?php
if($unp->hcl_state){
echo $unp->hcl_state;
}
else{
echo "< None >";
}
?></p></td>

<?php if($this->logged_user){ ?>
<!-- <td><p class="mt-3 mb-0">&nbsp;</p></td> -->
<?php } ?>
</tr>
<?php 
$k++;
}
}
else{
?>                           
<tr><td colspan='4'><p class="mt-3 mb-0">No Results found!</p></td></tr>
<?php
}
?>
</tbody>
</table>