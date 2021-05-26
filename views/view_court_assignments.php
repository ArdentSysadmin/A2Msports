<script>
$('#btn_court_assgn_refresh').click(function() {
var tourn_id = $("#tourn_id").val();

	$.ajax({
	type:'POST',
	url:baseurl+'league/getCourtInfo',
	data:{tourn_id:tourn_id},
	success:function(res) {
		//$('#'+$tourn_id).val('Show Draw');
		$("#tbl_court_grid").html('&nbsp;<h4><b>Loading....</b></h4>');
		
		setTimeout(function() { $("#showdraw").html(res);	}, 600);
	}
	});
});


</script>
<script language="javascript" type="text/javascript">
function myWin(tid)
{
var path = "<?php echo base_url(); ?>";
var tid = '<?php echo $tourn_id; ?>';
window.open(path+'league/courts_print/'+tid,null,"height=1200,width=1400,status=yes,toolbar=no,menubar=no,location=no");
}
</script>
<?php
//echo "<pre>";
//print_r($matches->result());
$color_arr = array('8cf29b','b9f326','b38cf5','fef676','f3b06b','e6d2ce','e86eb1','48c2ed','44b86d','fee998','abd318','189bbd','f3b06b','e6d2ce','d9b3bf','88aa8e','e1d6f6','855dfc');

$res = $matches->result();
$c = 0;
$uniq_draws = array();
foreach($res as $i => $match){
	$timestamp = strtotime($match->Match_DueDate);
	$courts_arr[$timestamp][$match->Court_Info][] = array('draw_title' => $match->Draw_Title, 'match_num' => $match->Match_Num);
	
	if(!in_array($match->Court_Info, $court_titles))
		$court_titles[] = $match->Court_Info;
	if(!array_key_exists($match->Draw_Title, $uniq_draws)){
		//$uniq_draws[$match->Draw_Title] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
		//echo $color_arr[$c]."<br>";
		//echo $c."<br>";
		$uniq_draws[$match->Draw_Title] = "#".$color_arr[$c];
		$c++;
	}		
}
//echo "<pre>";
//print_r($res);
//print_r($courts_arr);
?>
<br />
<br />

<div style="text-align:right;">
<input type="button" name="btn_court_assgn_refresh" id="btn_court_assgn_refresh" class="league-form-submit1" value=" Refresh " style="margin:2px;" />
&nbsp;&nbsp;
<input type="button" name="btn_court_assgn_print" id="btn_court_assgn_print" class="league-form-submit1" value=" Print " style="margin:2px;" onclick="myWin(<?=$bracket_id;?>)" />
</div>
<table id='tbl_court_grid' class="table table-bordered" style='font-size:14px;'>
<tr>
<th scope="col">&nbsp;</th>
<?php
foreach($court_titles as $court){
?>
<th scope="col"><?=$court;?></th>
<?php
}
?>
</tr>

<tr>
<?php
$temp_time = '';
foreach($courts_arr as $time => $info){
$ev_date = date('Md,Y', $time);
?>
<th scope="row" style="text-align:right;">
<?php if($temp_time != $ev_date) { echo date('Md,Y', $time);} echo "<br>".date('h:i A', $time);?>
</th>
<?php
$temp_time = $ev_date;
foreach($court_titles as $court){
?>
<td style="background-color:<?php echo $uniq_draws[$info[$court][0]['draw_title']]; ?>">
<?php
if($info[$court]){
	foreach($info[$court] as $i => $data){
		if($i == 0)
			echo $data['draw_title']." - <b>Match ".$data['match_num']."</b><br>";
		else
			echo "<font color='red'>".$data['draw_title']." - <b>Match ".$data['match_num']."</b></font><br>";
	}
}
//print_r($info[$court]);
?></td>
<?php
}
?>
</tr>
<?php
}
?>
</table>