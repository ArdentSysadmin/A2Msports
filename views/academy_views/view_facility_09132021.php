<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";

$(document).ready(function(){
	$('#change_facility').click(function () {
		$('#facility-section').hide();
		$('#edit-facility-section').show();
	});

	$('#facility_cancel').click(function () {
		$('#facility-section').show();
		$('#edit-facility-section').hide();		
	});

	$('#change_lt').click(function () {
		$('#lt-team').hide();
		$('#edit-lt-team').show();
	});

	$('#lt_cancel').click(function () {
		$('#lt-team').show();
		$('#edit-lt-team').hide();
	});


	$('#change_ps').click(function () {
		$('.ps_select_chck_imgs').toggle();
	});
	$('#del-ps-cancel').click(function () {
		$('.ps_select_chck_imgs').toggle();
	});

	$('#change_glr').click(function () {
		$('.select_img').toggle();
	});
	$('#del-glry-cancel').click(function () {
		$('.select_img').toggle();
	});

	$('#add_glr').click(function () {
		$('#facility-glry-add').show();
	});
	$('#add_ps').click(function () {
		$('#add-ps-team').show();
		$('#ps-team').hide();
	});
	$('#ps_cancel').click(function () {
		$('#add-ps-team').hide();
		$('#ps-team').show();
	});

	$('#glry_cancel').click(function () {
		$('#facility-glry-add').hide();
	});

// --- videos js ---
	$('#add_vids').click(function () {
		$('#facility-vids-add').show();
	});
	$('#change_vids').click(function () {
		$('.select_vid').toggle();
	});
	$('#del-vids-cancel').click(function () {
		$('.select_vid').toggle();
	});
	$('#vids_cancel').click(function () {
		$('#facility-vids-add').hide();
	});
// --- videos js ---

	$('#del-glry-imgs').click(function() {
		//var baseurl			= "<?php echo $_SERVER['HTTP_X_FORWARDED_HOST'];?>";
		//var baseurl			= "<?php echo base_url();?>";
		//var baseurl			= "http://www.mytestclub.com/";
		var academy_id  = "<?php echo $org_details['Aca_ID']; ?>";
		var short_code   = "<?php echo $org_details['Aca_URL_ShortCode']; ?>";

		var count = $('.select_chck_imgs'). filter(':checked'). length;

		var sel_imgs = new Array();
        $( "input[name='sel_gallery_imgs[]']:checked" ).each( function() {
                sel_imgs.push( $( this ).val() );
        });

		var all_imgs = $('#pre_glry_imgs').val();

		if(count){
			if(confirm('Are you sure to delete?')){
				$.ajax({
				//url: baseurl+'/'+short_code+'/facility/delete_glry',
				url: club_baseurl+'/facility/delete_glry',
				type: "post",
				data:{sel_images:sel_imgs, all_imgs:all_imgs},
				success: function(res) {
					//$('#response').html(data);
					alert('Images deleted!');
					location.reload();
				}
				});
			}
		}
		else{
			alert('No Image is selected!');
		}
	});

	$('#del-vids-imgs').click(function() {
		//var baseurl			= "<?php echo $_SERVER['HTTP_X_FORWARDED_HOST'];?>";
		//var baseurl			= "<?php echo base_url();?>";
		//var baseurl			= "http://www.mytestclub.com/";
		var academy_id  = "<?php echo $org_details['Aca_ID']; ?>";
		var short_code    = "<?php echo $org_details['Aca_URL_ShortCode']; ?>";

		var count = $('.select_chck_vids'). filter(':checked'). length;

		var sel_vids = new Array();
        $( "input[name='sel_vid_links[]']:checked" ).each( function() {
                sel_vids.push( $( this ).val() );
        });

		var all_vids = $('#prev_vids').val();

		if(count){
			if(confirm('Are you sure to delete?')){
				$.ajax({
				//url: baseurl+'/'+short_code+'/facility/delete_glry',
				url: club_baseurl+'/facility/delete_vids',
				type: "post",
				data:{sel_vids:sel_vids, all_vids:all_vids},
				success: function(res) {
					//$('#response').html(data);
					alert('Selected videos are deleted.');
					location.reload();
				}
				});
			}
		}
		else{
			alert('No video is selected!');
		}
	});


	$('#del-ps-imgs').click(function() {
		var academy_id  = "<?php echo $org_details['Aca_ID']; ?>";
		var short_code   = "<?php echo $org_details['Aca_URL_ShortCode']; ?>";
		var count			  = $('.ps_select_chck_imgs'). filter(':checked'). length;
		var sel_ps_imgs		  = new Array();

        $( "input[name='sel_ps_imgs[]']:checked" ).each( function() {
                sel_ps_imgs.push( $( this ).val() );
        });

		var all_ps = $('#pre_ps_team').val();

		if(count){
			if(confirm('Are you sure to delete?')){
				$.ajax({
				//url: baseurl+'/'+short_code+'/facility/delete_glry',
				url: club_baseurl+'/facility/delete_ps',
				type: "post",
				data:{sel_ps:sel_ps_imgs, all_ps:all_ps},
				success: function(res) {
					//$('#response').html(data);
					alert('Selected Sponsors are deleted!');
					location.reload();
				}
				});
			}
		}
		else{
			alert('No Image is selected!');
		}
	});

});
</script>
<?php 
if($this->session->userdata('users_id') == $org_details['Aca_User_id']) { 
?>
<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
selector: '#facility_desc',
height: 300,
theme: 'modern',
plugins: [
'lists link image charmap hr anchor pagebreak',
'code nonbreaking  contextmenu directionality',
'template paste textcolor colorpicker textpattern imagetools codesample toc'
/*'advlist autolink lists link image charmap print preview hr anchor pagebreak',
'searchreplace wordcount visualblocks visualchars code fullscreen',
'insertdatetime media nonbreaking save table contextmenu directionality',
'template paste textcolor colorpicker textpattern imagetools codesample toc help'*/
],
toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
image_advtab: true,
templates: [
{ title: 'Test template 1', content: 'Test 1' },
{ title: 'Test template 2', content: 'Test 2' }
],
content_css: [
'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
'//www.tinymce.com/css/codepen.min.css'
]
});
</script>
<?php 
}
?>
<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet">

<div class="content-section-facility-about">
  <div class="container-fluid">
    <div class="row" id='facility-section'>
	<!-- edit icon -->
	<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
		<div class="facility-edit-icon">
             <a style="color:#fff; cursor:pointer;" id='change_facility'><i class="fa fa-pencil" aria-hidden="true"></i></a>
        </div>
	<?php } ?>
<!-- edit icon end -->
		<div class="col-md-8">
			<div class="row">
				<img src="<?php echo base_url(); ?>assets/club_facility/<?php echo $org_details['Aca_ID']; ?>/<?php echo $facility_details['Facility_Image']; ?>" 
				alt="" class="img-responsive">
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
			<div class="facility-bg1"><?php echo $facility_details['Facility_Text']; ?></div>
	   </div><!-- row -->
	</div><!-- col-md-5 -->

    </div><!-- row -->
  </div><!-- container-fluid -->
</div>

<div class="row" id='edit-facility-section' style='display:none; margin-top:30px;' align='center' >
	<form name='academy_facility' method='POST' 
	action="<?=$this->config->item('club_form_url');?>/facility/update_facility" enctype='multipart/form-data'>

	<div class='col-md-4'>
	<img src="<?php echo base_url(); ?>assets/club_facility/<?php echo $org_details['Aca_ID']; ?>/<?php echo $facility_details['Facility_Image']; ?>" width='150px' height='100px;' /><br /><br /> <input type='file' name='facility_image' />
	</div>

	<div class='col-md-7'><textarea name="facility_desc" class="txt-area" id="facility_desc">
	<?php echo $facility_details['Facility_Text']; ?></textarea></div>

	<div class='col-md-12' style='margin-top:10px;'>
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='submit' name='facility_submit' id='facility_submit' value='  Update  ' style='margin-right:15px;' />
	<input type='button' name='facility_cancel' id='facility_cancel' value='  Cancel  '  />
	</div>
	</form>
</div>

<?php
if($org_details['Aca_ID'] != 1166){
?>
<section class="blog-wrapper">
  <div class="container">
    <div class="title">
      <h2>Leadership Team</h2>
      <div><span></span></div>
			<!-- edit icon -->
			<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
			<div class="lt-edit-icon">
			<a style="color:#000; cursor:pointer;" id='change_lt'><i class="fa fa-pencil" aria-hidden="true"></i></a>
			</div>
			<?php } ?>
			<!-- edit icon end -->
    </div>
    <div class="team-row justify-content-center" id='lt-team'>

		<?php
			if($facility_details['Facility_Leadership']){
				$lt_team = json_decode($facility_details['Facility_Leadership'], true); 
				
				foreach($lt_team as $i => $team){
					$lt_img = base_url()."assets/club_pages/images/bod1.jpg";

					if($team['img'])
						$lt_img = base_url()."assets/club_facility/".$org_details['Aca_ID']."/lt_team/".$team['img'];

					$lt_name  = $team['name'];
					$lt_role    = $team['role'];
					$lt_desc   = $team['desc'];

					if($team['name']){
		?>
			<div class="col-md-3 col-sm-6 text-center">
			<div class="single-blog" style="min-height: 340px;">
			<div style="margin-top:10px">
			<img src="<?=$lt_img; ?>" alt="" style="width:80%; height:197px;">
			</div>
			<div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;"><?=$lt_name; ?></h3>
			<b><?=$lt_role; ?></b>
			</div>
			<p><?=$lt_desc; ?></p>
			</div>
			</div>
		<?php
					}
				}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">No Leadership team is added yet!</div>
		<?php
				}
		?>

    </div>

		<div class='row' id='edit-lt-team' style='display:none;'>
		<form name='lt_edit_frm' method='POST'	action="<?=$this->config->item('club_form_url');?>/facility/update_lt_team" enctype='multipart/form-data'>

		<?php
			if($facility_details['Facility_Leadership'] and $facility_details['Facility_Leadership'] != 'null'){
				$lt_team = json_decode($facility_details['Facility_Leadership'], true); 
				
				foreach($lt_team as $i => $team){

					if($team['img'])
						$lt_img = base_url()."assets/club_pages/images/bod1.jpg";

					$lt_name  = $team['name'];
					$lt_role    = $team['role'];
					$lt_desc   = $team['desc'];
		?>
			<div class="col-md-3 col-sm-6 text-center">
			<div class="single-blog">
			<div style="margin-top:10px">
			<input type='file' name='lt_imgs[]' />
			<input type='hidden' name='lt_prev_imgs[]' value='<?=$team['img'];?>' />
			</div>
			<div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;"><input type='text' name='lt_name[]' class="form-control" placeholder="Role" value='<?=$lt_name;?>' /></h3>
			<b><input type='text' name='lt_role[]' class="form-control" placeholder="Role" value='<?=$lt_role;?>' /></b>
			</div>
			<p><textarea name='lt_desc[]' cols='25' rows='3' placeholder='Summary'><?=$lt_desc; ?></textarea></p>
			</div>
			</div>
		<?php
				}
			}
			else{
				for($i=1; $i<=4; $i++){
			?>
			<div class="col-md-3 col-sm-6 text-center">
			<div class="single-blog">
			<div style="margin-top:10px"><input type='file' name='lt_imgs[]' /></div>
			<div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">
			<input type='text' name='lt_name[]' class="form-control" placeholder="Member Name" value='' /></h3>
			<b><input type='text' name='lt_role[]' class="form-control" placeholder="Role" value='' /></b>
			</div>
			<p><textarea name='lt_desc[]' cols='25' rows='3' placeholder='Summary'></textarea></p>
			</div>
			</div>
			<?php
				}
			}
			?>
	<div class='col-md-12' style='margin-top:10px;' align='center'>
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='submit' name='lt_submit' id='lt_submit' value='  Update  ' style='margin-right:15px;'/>
	<input type='button' name='lt_cancel' id='lt_cancel' value='  Cancel  '   />
	</div>
	</form>
</div>

  </div>
</section>
<?php
}
?>

<!-- <section class="blog-wrapper" style="background:#fff">

  <div class="container">
    <div class="title">
      <h2>Partners and Sponsors</h2>
      <div><span></span></div>

			<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
			<div class="ps-edit-icon">
			<a style="color:#000; cursor:pointer;" id='change_ps'>
			<i class="fa fa-pencil" aria-hidden="true"></i></a>
		&nbsp;&nbsp;&nbsp;
		<a style="color:#000; cursor:pointer; font-size:20px;" id='add_ps'>
		<i class="fa fa-plus-circle" aria-hidden="true"></i></a>
			</div>
		<div class="col-md-12 col-sm-12 ps_select_chck_imgs" style='display:none;'>
		<input type='button' name='del-ps-imgs' id='del-ps-imgs' value=' Delete ' />
		<input type='button' name='del-ps-cancel' id='del-ps-cancel' value=' Cancel ' />
		</div>
			<?php } ?>

    </div>
    <div class="team-row justify-content-center our-gallery-wrapper" id='ps-team' style="background:#fff; padding:0px;">
	<div id="home-gallery" class="owl-carousel">
		<?php
			if($facility_details['Facility_Partner_Sponsors']){
				$ps_team = json_decode($facility_details['Facility_Partner_Sponsors'], true); 
				//echo "<pre>"; print_r($ps_team);  exit;
				foreach($ps_team as $i => $team){
					$ps_img = base_url()."assets/club_pages/images/bod1.jpg";

					if($team['img'])
						$ps_img = base_url()."assets/club_facility/".$org_details['Aca_ID']."/ps_team/".$team['img'];

					$ps_name  = $team['name'];
					$ps_role    = $team['role'];
					$ps_desc  = false;
					if($team['desc'])
					$ps_desc  = $team['desc'];

					if($team['img']){
		?>
			<div class="item text-center">
			<div class="single-blog" style="border:0px;">
			
			<input type='checkbox' class='ps_select_chck_imgs' style="display:none;" name='sel_ps_imgs[]' value='<?=$i;?>' />
			<div style="margin-top:10px;" align='center'>
			<img src="<?=$ps_img; ?>" alt="" style="width:50%; height:auto; border: 1px;">
			</div>
			<div class="blog-content" style="margin-top:10px">	
			<?php if($ps_name) ?>
				<h3 style="font-size:17px; margin-bottom: 2px;"><?=$ps_name;?></h3>
			<?php if($ps_role) ?>
				<b><?=$ps_role; ?></b>
			</div>
			<?php if($ps_desc) ?>
			<p><?=$ps_desc; ?></p>
			</div>
			</div>
		<?php
					}
				}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">No Partners and Sponsors are added yet!</div>
		<?php
				}
		?>
		</div>
		</div>

<div class='row justify-content-center' id='add-ps-team' style='display:none;'>
<form name='ps_edit_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/facility/update_ps_team" enctype='multipart/form-data'>

<div class="col-md-3 col-sm-6 text-center">
<div class="single-blog">
<div style="margin-top:10px"><input type='file' name='ps_imgs' /></div>
<div class="blog-content" style="margin-top:10px">
<h3 style="font-size: 17px; margin-bottom: 2px;">
<input type='text' name='ps_name' class="form-control" placeholder="Name (Optional)" value='' /></h3>
<b><input type='text' name='ps_role' class="form-control" placeholder="Role (Optional)" value='' /></b>
</div>

</div>
</div>

	<div class='col-md-12' style='margin-top:10px;' align='center'>
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='hidden' name='pre_ps_team' id='pre_ps_team' value='<?php echo $facility_details['Facility_Partner_Sponsors']; ?>' />
	<input type='submit' name='ps_submit' id='ps_submit' value='  Add  ' style='margin-right:15px;'/>
	<input type='button' name='ps_cancel' id='ps_cancel' value='  Cancel  '   />
	</div>
	</form>
</div>


    </div>
  </div>
</section> -->

<section class="blog-wrapper home-about-bg" id="gallery">
<div class="portfolio-page">
  <div class="container">
    <div class="title">
      <h2>Gallery</h2>
      <div><span></span></div>
		<!-- edit icon -->
		<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
		<div class="glr-edit-icon">
		<a style="color:#000; cursor:pointer; font-size:20px;" id='change_glr'><i class="fa fa-pencil" aria-hidden="true"></i></a>
		&nbsp;&nbsp;&nbsp;
		<a style="color:#000; cursor:pointer; font-size:20px;" id='add_glr'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
		</div>
		<?php } ?>
		<!-- edit icon end -->
    </div>
	<div class="col-md-12 col-sm-12 select_img" style='display:none;'>
	<input type='button' name='del-glry-imgs' id='del-glry-imgs' value=' Delete ' />
	<input type='button' name='del-glry-cancel' id='del-glry-cancel' value=' Cancel ' />
	</div>

	<div class="col-md-12 col-sm-12 text-center" id='facility-glry-add' style='display:none;'>
		<div class="single-blog">
		<h3>Add Gallery Images</h3>
		<form name='add_glr_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/facility/add_glry_images" enctype='multipart/form-data'>
			<div style="margin:20px" align='center'><input type='file' name='fa_glry_imgs[]' multiple /></div>
			<div style="margin:20px" align='center'>
			<textarea name='fa_yt_links' id='fa_yt_links' style="width:500px; height:150px;" placeholder='Enter video links with comma (,) seperated'></textarea></div>
			<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
			<input type='hidden' name='pre_glry_imgs' id='pre_glry_imgs' value='<?php echo $facility_details['Facility_Gallery']; ?>' />
			<input type='submit' name='glry_submit' id='glry_submit' value='  Add  ' style='margin-right:15px;' />
			<input type='button' name='glry_cancel'  id='glry_cancel'  value='  Cancel  ' />
		</form>
		</div>
	</div>

        <div id="portfolio" class="portfolio team-row">
      <div class="container">
<!-- <iframe height="480" width="500"  
src="https://www.youtube.com/embed/S6vsWsWSRac"> 
</iframe>  -->

        <div class="row portfolio-container">

		<?php
			$facility_glry = $facility_details['Facility_Gallery'];

			if($facility_glry and $facility_glry != 'null'){
				$glry_arr = json_decode($facility_glry, true);
				foreach($glry_arr as $glry){
					$img_path = base_url()."assets/club_facility/".$org_id."/gallery/".$glry;
					$orginal_path = base_url()."assets/club_facility/".$org_id."/gallery/originals/".$glry;
			?>
			<div class="col-lg-4 col-md-6 portfolio-item">
			<div class='select_img' style='display:none;'>
			<input type='checkbox' class='select_chck_imgs' name='sel_gallery_imgs[]' value='<?=$glry;?>' /></div>
			<img src="<?php echo $img_path; ?>" class="pg-img-fluid" alt="">
			<div class="portfolio-info">
			<a href="<?php echo $orginal_path; ?>" data-gall="portfolioGallery" class="venobox preview-link" title="App 1"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
			</div>
			</div>
		<?php
				}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">Gallery Images are not available!</div>
		<?php
			}
		?>
			</div><!-- row -->
		</div>
		</div>
	</div>
  </div>
</section>


<section class="blog-wrapper" id="videos">
<div class="portfolio-page">
  <div class="container">
    <div class="title">
      <h2>Videos</h2>
      <div><span></span></div>
		<!-- edit icon -->
		<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
		<div class="vids-edit-icon">
		<a style="color:#000; cursor:pointer; font-size:20px;" id='change_vids'><i class="fa fa-pencil" aria-hidden="true"></i></a>
		&nbsp;&nbsp;&nbsp;
		<a style="color:#000; cursor:pointer; font-size:20px;" id='add_vids'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
		</div>
		<?php } ?>
		<!-- edit icon end -->
    </div>
	<div class="col-md-12 col-sm-12 select_vid" style='display:none;'>
	<input type='button' name='del-vids-imgs' id='del-vids-imgs' value=' Delete ' />
	<input type='button' name='del-vids-cancel' id='del-vids-cancel' value=' Cancel ' />
	</div>

	<div class="col-md-12 col-sm-12 text-center" id='facility-vids-add' style='display:none;'>
		<div class="single-blog">
		<h3>Add Video Links</h3>
		<form name='add_vids_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/facility/add_videoLinks" enctype='multipart/form-data'>
			<div style="margin:20px" align='center'>
			<textarea name='fa_yt_links' id='fa_yt_links' style="width:500px; height:150px;" placeholder='Enter video links with comma (,) seperated'></textarea></div>
			<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
			<input type='hidden' name='prev_vids' id='prev_vids' value='<?php echo $facility_details['VideoLinks']; ?>' />
			<input type='submit' name='vids_submit' id='vids_submit' value='  Add  ' style='margin-right:15px;' />
			<input type='button' name='vids_cancel'  id='vids_cancel'  value='  Cancel  ' />
		</form>
		</div>
	</div>

        <div id="portfolio" class="portfolio team-row">
      <div class="container">
<!-- <iframe height="480" width="500"  
src="https://www.youtube.com/embed/S6vsWsWSRac"> 
</iframe>  -->

        <div class="row portfolio-container">

		<?php
			$facility_glry = $facility_details['VideoLinks'];

			if($facility_glry and $facility_glry != 'null'){
				$glry_arr = json_decode($facility_glry, true);
				foreach($glry_arr as $glry){

					if(strpos($glry, 'ttp')){
			?>
			 <div class="col-lg-4 col-md-6 portfolio-item">
			 	<div class='select_vid' style='display:none;'>
				<input type='checkbox' class='select_chck_vids' name='sel_vid_links[]' value='<?=$glry;?>' /></div>
				<iframe height="400" width="100%" src="<?=$glry;?>"> </iframe>
			 </div>
			<?php
					}
				}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">Videos are not available!</div>
		<?php
			}
		?>
			</div><!-- row -->
		</div>
		</div>
	</div>
  </div>
  <input type='hidden' name='baseURL' id='baseURL' value='<?=base_url();?>' />
</section>