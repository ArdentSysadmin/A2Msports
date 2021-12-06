<script>
 $(document).ready(function () {
    $(".page").change(function () { 
		var rid = $(this).attr('name');
        if (this.value == "1") { 
            $('#rotate_degree'+rid).show(); 
        } else {
            $('#rotate_degree'+rid).hide();
        }
    });
});
</script>

<script language="javascript" type="text/javascript">
/*function refresh_blog(tid){


var baseurl = "<?php echo base_url();?>";
var tid = "<?php echo $ev_det['Ev_ID']; ?>";

$.ajax({
type: 'POST',
url:baseurl+'events/get_gallery/',
data:{ ev_id:tid},
cache: false,
success: function(html){ 
$('div[id^=div]').hide();
$('#div5').show();
$('#blog_container').html(html);

}           
});
}*/

</script>






<!-- -----------------------------------------------view gallery link section ---------------------------  -->   



<div id="blog_container">
<div class="fromtitle" style="padding-left:40px;">Event - Photo Gallery</div>

<?php 

if(count($get_images) > 0 )
{
foreach($get_images as $i => $row) { ?>

<form method="post" action="<?php echo base_url();?>events/rotate_image">

<div class="col-md-3" style="margin-top:30px;">

<img class="img-responsive" src="<?php echo base_url(); ?>events_pictures/<?php //echo $row->Ev_id; ?>/<?php if($row->Image_file!=""){echo $row->Image_file; }
else { echo "";} ?>" alt="" height="205px" width="205px" />

<input type="hidden" value="<?php echo base_url();?>events_pictures/<?php //echo $row->Ev_id;?>/<?php echo $row->Image_file;?>" name="filename<?=$i;?>" id="">

<br />
<label for="">Rotate image ?</label>
<input name="<?=$i;?>" class="page" type="radio" value="1" > Yes  <input name="<?=$i;?>" class="page" type="radio" value="0" checked> No 

<div id="rotate_degree<?=$i;?>" style="display:none">
<input type="radio" id="angle" name="angle<?=$i;?>" value="90" /> 90
<input type="radio" id="angle" name="angle<?=$i;?>" value="180" /> 180
<input type="radio" id="angle" name="angle<?=$i;?>" value="270" /> 270
<input type="radio" id="angle" name="angle<?=$i;?>" value="360" /> 360
<br />
<input type="radio" id="" name="dir<?=$i;?>" value="-" checked /> Clock-Wise
<input type="radio" id="" name="dir<?=$i;?>" value="+" /> AntiClock

<input type='hidden' name='ev_id<?=$i;?>' value="<?php echo $row->Ev_id; ?>">

<input type="submit" id="rotate" name="rotate<?=$i;?>" value="rotate" class="league-form-submit1">
</div>

</div>
</form>
<?php } 
}
else {
echo "<b>No Images are uploaded yet.</b>";
}
?> 
</div>


<!-- -----------------------------------------------view gallery link section ---------------------------  -->   
