<style type="text/css">
.tab-score{
	width:100% !important;
}
.pagination {
    margin: 2px 0;
}
.pagepad {
	padding-left: 0px;
	padding-right: 0px;
	padding-top: 8px;
}
.tab-score td:last-child {
    font-weight: 400;
}
.tab-content {
    padding: 0;
    border-radius: 1px;
    background: #fff!important; 
}

.tab-content .tab-score thead .sorting_asc {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_asc.png");
}
.tab-content .tab-score thead .sorting {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_both.png");
}
.tab-content .tab-score thead .sorting_desc {
    background-image: url("<?php echo base_url(); ?>js/DataTables-1.10.16/images/sort_desc.png");
}
.tab-content .tab-score thead .sorting, .tab-content .tab-score thead .sorting_asc, .tab-content .tab-score thead .sorting_desc, .tab-content .tab-score thead .sorting_asc_disabled, .tab-content .tab-score thead .sorting_desc_disabled {
    cursor: pointer;
    background-repeat: no-repeat;
    background-position: center right;
}
#register-submit input[type=button] {
    border: 1px solid #e78315;
    background-color: #f59123;
    padding: 5px 25px;
    font-size: 13px;
    text-transform: uppercase;
    color: #fff;
    margin-bottom: 13px;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease-in-out;
    -o-transition: all .5s ease-in-out;
    -ms-transition: all .5s ease-in-out;
    transition: all .5s ease-in-out;
    cursor: pointer;
}
.checked {
    color: orange !important;
}
.accordion i {
    font-size: 12px;
    margin-right: 0px;
    margin-left: 0px;
}
@media only screen and (max-width: 700px) {
.acc-content .col-md-3 {
    width: 100%;
}
.accordion i {
    font-size: 7px;
    margin-right: 0px;
    margin-left: 0px;
}
}


.rating {
    float:left;
    width:264px;
}
.rating span { 
  float:right; position:relative; 
}
.rating span input {
    position:absolute;
    top:0px;
    left:0px;
    opacity:0;
}
.rating span label {
      display: inline-block;
      overflow: hidden;
      text-indent: 9999px;
      width: 1em;
      white-space: nowrap;
      cursor: pointer;
      font-size: 22px;
}
.rating span label:before{
    display: inline-block;
        text-indent: -9999px;
        content: '\2606';
       
}
.rating span:hover ~ span label,
.rating span:hover label,
.rating span.checked label,
.rating span.checked ~ span label {
       content: '\2605';
       color: #ff8a00;
       text-shadow: 0 0 1px #ff8a00;
}

.checked {
    color: orange !important;
    
}
.accpad{
  margin-right: 0px !important;
    margin-left: 0px !important;
}
.ratingsimg img {
  width:auto !important;
}
.rating-head {
  margin-bottom:10px; color:#81a32b; font-size:16px
}
.rating-head {
  margin-bottom:10px; color:#81a32b; font-size:16px
}
@media only screen and (max-width: 450px) {
.rating-head {
  font-size:13px
}
@media only screen and (max-width: 380px) {
.rating-head {
  font-size:11px
}

}
</style>

<style>
.container2 .header {
	#background-color:#d3d3d3;
	padding: 2px;
	cursor: pointer;
	#font-weight: bold;
}
.container2 .content {
	display: none;
	padding : 5px;
}
</style>


<script>
/* ------------------------- Collapse and Expand in Participants ---------------------- */
$("#teams_ajax_div .header").on('click', function() {
//	alert('test');
    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            //return $content.is(":visible") ? 'Text1' : 'Text2';
        });
    });
});
/* ------------------------- Collapse and Expand in Participants ---------------------- */
 </script>

<!-- script for teams Starts Here-->
<script>
//$('#teams_table').DataTable();

	var sport = "<?php echo $sport; ?>";
	$(document).ready(function(){
	 	$('#team_country').on('change',function(){
			//alert($(this).val());
			  var selected_country = $(this).val();
			  $.ajax({
				type:'POST',
				url:baseurl+'league/get_TeamsByCountry/',
				data:'country='+selected_country+'&sport='+sport,
				success:function(res){
					$('#teams_ajax_div').html(res);
		  		}
			});
		});
	});

	$(document).ready(function(){
		$('#country1').on('change',function(){
 			var country = $(this).val();

			$.ajax({
				type:'POST',
				url:baseurl+'league/get_TeamsByCountry1/',
				data:'country='+country+ '&sport='+sport,
				success:function(res){
		  		//$('#t_table').html(res);
		  		$('#teams_rankings_ajax_div').html(res);
		  		}
			});
		});
 	});
</script>
<!-- script for teams Ends Here -->

 
<script>
$(document).ready(function(){
	$(".rate").hide(); 
	$(".rating-head").hide();
});
 
/* ******************************** Ajax Call For Fetching Club Ratings. ********************************** */
$(document).ready(function(){
   	$(".abc").click(function(){
	  	var id = $(this).attr('id');
		var id1 = id.split('_');

 		$.ajax({
			type:'POST',
			url:baseurl+'league/getClubRatings/',
			datatype:'json',
			data:'clubid='+id1[1]+ '&sport='+<?=$sport;?>,
			success:function(res){
			$("#clubRatingsDiv").html(res),	
			$(".rate").show(); 
			$(".rating-head").show();
			$("#club_id").val(id1[1]);
			}
		});
 	});
});
</script>

 
<script>
$(function(){
	$(".rate").click(function(){
	  $(this).hide();
	  $("#clubRatingsDiv").show();
	});

	$('.rating input').click(function () {
			$('.rating span').removeClass('checked');
			$(this).parent().addClass('checked');
	});

	$(".rate_to_club_cancel").click(function(){
	  $('.rating input:radio').attr("checked", false);
	  $('.rating span').removeClass('checked');
	  $("#clubRatingsDiv").hide();
	  $(".rate").show();

	});

	$(".rate_to_club_edit_cancel").click(function(){
	  $("#clubRatingsDiv").hide();
	  $(".rate").show();
	});
});

/*	$("#club"+$row->Aca_ID).click(function(){

		var country = this.value;
	 	$.ajax({
	         		type:'POST',
	         		url:baseurl+'league/GetStates/',
	         		data:'country='+country,
	         		success:function(res){
	         			$("#states_div").html(res);
	         		}
	         	}); 



	});*/
</script>

<script language = "javascript" type = "text/javascript">
$(function () {

/*	
 $('input:radio').change(
      function(){
        var userRating = this.value;
         var coach_id = $(".rating").find("input[type='hidden']").val();
         $.ajax({
	         		type:'POST',
	         		url:baseurl+'league/AddRating/',
	         		data:'coach_id='+coach_id+'&ratings='+userRating,
	         		success:function(res){
	         			window.location.reload();
	         			//alert(res);die();
	         			//$("#coachstates_div").html(res);
	         		}
	         	}); 
    }); */


});
function print(sport,name,country,state,gender)
{
	//alert($("#age_group_post").val());
  var postdata = [];
  var age_group = "";
  if($("#age_group_post").val() != 'false'){
  var age_group = $("#age_group_post").val();
  }
  postdata.push({sport:sport,name:name,age_group:age_group,country:country,state:state,gender:gender}); 
  postdata = JSON.stringify(postdata);
	var path = "<?php echo base_url(); ?>";
	window.open(path+'league/players_rankings_print?params='+postdata, null, "height=1200, width=1400, status=yes, toolbar=no, menubar=no, location=no");
}
</script>
<script>

$(function () {
$('#clear-form').on('click', function() { 
        $('#addClubs').find('input:text, input:password, select, textarea').val('');
        $("#add_Clubs").hide();
        $("#add_club").show();
        
});
$('#country').on('change', function() {

	var country = this.value;
	 	$.ajax({
	         		type:'POST',
	         		url:baseurl+'league/GetStates/',
	         		data:'country='+country,
	         		success:function(res){
	         			$("#states_div").html(res);
	         		}
	         	}); 


});
$('#coach_country').on('change', function() {

	var country = this.value;
	 	$.ajax({
	         		type:'POST',
	         		url:baseurl+'league/GetStates/',
	         		data:'coach_country='+country,
	         		success:function(res){
	         			$("#coachstates_div").html(res);
	         		}
	         	}); 


});
$('#club_country').on('change', function() {

	var country = this.value;
	 	$.ajax({
	         		type:'POST',
	         		url:baseurl+'league/GetStates/',
	         		data:'club_country='+country,
	         		success:function(res){
	         			$("#clubstates_div").html(res);
	         		}
	         	}); 


});
$('#clubcountry').on('change', function() {

	var country = this.value;
	 	$.ajax({
	         		type:'POST',
	         		url:baseurl+'league/GetStates/',
	         		data:'clubcountry='+country,
	         		success:function(res){
	         			$("#addclubstates_div").html(res);
	         		}
	         	}); 


});
$("#add_club").click(function(){
	$(this).hide();
	$("#add_Clubs").show();
});

/*$('#age_group').change(function() {

var agegroup = $("#age_group option:selected").val();
alert(agegroup);
for (agegroup in selectValues) {
if(agegroup != 'Adults'){
	$("#gender").append('<option value="0">Girls</option><option value="1">Boys</option>');
}else{
	$("#gender").append('<option value="0">Women</option><option value="1">Men</option>');
}
}

//$("div").text(str);
});*/


});

var expanded = false;
function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<br />
<?php
$sport_segment = end($this->uri->segment_array()); 
$data['sport_segment'] = $sport_segment;

//$tab = 'Tournaments';
$tab = ucfirst($req_tab);

if($this->input->post('tab')){
	$tab = $this->input->post('tab');
}
?>
<?php
if($sport == '2'){
$horiz_slides = array(
0 => '<a href="http://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/default.asp?pid=ipong-robot"><img 
src="http://www.megaspin.net/images/adverts/ipong_468x060.gif" border="0"></a>',
1 => '<a href="http://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/saleitems.asp"><img 
src="http://www.megaspin.net/images/adverts/sale-50pct-off-468x60.gif" border="0"></a>',
2 => '<a href="http://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/landing/joola-sale.asp"><img 
src="http://www.megaspin.net/images/adverts/joola_us_canada_468x060.gif" border="0"></a>',
3 => '<a href="http://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/"><img 
src="http://www.megaspin.net/images/adverts/table_tennis_store_468x060.gif" border="0"></a>'
);
?>
<div class="col-md-12 tt-sportpage-header-txt" align='center' style="margin-top:10px;">
<?php $rand_val = rand(0,3); echo $horiz_slides[$rand_val]; ?>
</div>
<?php
}
else{
?>
<!-- ad code -->
<?php
}
?>
<div style="clear:both;"></div>
<section id="single_player" class="container secondary-page sportpage-header-txt">

<!-- <div class="top-score-title right-score col-md-9" style="margin-top:220px"> -->
<div class="top-score-title right-score col-md-9" style="margin-top:20px;">

<?php
//if(!$isMobile){
	?>
<!-- Google AdSense -->
<!-- <div id='google' align='center'>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad_Horizontal -->
<!-- <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-9772177305981687"
     data-ad-slot="1273487212"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> -->
<!-- Google AdSense -->
<?php
//}
//var_dump($isMobile);
//exit;
?>


<!-- ---------------------Search Users by Location ------------------------------------- -->
<?php
if($sport != '10' and $sport != '18' and $req_tab == 'rankings'){
?>
<div class="acc-content">
<?php $this->load->view('sports/view_players_rankings', $data); ?>
</div>
<?php
}
else if($req_tab == 'rankings'){
?>
<div class="acc-content">
<?php $this->load->view('sports/view_team_rankings', $data); ?>
</div>
<?php
}
?>

<!-- Teams Tab Starts Here -->
<?php if($req_tab == 'teams'){?>
<div class="acc-content">
<?php $this->load->view('sports/view_teams', $data); ?>
</div>

<?php } ?>
<!-- Teams Tab Ends Here -->

<?php if($req_tab == 'coaches'){?>
<div class="acc-content" id='coaches_content'>
<?php $this->load->view('sports/view_coaches', $data); ?>
</div>
<?php } ?>

<?php if($req_tab == 'clubs'){?>
	<div class="acc-content" id='clubs_content'>
	<?php $this->load->view('sports/view_clubs', $data); ?>
	</div>
<?php } ?>
<?php if($req_tab == 'tournaments'){?>
	<div class="acc-content" id='tournaments_content'>
	<?php $this->load->view('sports/view_tournaments', $data); ?>
	</div>
<?php } ?>

</div>