<?php
$ver_slides = array(
0 => '<a href="https://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/default.asp?cid=glues%26brand=Revolution%203"><img src="https://www.megaspin.net/images/adverts/rev3-200x600.png" alt="REvolution 3 Products"  border="0"></a>',
1 => '<a href="https://www.megaspin.net/store/redirect.asp?aid=a2msports&url=/store/saleitems.asp"><img src="https://www.megaspin.net/images/adverts/sale-50pct-off-150x400.gif" border="0"></a>'
);
?>
<script>
$(document).ready(function(){

$("#img-winner").click(function(){
$("#academy_pom").show();
$("#pom_div").hide();

});

$("#pom_cancel").click(function(){
$("#academy_pom").hide();
$("#pom_div").show();
});

});
</script>

<script>
$(document).ready(function(){

var baseurl	= "<?=base_url();?>";

$('#txt_ac_pom').autocomplete({
source: function( request, response ) {
$.ajax({
url: baseurl+'search/users',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'users',
row_num : 1
},
success: function( data ) {
response( $.map( data, function( item ) {
var code = item.split("|");
return {
label: code[0],
value: code[0],
data : item
}
}));
}
});
},
autoFocus: true,	      	
minLength: 1,
select: function( event, ui ) {
var names = ui.item.data.split("|");						
$('#txt_ac_pom_id').val(names[1]);
}		      	
});


});
</script>
<script>
$(document).ready(function(){

var baseurl = "<?=base_url();?>";
$('#pom_add').click(function (e) {

var user = $('#txt_ac_pom_id').val();
$.ajax({
type: 'POST',
url: baseurl+'admin/update_pom',
data: $('#frm_academy_pom').serialize(),
success: function () {
location.reload();
}
});
e.preventDefault();

});
});
</script>


<!--Right Column-->

<div class="col-md-3 right-column">
<div class='clear-both'></div>
<br /><br /><br />
<!-- -------------Player of month start section------------------------------------ -->
<div class="atp-single-player">
<label>PLAYER OF THE MONTH</label>
<div class="top-score-title">
<br />
<?php 
$get_pom = $this->general->get_pom();

$org_pom  = $get_pom['POM'];

$get_user = $this->general->get_user($org_pom);
?>
<div id='pom_div'>
<?php if($org_pom) {?> 
<a href="<?=base_url();?>player/<?php echo $org_pom;?>"><?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></a>
<?php } else { echo "No Player is declared yet!"; } ?>
<?php if(strtoupper($this->session->userdata('role')) == 'ADMIN'){?>

<img src='<?=base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' 
width='30px' height='30px' style='cursor:pointer' />
<?php } ?>
</div>

<form id='frm_academy_pom' name='frm_academy_pom' method="post" enctype="multipart/form-data" role='form'>
<div id="academy_pom" style="display:none">
<input type="text"  class='form-control' name="txt_ac_pom" id="txt_ac_pom" value=""  />
<input type="hidden" class='form-control' name="txt_ac_pom_id" id="txt_ac_pom_id" value=""  />
<input type="button" id='pom_add' value=" Add " style="margin-top:10px" class="league-form-submit1" />
<input type="button" value="Cancel" id="pom_cancel" style="margin-top:10px" class="league-form-submit1" />
</div>
</form>
</div>
</div>
<!-- -------------Player of month end section------------------------------------ -->

<!-- Donate  -->
<div style="text-align: center;padding-top: 37px;">
<a href='<?=base_url();?>donate'><img src="<?=base_url();?>images/donate-now.png" /></a>
</div>
<!-- Donate  -->

<!-- Google AdSense -->
<!-- <div id="google" align='center'> 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> -->

<!-- Ad_Vertical -->

<!-- <ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-9772177305981687"
data-ad-slot="3271945304"
data-ad-format="auto"
data-full-width-responsive="true"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div> --> 
<!-- Google AdSense -->

<div class="top-score-title col-md-12 right-title hidden-xs">
<h3> <a href="<?=base_url();?>news">Latest News</a>

<?php 
//$admin_users= array(214,215);
$admin = $this->session->userdata('role');
//$user_id = $this->session->userdata('users_id');?>
<?php if(strtoupper($admin)=='ADMIN'){ ?>
-  <a href="<?=base_url();?>news/add">ADD</a>
<?php }?>
</h3>

<?php foreach($results as $row ){ ?>
<div class="right-content">
<p class="news-title-right">
<a href=<?=base_url() ."news/" . $row->News_id;?>>
<?php 
$s	 = substr($row->News_title, 0, 25);
$res = substr($s, 0, strrpos($s, ' '));
echo $res . "...";
?>
</a></p>
<p class="txt-right">
<?php
$abc	= strip_tags($row->News_content);
$result = substr($abc, 0, strpos($abc, '.'));
echo $result . "...";
?>
</p>

<a href=<?=base_url() ."news/" . $row->News_id;?> class="ca-more"><i class="fa fa-angle-double-right"></i>More...</a>

<?php 
$user_id = $this->session->userdata('admin');?>
<?php if(strtoupper($admin)=='ADMIN'){ ?>
<p style="float:right"><a href=<?=base_url()."news/edit/" . $row->News_id ;?>><u>Edit</u></a>&nbsp;&nbsp;</p>

<?php }?>
</div>
<?php } ?>
</div>
<div class="top-score-title col-md-12 hidden-xs right-title">
<?php $rand_val = rand(0,1); echo $ver_slides[$rand_val]; ?>
</div>

<!-- Photo section begin------------------------------------ 	-->
<!--<div class="top-score-title col-md-12 hidden-xs right-title">
<h3>Photos</h3> 
<ul class="right-last-photo">
<?php
$get_tour_images = $this->general->get_tour_images();
$a = 1;
foreach($get_tour_images as $i => $get_info)
{
$get_image		= $this->general->get_images($get_info->mt);
$get_tour_sport = $this->general->get_images($get_info->mt);
$tour_id		= $get_image['Tournament_id'];

if($a <= 9){
?>
<li>
<div class="jm-item second">
<div class="jm-item-wrapper">
<div class="jm-item-image">
<?php 
$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
$image_loc = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_image['Image_file'];
if(file_exists($image_loc)){
?>
<a href="<?=base_url()."league/".$tour_id; ?>">
<img src="<?php echo $image_pic; ?>" width = "83px" height = "62.25px" alt="" />
</a>
<?php } else { 
$get_tour_sport = $this->general->get_tour_sport($tour_id);
$tour_pic = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$get_tour_sport['TournamentImage'];
if(file_exists($tour_pic) and $get_tour_sport['TournamentImage'] != ""){
?>
<a href="<?=base_url()."league/".$tour_id; ?>">
<img src="<?php echo $tour_pic; ?>" width = "83px" height = "62.25px" alt="" />
</a>
<?php
}
else
{
switch($get_tour_sport['SportsType']) {
case 1:
$tour_def_pic = "default_tennis.jpg";
break;
case 2:
$tour_def_pic = "default_table_tennis.jpg";
break;
case 3:
$tour_def_pic = "default_badminton.jpg";
break;
case 4:
$tour_def_pic = "default_golf.jpg";
break;
case 5:
$tour_def_pic = "default_racquet_ball.jpg";
break;
case 6:
$tour_def_pic = "default_squash.jpg";
break;
case 7:
$tour_def_pic = "default_pickleball.jpg";
break;
case 8:
$tour_def_pic = "default_chess.jpg";
break;
case 9:
$tour_def_pic = "default_carroms.jpg";
break;
case 10:
$tour_def_pic = "default_volleyball.jpg";
break;
case 11:
$tour_def_pic = "default_fencing.jpg";
break;
case 12:
$tour_def_pic = "default_bowling.jpg";
break;
default:
$tour_def_pic = "";
}

?>
<a href="<?=base_url()."league/".$tour_id; ?>">
<img src="<?=$_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_def_pic; ?>" width = "83px" height =5px" alt="" />
</a>
<?php
}
} ?>
</div>	
</div>
</div>
</li>
<?php
}
$a++;
}
?>
</ul>
</div>
</div> -->

</section>


<!-- -----------view_home,view_news_edit,footer,view_right_column----------------------------------------------- -->