<script>
$(document).ready(function(){

});
</script>


<link href="<?=base_url();?>assets/club_pages/assets/vendor/venobox.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="<?=base_url();?>assets/club_pages/css/pg.css" rel="stylesheet">
<!-- About Us End --> 

<section class="blog-wrapper" style="background:#fff">
  <div class="container">
    <div class="title">
      <h2>Customise Menu</h2>
      <div><span></span></div>
			<!-- edit icon -->

			<!-- edit icon end -->
    </div>

    <div class="team-row justify-content-center" id='lt-team'>
	<div class="col-md-12 col-sm-12 text-center" id='facility-glry-add'>
		<div class="single-blog">
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
		</div>
	</div>

    </div>

  </div>
</section>