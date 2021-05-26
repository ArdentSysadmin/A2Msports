<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";

$(document).ready(function(){
	$('#forms_submit').click(function(e){
		$('#forms_submit').hide();
		$('#pl_wt').show();
		//e.preventDefault();
	});
});
</script>
<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
selector: '#alert_message',
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

<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet">
<!-- About Us End --> 

<section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <!-- <div class="title"> -->
      <!-- <h2>Customise Menu</h2>
      <div><span></span></div> -->
			<!-- edit icon -->

			<!-- edit icon end -->
    <!-- </div> -->

<!-- Inner Page Wrapper Start -->
<div class="inner-page-wrapper faq-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
  
		<div class="gallerytab">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#menu" style="font-weight:bold; font-size:14px">Club Menu</a></li>
				<li><a href="#forms" style="font-weight:bold; font-size:14px">Forms</a></li>
				<li><a href="#alert" style="font-weight:bold; font-size:14px">Alert Message</a></li>
				<li><a href="#testimonials-tab" style="font-weight:bold; font-size:14px">Testimonials</a></li>
				<li><a href="#homepage-tab" style="font-weight:bold; font-size:14px">Home Page</a></li>
			</ul>

	<div class="tab-content">
		<div id="menu" class="tab-pane fade in active">
			<div>
				<!-- tab content -->
					<!-- <div class="single-blog"> -->
					<h4 style='margin:20px;'>Select the Menu Items that you want to show on your club.</h4>
					<form name='add_glr_frm' method='POST' 
					action="<?=$this->config->item('club_form_url');?>/update_menu">
					<?php
					//echo "<pre>"; print_r($club_menu_all);print_r($club_menu_show);
					$club_menu = json_decode($club_menu_show['Active_Menu_Ids'], true);
					foreach($club_menu_all as $i => $menu){
					$checked = '';
					if(!in_array($menu->Menu_ID, $club_menu))
					$checked = 'checked';
					?>
					<input type='checkbox' name='club_menu_items[]' id='' value='<?php echo $menu->Menu_ID; ?>' <?=$checked;?>/>&nbsp;<?php echo $menu->Menu_Title; ?>
					&nbsp;&nbsp;&nbsp;
					<?php
					$menu_all_items[] = $menu->Menu_ID;
					}
					?>
					<br /><br /><br />
					<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
					<input type='hidden' name='menu_all_items' id='menu_all_items' value='<?php echo json_encode($menu_all_items); ?>' />
					<input type='submit' name='menu_submit' id='menu_submit' value='  Update  ' style='margin-right:15px;' />
					<!-- <input type='button' name='glry_cancel'  id='glry_cancel'  value='  Cancel  ' /> -->
					</form>
					<!-- </div> -->
				<!-- End of tab content -->
			</div>
		</div><!-- home1 -->

		<div id="forms" class="tab-pane fade">
			<div>
				<!-- Forms tab content -->
				<h4 style='margin:20px;'>Upload Club's Terms & Conditions, Privacy Policy and Waiver Form.</h4>
					<form name='forms_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/update_forms" enctype='multipart/form-data'>
					<?php
						$prev_forms = '';
						if(	$facility_details['Academy_Forms'])
						$prev_forms = json_decode($facility_details['Academy_Forms'], TRUE);
					?>
					<label style='margin:20px;'>
					<?php if($prev_forms['terms_cond']) 
									echo $prev_forms['terms_cond']."<br /><br />"; ?>
					Terms & Conditions  &nbsp; &nbsp; 
					<input type='file' name='terms_cond' id='terms_cond' value='' /></label>
					
					<label style='margin:20px;'> 
					<?php if($prev_forms['priv_polic']) 
									echo $prev_forms['priv_polic']."<br /><br />"; ?>
					Privacy Policy  &nbsp; &nbsp; 
					<input type='file' name='priv_polic' id='priv_polic' value='' /></label>

					<label style='margin:20px;'> 
					<?php if($prev_forms['waiver_form']) 
									echo $prev_forms['waiver_form']."<br /><br />"; ?>
					Waiver Form  &nbsp; &nbsp; 
					<input type='file' name='waiver_form' id='waiver_form' value='' /></label>

					<br /><br /><br />
					<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
					<input type='hidden' name='terms_cond_prev' id='terms_cond_prev' value='<?php echo $prev_forms['terms_cond']; ?>' />
					<input type='hidden' name='priv_polic_prev' id='priv_polic_prev' value='<?php echo $prev_forms['priv_polic']; ?>' />
					<input type='hidden' name='waiver_form_prev' id='waiver_form_prev' value='<?php echo $prev_forms['waiver_form']; ?>' />
					<input type='submit' name='forms_submit' id='forms_submit' value='  Update  ' style='margin-right:15px;' />
					<span id='pl_wt' style='display:none; font-weight:bold;'>Please wait ... </span>

					</form>
				<!-- Forms tab content -->
			</div>
		</div><!-- menu1 -->


	<div id="alert" class="tab-pane fade">
	<div>
			<!-- Forms tab content -->
				<h4 style='margin:20px;'>Home Page Alert Message.</h4>
					<form name='forms_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/update_message">
					<?php
						$alert_msg = '';
						if(	$facility_details['Alert_Message'])
						$alert_msg = $facility_details['Alert_Message'];
					?>
					<!-- <label style='margin:20px;'> -->					 
					<textarea name="alert_message" class="txt-area" id="alert_message"><?php echo $alert_msg; ?></textarea>
					<!-- </label> -->
					<br /><br /><br />
					<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
					<input type='submit' name='alert_submit' id='alert_submit' value='  Update  ' style='margin-right:15px;' />
					<span id='alert_pl_wt' style='display:none; font-weight:bold;'>Please wait ... </span>

					</form>
				<!-- Forms tab content -->

			</div>
		</div><!-- menu1 -->

<script>
$(document).ready(function(){
	$('#add_testim').click(function(){ 
		$('#add_testim_frm').toggle();
			$('#edit_testim_frm').hide();

	});
	$('.del_testim').click(function(){ 
		if(confirm("Are you sure to delete?")){
			var id = $(this).attr('id');
				var a = id.split('_');
				var tid = a[2];

			$.ajax({
				type:'POST',
				url:club_baseurl+'/delete_testim/',
				data:{ id:tid },    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
					alert("Delete successfull");
					location.reload();
				}
			});
		}
	});
$(document).on('click', '#cancel_upd_testim', function(){
	$('#edit_testim_frm').hide();
});

$('#cancel_add_testim').click(function(){ 
	$('#add_testim_frm').hide();
});

$('.edit_testim').click(function(){ 
		//if(confirm("Are you sure to delete?")){
			var id = $(this).attr('id');
				var a = id.split('_');
				var tid = a[2];
//alert(tid);
			$.ajax({
				type:'POST',
				url:club_baseurl+'/get_testim/',
				data:{ id:tid },    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
					//alert("Delete successfull");
					//location.reload();
					$('#edit_testim_frm').html(html);
					$('#edit_testim_frm').show();
				}
			});
	});

	$('#homepage-layout').change(function(){ 
		if(confirm("Are you sure to switch the layout?")){
			var v = $(this).val();

			$.ajax({
				type:'POST',
				url:club_baseurl+'/swtich_layout/',
				data:{ swt:v },    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
					if(html){
						alert("Changes are done.");
						location.reload();
					}
					else{
						alert("Something went wrong, please contact Admin.");
					}
				}
			});
		}
	});

});
</script>

	<div id="testimonials-tab" class="tab-pane fade">
	<div>
			<!-- Forms tab content -->
			<div style="text-align:right">
				<input type="button" id="add_testim" name="add_testim" value=" Add Testimonial " class="btn submit-btn" style="margin:20px 0px">
				</div>
					<form id='add_testim_frm' name='add_testim_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/add_testimonial" style='display:none;' enctype='multipart/form-data'>
		
					<div style="margin:10px">
					<textarea name="testim_message" class="txt-area" id="testim_message" cols='120' rows='5' placeholder='Enter your Testimonial'></textarea>
					</div>
					<div style="margin:10px">
						<input type='text' name='testim_by' id='testim_by' class='form-control' style='width: 35%;' placeholder='Testimonial By' />
					</div>
					<div style="margin:10px">
						<input type='file' name='testim_by_img' id='testim_by_img' value='' placeholder='Image' /><br />
						<b>Note: </b>For best fit, use 170 x 170 image.<br />
					</div>
					<div style="margin:20px">
						<input type='hidden' name='redirect_page' id='redirect_page' value='<?php echo $_SERVER['REQUEST_URI']; ?>' />
						<input type='submit' name='btn_add_testim' id='btn_add_testim' value='  Add  ' style='margin-right:15px;' />
						<input type='button' name='cancel_add_testim' id='cancel_add_testim' value='  Cancel  ' style='margin-right:15px;' />
						<span id='btn_add_testim_wt' style='display:none; font-weight:bold;'>Please wait ... </span>
					</div>
					<br /><br /><br />
					</form>

				<form id='edit_testim_frm' name='edit_testim_frm' method='POST' action="<?=$this->config->item('club_form_url');?>/upd_testimonial" style='display:none;' enctype='multipart/form-data'>

				</form>
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">Testimonial</th>
						  <th scope="col">User</th>
						  <th scope="col">Image</th>
						  <th scope="col"></th>
						</tr>
					  </thead>
					  <tbody>
					<?php
						if(	$testim_details){
							$i = 1;
							foreach($testim_details as $testim){
					?>
						<tr>
						<th scope="row"><?=$i;?></th>
						<td><?php echo substr($testim->testimonial, 0, 20)." ..."; ?></td>
						<td><?php echo $testim->user_name; ?></td>
						<td><?php echo $testim->user_img; ?></td>
						<td><a class='edit_testim' id='edit_testim_<?=$testim->tab_id;?>' style='cursor:pointer;'>Edit</a> | <a class='del_testim' id='del_testim_<?=$testim->tab_id;?>' style='cursor:pointer;'>Delete</a></td>
						</tr>
					<?php
							$i++;
							}
					}
					else{
					?>
						<tr>
						  <td>No Testimonials are added yet</td>
						</tr>
					<?php
					}
					?>
  </tbody>
</table>
				<!-- Forms tab content -->

			</div>
		</div><!-- menu1 -->

	<div id="homepage-tab" class="tab-pane fade">
	<div>
		<label>Switch Home page Layout to ?</label>
		<select name='homepage-layout' id='homepage-layout' class='form-control' style='width:40%'>
		<option value=''>Select</option>
		<option value='video' <?php if($org_details['Home_Layout'] == 'video') echo "selected"; ?>>Video Template</option>
		<option value='banner' <?php if($org_details['Home_Layout'] == 'banner') echo "selected"; ?>>Banner Image</option>
		</select>
	</div>
	</div><!-- Home Page -->

	</div><!-- tab-content -->
		</div><!-- gallerytab -->
      </div>
      
    </div>
  </div>
</div>
<!-- Inner Page Wrapper End --> 

    <div class="team-row justify-content-center" id='lt-team'>
	<div class="col-md-12 col-sm-12 text-center" id='facility-glry-add'>
		
	</div>
    </div>

  </div>
</section>
<script>
$(document).ready(function(){
    $(".nav-tabs a").click(function(){
        $(this).tab('show');
    });
});
</script>