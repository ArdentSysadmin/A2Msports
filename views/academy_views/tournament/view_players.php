<?php
if($this->logged_user_role == 'Admin' or $this->is_super_admin){
?>
<script>
var is_league_adm = 1;
</script>
<?php
}
else{
?>
<script>
var is_league_adm = 0;
</script>
<?php
}
?>
<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";

$(document).ready(function(){

//$('.edit_a2m').click(function(){
$(document).on('click', '.edit_a2m', function(){
	var uid = $(this).attr('id');
	$('#edit_sec_'+uid).show();
	$('#a2m_dis_'+uid).hide();
	$('#'+uid).hide();
});

//$('.cancel_a2m').click(function(){
$(document).on('click', '.cancel_a2m', function(){
	var id = $(this).attr('id');
	var x  = id.split('_');
	var uid = x[1];

	$('#edit_sec_'+uid).hide();
	$('#a2m_dis_'+uid).show();
	$('#'+uid).show();
});

//$('.upd_a2m_btn').click(function(){
$(document).on('click', '.upd_a2m_btn', function(){

	var id   = $(this).attr('id');
	var x    = id.split('_');
	var uid  = x[1];
	var tid  = $('#tourn_id').val();
	//var uval   = $('#txt_'+uid).val();
	//var mx_a2m = $('#temp_a2m').val();

	var sl_val		= $('#sl_txt_'+uid).val();
	var db_val		= $('#db_txt_'+uid).val();
	var mx_val		= $('#mx_txt_'+uid).val();

	//if(mx_a2m > uval || mx_a2m == 0){
	if(sl_val > 0 && db_val > 0 && mx_val > 0){
		$.ajax({
		  type: 'POST',
		  url: club_baseurl+'league/edit_user_a2m',
		  data:{user:uid,tourn_id:tid,sl_val:sl_val,db_val:db_val,mx_val:mx_val},
		  success: function(res) {
			  if ($.isNumeric(res)) {
			  $('#a2m_dis_'+uid).html(res);
			  }
			  else {
			  alert(res);
			  }
			  $('#edit_sec_'+uid).hide();
			  $('#a2m_dis_'+uid).show();
		  }
		});
	}
	else{
		//alert("Score shouldn't exceed "+(mx_a2m-1));
		alert("Invalid Scores!");
	}
});

 $('#frm_participants').click(function() {
  var atLeastOneIsChecked = false;
  $('input:checkbox').each(function() {
    if ($(this).is(':checked')) {
      atLeastOneIsChecked = true;
      // Stop .each from processing any more items
      return false;
    }
  });
  if(atLeastOneIsChecked == false){
		alert('Select atlease one player to proceed!');
		e.preventDefault();
		return false;
  }
  // Do something with atLeastOneIsChecked
});
$(".change_level").click(function(){
 var tid=$(this).attr("id");
 var tidarr=tid.split('_');
 var player=tidarr['2'];
  $("#withdrawplayer_"+player).hide();
 //alert(player);
 var tourn_id=tidarr['3'];
    $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevels',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //console.log(res);die();
       $("#partcipantlevels_"+player).show();
       $("#partcipant_levels_"+player).html(res);
      }
      });
});

$("#game_day").change(function(){
 var ocr_id = $(this).val();
 var tourn_id=$('#tourn_id').val();
 		$("#dyn_player_section").html("<h4>Loading, Please wait....</h4>");

    $.ajax({
      type: 'POST',
      url: club_baseurl+'league/get_ocr_players',
      data:{ocr_id:ocr_id,tourn_id:tourn_id},
      success: function(res) {
		$("#dyn_player_section").html(res);
		//$('#tourn_players').dataTable();
		if(is_league_adm){
		$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [ null,null,null,null,null,null,null,null,null,null ], language: {"search":"", "searchPlaceholder":"Search"} });
		}
		else{
		$('#tourn_players').dataTable({dom: "<'row'<'col-sm-3'l><'col-sm-5'p><'col-sm-4'f>>" + "<'row'<'col-sm-12'tr>>", searching: true, paging: false, lengthMenu: false, aoColumns: [null,null,null,null,null,null,null], language: {"search":"", "searchPlaceholder":"Search"} });
		}

  $('.dataTables_filter input[type="search"]').css(
     {'width':'155px','display':'inline-block', 'margin-left':'80px'}
  );

      }
      });
});


$(".withdraw_player").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['2'];
  $("#partcipantlevels_"+player).hide();
  var tourn_id=tidarr['3'];
  $.ajax({
      type: 'POST',
      url: baseurl+'league/GetUserLevelsExist',
      data:{player:player,tourn_id:tourn_id},
      success: function(res) {
        //alert(res);
        $("#withdrawplayer_"+player).show();
        $("#existing_events_"+player).html(res);
      }
      });
});

$(".cancel").click(function(){
  var tid=$(this).attr("id");
  var tidarr=tid.split('_');
  var player=tidarr['1'];
  $("#withdrawplayer_"+player).hide();
});


$(".sub-proceed").click(function(){
  $(this).val("Please wait...");
});

	//$('input[type="checkbox"]').click(function() {
	$(document).on('click', '.players_check', function() {
		if($(this).prop("checked") == true)
		  var checkin = 1;
		else
		  var checkin = 0;

			var userID = $(this).val();

			$.ajax({
				type: 'POST',
				url: baseurl+'league/update_checkIn',
				data:{player:userID,tourn_id:tourn_id,checkin:checkin},
				success: function(res) {
				}
			});
	});

});

</script>

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
function showCheckboxes($uid){
var elements = document.getElementsByClassName('div_ag_sel')

for (var i = 0; i < elements.length; i++){
elements[i].style.display = "none";
}
var checkboxes = document.getElementById("checkboxes"+$uid);
checkboxes.style.display = "block";
}
</script>

<div class="col-md-12 league-form-bg" style="margin-top:15px; margin-bottom:0px;">
<div class="tab-content table-responsive">
<?php
//$tourn_reg_names = league::get_reg_tourn_player_names($tour_details->tournament_ID);
$parent_class = $this->router->class;
$tourn_reg_names = $parent_class::get_reg_players($tour_details->tournament_ID, $tour_details->SportsType); 
if($tour_details->Is_League == 1){
?>


<select name='game_day' id='game_day' class='form-control' style="width:35%;">
<option value=''>Game Day (All)</option>
<?php
	if($tour_details->Is_League == 1){
	$ev_occrs = league::get_league_occr($tour_details->tournament_ID);
		foreach($ev_occrs as $occr){
		?>
		<option value='<?php echo $occr->OCR_ID;?>'>
			<?php echo date('M d, Y H:i', strtotime($occr->Game_Date)); ?>
		</option>
		<?php
		}
	}
?>
</select>
<?php
}
?>
<!-- players section -->
<div id='dyn_player_section'>
<?php
$data2['tour_details'] = $tour_details;
$data2['tourn_reg_names'] = $tourn_reg_names;
//$data2['reg_events'] = $reg_events;
$data2['parent_class'] = $parent_class;
$data2['is_league'] = $tour_details->Is_League;

echo $this->load->view('academy_views/tournament/view_players_section', $data2);
?>
</div>
<!-- players section -->
</div>  





</div>
<input type='hidden' name='tourn_id' id="tourn_id" value="<?php echo $tour_details->tournament_ID; ?>">
<input type='hidden' name='tourn_type' value = "<?php echo $tour_details->Tournament_type; ?>">
<!-- <input type='hidden' name='temp_a2m' id="temp_a2m" value="<?//=$max_a2m;?>" /> -->
<input type='hidden' name='temp_a2m' id="temp_a2m" value="99999" />

<!-- </div>--><!-- </form> -->