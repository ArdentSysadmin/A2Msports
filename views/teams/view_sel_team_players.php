<style>
.multiselect {
width: 200px;
}
.selectBox {
position: relative;
}
.selectBox select {
width: 100%;
font-weight: bold;
}
.overSelect {
position: absolute;
left: 0; right: 0; top: 0; bottom: 0;
}

#checkboxes {
display: none;
border: 1px #dadada solid;
}
#checkboxes label {
display: block;
}
/*#checkboxes label:hover {
background-color: #1e90ff;
}*/
</style>

<script>
$(document).ready(function(){ 
$("#sel_all").change(function(){
$(".checkbox1").prop('checked', $(this).prop("checked"));
});
});
</script>

<table class="tab-score1">
<tr class="top-scrore-table1">
<td width="6%" class="score-position1" align='center'><input type='checkbox' name="sel_all" id="sel_all" checked /></td>
<td width="20%" style="padding-left:10px"><b>Player</b></td>
<td width="15%" style="padding-left:10px"><b>Contact#</b></td>
</tr>

<?php
/*echo "<pre>";
print_r($team_players);
exit;*/
if(count($team_players) > 0){
foreach($team_players as $player => $avail){
?>
<tr>
<td align ='center'>
<?php
if(!$avail){
?>
<input type="checkbox" name="sel_team_player[]" class="checkbox1" value="<?php echo $player;?>" checked />
<?php
}
else{?>
<img src="<?=base_url();?>/icons/info_ico.png" title="Player is already part of another team for this Tournament" width='16px' height='16px' />
<?php
} ?>
</td>

<td style="padding-left:10px">
<?php
$user = teams::get_username($player);
echo "<b><a href='".base_url()."player/".$user['Users_ID']."' target='_blank'>" . $user['Firstname'] . " " . $user['Lastname'] . "</a></b>";
?>
</td>

<td style="padding-left:10px">
<?php
if($user['Mobilephone']){
$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $user['Mobilephone']);
echo $phone;
}
?></td>
</tr>
<?php 
}
}
else{
?>
<tr><td colspan='3'>No Players found in your team!</td></tr>
<?php
}
?>
</table>
<br />