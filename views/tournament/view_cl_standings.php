<script>
var club_baseurl = "<?php echo $club_url; ?>";
</script>

<?php
if($this->is_team_league){
?>
<script>
$('.td_players').click(function(){
var player   = $(this).attr('id');
var tourn_id = $("#tourn_id").val();

$("#player_matches").html("Please wait, loading......");
	$.ajax({
		type:'POST',
		url:baseurl+'league/get_cl_player_team_matches/',
		data:{player:player, tourn_id:tourn_id,club_url:club_baseurl},
		success:function(res){
			$("#player_matches").html(res);

			$('html, body').animate({
			scrollTop: ($('#player_matches').offset().top)
			},500);
		}
	});
});
</script>
<?php
}
else{
?>
<script>
$('.td_players').click(function(){
var player   = $(this).attr('id');
var tourn_id = $("#tourn_id").val();

$("#player_matches").html("Please wait, loading......");
	$.ajax({
		type:'POST',
		url:baseurl+'league/get_cl_player_matches/',
		data:{player:player, tourn_id:tourn_id,club_url:club_baseurl},
		success:function(res){
			$("#player_matches").html(res);

			$('html, body').animate({
			scrollTop: ($('#player_matches').offset().top)
			},500);
		}
	});
});
</script>
<?php
}?>

<div class='col-md-12' align='right'>
<select class='form-control' name='format_filter' id='format_filter' style='width:15%;'>
<option value='all'>All</option>
<option value='Singles' <?php if($format == 'Singles') echo "selected"; ?>>Singles</option>
<option value='Doubles' <?php if($format == 'Doubles') echo "selected"; ?>>Doubles</option>
<option value='Mixed' <?php if($format == 'Mixed') echo "selected"; ?>>Mixed</option>
</select>
</div>
<div style="padding-top:20px;"><b>Tournament/League Standings</b></div>


<!--  -------------------------  -->
<div class="table-responsive">
<table id="standings" cellpadding="0" border="0" class="tab-score">
<thead>
<tr class='top-scrore-table' style="background-color: #f68b1c; color:#fff; font-size:14px; padding:3px">
<th class="text-center">Player</th>
<th class="text-center">Matches<br>Played</th>
<th class="text-center">Matches<br>Won</th>
<th class="text-center">Matches<br>Lost</th>
<th class="text-center">Matches<br>Win%</th>
<th class="text-center">Score<br>For</th>
<th class="text-center">Score<br>Against</th>
<th class="text-center">Score<br>Diff.</th>
<th class="text-center">SD/MP</th>
<th class="text-center">SD/MP<br>+Win%</th>
<?php
//echo "<pre>";
//print_r($tour_det);
if(!$this->is_team_league){
?>
<th class="text-center">Init Rating</th>
<th class="text-center">Final Rating</th>
<th class="text-center">Change</th>
<?php
}
?>
</tr>
</thead>
<?php
if(count($standings) > 0){
	foreach($standings as $player => $values){
?>
<tr>
<td align='center' style='cursor:pointer; color: #03508c;' class='td_players' id='<?=$player;?>'>
<b><?php echo ucfirst($values['fname'])." ".ucfirst($values['lname']); ?></b>
</td>
<td align='center'><?php echo $values['played']; ?></td>
<td align='center'><?php echo $values['won']; ?></td>
<td align='center'><?php echo $values['lost']; ?></td>
<td align='center'><?php $win_per = ($values['won'] / $values['played']) * 100; echo number_format($win_per, 2); ?></td>
<td align='center'><?php echo $values['points_for']; ?></td>
<td align='center'><?php echo $values['points_against']; ?></td>
<td align='center'><?php $diff = ($values['points_for'] - $values['points_against']); echo $diff; ?></td>
<td align='center'><?php $pd = $diff / $values['played']; echo number_format($pd, 2); ?></td>
<td align='center' style="font-weight:400;"><?php $pd_win_per = $pd + $win_per;	  echo number_format($pd_win_per, 2); ?></td>
<?php
if(!$this->is_team_league){
?>
<td align='center' style="font-weight:400;"><?php echo $values['init_a2m']; ?></td>
<td align='center' style="font-weight:400;"><?php echo $values['final_a2m']; ?></td>
<?php
if($tour_det->SportsType != 7){
?>
<td align='center' style="font-weight:400;"><?php echo $values['change']; ?></td>
<?php
}
else{
?>
<td align='center' style="font-weight:400;"><?php echo number_format($values['change'], 3); ?></td>
<?php
}
}
?>
</tr>
<?php
	}
}
else{
?>
<tr>
<td align='right'>No</td>
<td>standings</td>
<td>available</td>
<td>yet!</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
if(!$this->is_team_league){
?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<?php
}
?>
</tr>
<?php
}?>
</table>
</div>
<br />
<div id='player_matches'>
<!-- Dynamic content -->
</div>
<?php
if(!$this->is_team_league){
?>
	<script>
	$(document).ready(function() {
		/*$('#standings').dataTable({"order": [[ 4, "desc" ]], dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
		"<'row'<'col-sm-12'tr>>", searching: false, paging: false, lengthMenu: false, aoColumns: [  null,null,null,null,null,null,null,null,null,null,null,null,null  ], language: {"search":"", "searchPlaceholder":"Search"} });*/
		$('#standings').DataTable({
				searching: false, 
				paging: false, 
				lengthMenu: false,
				//sDom	  : '<"clear">t<"H"p><"F"p>'
				order: [[ 4, "asc" ]]
		});
	});
	</script>
<?php
}
else{
?>
	<script>
	$(document).ready(function() {
		/*$('#standings').dataTable({"order": [[ 4, "desc" ]], dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" +
		"<'row'<'col-sm-12'tr>>", searching: false, paging: false, lengthMenu: false, aoColumns: [  null,null,null,null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });*/
		$('#standings').DataTable({
				searching: false, 
				paging: false, 
				lengthMenu: false,
				//sDom	  : '<"clear">t<"H"p><"F"p>'
				order: [[ 4, "asc" ]]
		});
	});
	</script>
<?php
}
?>