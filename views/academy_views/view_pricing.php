<script>
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
		var baseurl			= "<?php echo base_url();?>";
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
				url: baseurl+short_code+'/facility/delete_glry',
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

});
</script>

<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>

<script>
tinymce.init({
selector: '#pricing_desc',
height: 300,
theme: 'modern',
plugins: [
'advlist autolink lists link image charmap print preview hr anchor pagebreak',
'searchreplace wordcount visualblocks visualchars code fullscreen',
'insertdatetime media nonbreaking save table contextmenu directionality',
'template paste textcolor colorpicker textpattern imagetools codesample toc help'
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
<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet">

<!-- About Us End --> 

<section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <div class="title">
      <h2>Pricing</h2>
      <div><span></span></div>
			<!-- edit icon -->
			<?php if($this->session->userdata('users_id') == $org_details['Aca_User_id']){ ?>
			<div class="lt-edit-icon">
		<a style="color:#000; cursor:pointer; font-size:20px;" id='add_glr'><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
			</div>
			<?php 
			} ?>
			<!-- edit icon end -->
    </div>
	<?php
	if($facility_details['Pricing_Info']){
			$club_pricing_info = $facility_details['Pricing_Info']; 
			$details = json_decode($club_pricing_info, TRUE);
			
			//foreach($lt_team as $i => $team){
				$lt_img = $details['src'];
	}
	?>
    <div class="team-row justify-content-center" id='lt-team'>
	<div class="col-md-12 col-sm-12 text-center" id='facility-glry-add' style='display:none;'>
		<div class="single-blog">
		<h3>Add Pricing Info: (pdf)</h3>
		<form name='add_glr_frm' method='POST' 
		action="<?=$this->config->item('club_form_url');?>/pricing/update" enctype='multipart/form-data'>
			<div style="margin:20px" align='center'>
			<input type='file' name='fa_pricing' accept="application/pdf,application/msword" /></div>
			<div style="margin:20px" align='center'>
			<textarea name="pricing_desc" class="txt-area" id="pricing_desc"><?php echo stripslashes($details['desc']); ?></textarea>
			</div>
			<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
			<input type='hidden' name='pre_prc_file' id='pre_prc_file' value='<?php echo $details['src']; ?>' />
			<input type='hidden' name='pre_prc_desc' id='pre_prc_desc' value='<?php echo stripslashes($details['desc']); ?>' />
			<input type='submit' name='glry_submit' id='glry_submit' value='  Add  ' style='margin-right:15px;' />
			<input type='button' name='glry_cancel'  id='glry_cancel'  value='  Cancel  ' />
		</form>
		</div>
	</div>

		<?php
			if($facility_details['Pricing_Info']){
				$club_pricing_info = $facility_details['Pricing_Info']; 
				$details = json_decode($club_pricing_info, TRUE);
				
				//foreach($lt_team as $i => $team){
					$lt_img = $details['src'];
					if($details['desc']){
		?>
			<div class="single-blog" style="border:0px;">
				<div class="blog-content" style="margin-top:10px">
					<?php echo stripslashes($details['desc']); ?>
				</div>
			</div>
		<?php	
					}
					if($lt_img){
		?>
			<div class="col-md-12 col-sm-6 text-center">
			<div class="single-blog" style="border:0px;">
				<div class="blog-content" style="margin-top:10px">
					<embed src="<?php echo base_url().'assets/club_facility/'.$org_details['Aca_ID'].'/pricing/'.$lt_img; ?>" width="800px" height="800px" />
				</div>
			</div>
			</div>
		<?php
					}

				//}
			}
			else{
		?>
		<div class="col-md-12 col-sm-6 text-center">No Pricing info is added yet!</div>
		<?php
			}
		?>
    </div>

  </div>
</section>