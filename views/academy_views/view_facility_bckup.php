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
		$('#ps-team').hide();
		$('#edit-ps-team').show();
	});

	$('#ps_cancel').click(function () {
		$('#ps-team').show();
		$('#edit-ps-team').hide();
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
	$('#glry_cancel').click(function () {
		$('#facility-glry-add').hide();
	});

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
				url: '/facility/delete_glry',
				type: "post",
				data:{sel_images:sel_imgs, all_imgs:all_imgs},
				success: function(res) {
					//$('#response').html(data);
					alert('Images deleted!');
				//	location.reload();
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

<!-- <div class="content-section-facility-about facility-img1" data-stellar-background-ratio="0.5">
  <div class="container-fluid">
    <div class="row margin-left-about">
      <div class="facility-bg">
        <div class="box bg-cello section-relative">
          <h3>Our Facility</h3>
          <div class="facility-head">12 Courts</div>
          <ul class="list-marked1">
            <li>Eight (8) high quality maplewood sports courts.</li>
			<li>Four (4) courts with BWF-approved Nagase Kenko badminton mats on top of wood flooring.</li>
			<li>Anchored sports floor system with 64% shock absorption (badminton standard 55%-75%; good for knees)</li>
			<li>Matte finish on wood flooring provides a low specular reflectance value to avoid glare</li>
			<li>BWF-approved Victor net posts</li>
			<li>6 feet between courts and 8 feet behind courts</li>
          </ul>

		  <div class="facility-head">Dark colored walls and ceiling</div>
		  <div  style="margin-bottom:10px">Provides contrast for good shuttlecock visibility</div>

		  <div class="facility-head">Strip lighting positioned between courts</div>
		  <div>Provides even light distribution and reduces glare</div>

           
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- About Us End --> 


<section class="blog-wrapper" style="background:#fff">
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
			<img src="<?=$lt_img; ?>" alt="" style="width:70%; height:197px;">
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

<!-- <section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <div class="title">
      <h2>Partners and Spnsors</h2>
      <div><span></span></div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-6 text-center">
        <div class="single-blog">
			<div style="margin-top:10px"><img src="<?php echo base_url(); ?>assets/club_pages/images/bod1.jpg" alt="" style="width:70%"></div>
          <div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">Adda Sports Pub</h3>
			<b>Director</b>
			</div>
			<p>This is a link to the Sponsor's website</p>
			</div>
        </div>
      <div class="col-md-3 col-sm-6 text-center">
        <div class="single-blog">
			<div style="margin-top:10px"><img src="<?php echo base_url(); ?>assets/club_pages/images/bod1.jpg" alt="" style="width:70%"></div>
          <div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">IncorpTaxAct</h3>
			<b>Head Coach</b>
			</div>
			<p>This is a link to the Sponsor's website</p>
			</div>
        </div>
      <div class="col-md-3 col-sm-6 text-center">
        <div class="single-blog">
			<div style="margin-top:10px"><img src="<?php echo base_url(); ?>assets/club_pages/images/bod1.jpg" alt="" style="width:70%"></div>
          <div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">SS Lending</h3>
			<b>Coach1</b>
			</div>
			<p>This is a link to the Sponsor's website</p>
			</div>
        </div>
		<div class="col-md-3 col-sm-6 text-center">
        <div class="single-blog">
			<div style="margin-top:10px"><img src="<?php echo base_url(); ?>assets/club_pages/images/bod1.jpg" alt="" style="width:70%"></div>
          <div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">Ed Guru Academy</h3>
			<b>Coach2</b>
			</div>
			<p>This is a link to the Sponsor's website</p>
			</div>
        </div>

    </div>
  </div>
</section>
 -->

<section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <div class="title">
      <h2>Partners and Sponsors</h2>
      <div><span></span></div>
			<!-- edit icon -->
			<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
			<div class="ps-edit-icon">
			<a style="color:#000; cursor:pointer;" id='change_ps'><i class="fa fa-pencil" aria-hidden="true"></i></a>
			</div>
			<?php } ?>
			<!-- edit icon end -->
    </div>
    <div class="team-row justify-content-center" id='ps-team'>
		<?php
			if($facility_details['Facility_Partner_Sponsors']){
				$ps_team = json_decode($facility_details['Facility_Partner_Sponsors'], true); 
				
				foreach($ps_team as $i => $team){
					$ps_img = base_url()."assets/club_pages/images/bod1.jpg";

					if($team['img'])
						$ps_img = base_url()."assets/club_facility/".$org_details['Aca_ID']."/ps_team/".$team['img'];

					$ps_name  = $team['name'];
					$ps_role    = $team['role'];
					$ps_desc   = $team['desc'];

					if($team['name']){
		?>
			<div class="col-md-3 col-sm-6 text-center">
			<div class="single-blog" style="border:0px;">
			<div style="margin-top:10px">
			<img src="<?=$ps_img; ?>" alt="" style="width:70%; height:auto;">
			</div>
			<div class="blog-content" style="margin-top:10px">	<h3 style="font-size: 17px; margin-bottom: 2px;"><?//=$ps_name;?></h3>
			<b><?=$ps_role; ?></b>
			</div>
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

		<div class='row' id='edit-ps-team' style='display:none;'>
		<form name='ps_edit_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/facility/update_ps_team" enctype='multipart/form-data'>

		<?php
			if($facility_details['Facility_Partner_Sponsors'] and $facility_details['Facility_Partner_Sponsors'] != 'null'){
				$ps_team = json_decode($facility_details['Facility_Partner_Sponsors'], true); 
				
				foreach($ps_team as $i => $team){

					if($team['img'])
						$ps_img = base_url()."assets/club_pages/images/bod1.jpg";

					$ps_name  = $team['name'];
					$ps_role    = $team['role'];
					$ps_desc   = $team['desc'];
		?>
			<div class="col-md-3 col-sm-6 text-center">
			<div class="single-blog">
			<div style="margin-top:10px">
			<input type='file' name='ps_imgs[]' />
			<input type='hidden' name='ps_prev_imgs[]' value='<?=$team['img'];?>' />
			</div>
			<div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;"><input type='text' name='ps_name[]' class="form-control" placeholder="Name" value='<?=$ps_name;?>' /></h3>
			<b><input type='text' name='ps_role[]' class="form-control" placeholder="Role" value='<?=$ps_role;?>' /></b>
			</div>
			<p><textarea name='ps_desc[]' cols='25' rows='3' placeholder='Summary'><?=$ps_desc; ?></textarea></p>
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
			<div style="margin-top:10px"><input type='file' name='ps_imgs[]' /></div>
			<div class="blog-content" style="margin-top:10px">
			<h3 style="font-size: 17px; margin-bottom: 2px;">
			<input type='text' name='ps_name[]' class="form-control" placeholder="Name" value='' /></h3>
			<b><input type='text' name='ps_role[]' class="form-control" placeholder="Role" value='' /></b>
			</div>
			<p><textarea name='ps_desc[]' cols='25' rows='3' placeholder='Summary'></textarea></p>
			</div>
			</div>
			<?php
				}
			}
			?>
	<div class='col-md-12' style='margin-top:10px;' align='center'>
	<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
	<input type='submit' name='ps_submit' id='ps_submit' value='  Update  ' style='margin-right:15px;'/>
	<input type='button' name='ps_cancel' id='ps_cancel' value='  Cancel  '   />
	</div>
	</form>
</div>


    </div>
  </div>
</section>

<section class="blog-wrapper home-about-bg">
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
			<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
			<input type='hidden' name='pre_glry_imgs' id='pre_glry_imgs' value='<?php echo $facility_details['Facility_Gallery']; ?>' />
			<input type='submit' name='glry_submit' id='glry_submit' value='  Add  ' style='margin-right:15px;' />
			<input type='button' name='glry_cancel'  id='glry_cancel'  value='  Cancel  ' />
		</form>
		</div>
	</div>

        <div id="portfolio" class="portfolio team-row">
      <div class="container">


        <div class="row portfolio-container">

		<?php
			$facility_glry = $facility_details['Facility_Gallery'];

			if($facility_glry and $facility_glry != 'null'){
				$glry_arr = json_decode($facility_glry, true);
				foreach($glry_arr as $glry){
					$img_path = base_url()."assets/club_facility/".$org_id."/gallery/".$glry;
					$orginal_path = base_url()."assets/club_facility/".$org_id."/gallery/originals/".$glry;
		?>
			    <!-- <div class="gallery-caption col-md-4 col-sm-6 col-xs-12">
				<div class='select_img' style='display:none;'>
				<input type='checkbox' class='select_chck_imgs' name='sel_gallery_imgs[]' value='<?=$glry;?>' /></div>
				<a href="<?php echo $img_path; ?>"> 
					<img alt="" src="<?php echo $img_path; ?>" class="facility-gallery-responsive" />
					<div class="caption row">
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="blur caption-text">
						  <div class="gallery_caption_icon"> <span class="fa  fa-search"></span> </div>
						</div>
					  </div>
					</div>
				</a> 
			</div> -->
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
		<div class="col-md-12 col-sm-6 text-center">No Gallery Images available!</div>
		<?php
			}
		?>
          <!-- <div class="gallery-caption col-md-4 col-sm-6 col-xs-12"> 
				<a href="<?php echo base_url(); ?>assets/club_pages/images/pg/1.jpg"> 
					<img alt="" src="<?php echo base_url(); ?>assets/club_pages/images/pg/ARC_Facility1.jpg" class="img-responsive" />
					<div class="caption row">
					  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="blur caption-text">
						  <div class="gallery_caption_icon"> <span class="fa  fa-search"></span> </div>
						</div>
					  </div>
					</div>
				</a> 
			</div> -->

			</div><!-- row -->
		</div>
		</div>
	</div>
  </div>
  <input type='hidden' name='baseURL' id='baseURL' value='<?=base_url();?>' />
</section>