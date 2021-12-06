 <script>
 $(document).ready(function(){
   
	$(".img-winner").click(function(){
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

var baseurl	= "<?php echo base_url();?>";
		
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

var baseurl = "<?php echo base_url();?>";
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

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="https://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
type="text/javascript"></script>

<style type="text/css">
@import url("https://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");

#feedControl {
margin-top : auto;
margin-left: auto;
margin-right: auto;
width : auto;
font-size: 12px;
color: #9CADD0;
}
</style>
<script type="text/javascript">
function load() {
var feed = "<?php echo $rss_feed_url;?>";
new GFdynamicFeedControl(feed, "feedControl");

}
google.load("feeds", "1");
google.setOnLoadCallback(load);
</script>

<!-- start sw-rss-feed code --> 
<script type="text/javascript"> 

var baseurl = "<?php echo base_url();?>";
rssfeed_url = new Array(); 

//rssfeed_url[0]="http://www.usopen.org/en_US/news/rss/usopen.rss";  
rssfeed_url[0]="<?php echo $rss_feed_url; ?>"; 
//alert(rssfeed_url);
rssfeed_frame_width="300";
rssfeed_frame_height="260";
rssfeed_scroll="on";
rssfeed_scroll_step="6";
rssfeed_scroll_bar="off";
rssfeed_target="_blank";
rssfeed_font_size="13";
rssfeed_font_face="";
rssfeed_border="on";
rssfeed_css_url=baseurl+"css/rss-feed.css";
rssfeed_title="on";
rssfeed_title_name="";
rssfeed_title_bgcolor="#3366ff";
rssfeed_title_color="#fff";
rssfeed_title_bgimage="";
rssfeed_footer="off";
rssfeed_footer_name="rss feed";
rssfeed_footer_bgcolor="#fff";
rssfeed_footer_color="#333";
rssfeed_footer_bgimage="";
rssfeed_item_title_length="50";
rssfeed_item_title_color="#666";
rssfeed_item_bgcolor="#fff";
rssfeed_item_bgimage="";
rssfeed_item_border_bottom="on";
rssfeed_item_source_icon="off";
rssfeed_item_date="off";
rssfeed_item_description="on";
rssfeed_item_description_length="120";
rssfeed_item_description_color="#666";
rssfeed_item_description_link_color="#333";
rssfeed_item_description_tag="off";
rssfeed_no_items="0";
rssfeed_cache = "<?php echo md5($rss_feed_url); ?>";
</script> 
 
<!-- The link below helps keep this service FREE, and helps other people find the SW widget. Please be cool and keep it! Thanks. --> 
<!--Right Column-->

<div class="col-md-3 right-column">
<br /><br /><br /><br /><br /><br />
			<!-- -------------Player of month start section------------------------------------ -->
				<div class="atp-single-player">
				<label>PLAYER OF THE MONTH</label>
				<div class="top-score-title">
				<br />
				<?php 
				$get_pom  = $this->general->get_pom();
				$org_pom  = $get_pom['POM'];
				$get_user = $this->general->get_user($org_pom);
				?>
				<div id='pom_div'>
				<?php if($org_pom) {?> 
				<a href="<?php echo base_url();?>player/<?php echo $org_pom;?>">
				<?php echo ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']); ?></a>
				<?php } else { echo "No Player is declared yet!"; } ?>
				<?php if($this->session->userdata('role') == 'Admin'){?>
				<img src='<?php echo base_url()."images/ico-images/Edit.png"; ?>' id='img-winner' class='edit_score img-winner' 
				width='30px' height='30px' style='cursor:pointer' />
				<?php } ?>
				</div>

				<form id='frm_academy_pom' name='frm_academy_pom' method="post">
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
			
			<?php if($sport == 3){ ?>
			<div class="top-score-title col-md-12" style="padding-top:37px;">
			<a href="mailto:admin@a2msports.com"><img src="<?=base_url();?>images/YouHe.jpg" alt="" /></a>
			</div>
			<?php } ?>

			<!-- Google AdSense -->
			<!-- <div id="google" align='center' style='margin-bottom:120px;'>
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
                <h3> <a href="<?php echo base_url();?>News">Latest News</a>
					<?php 
					//$admin_users= array(214,215);
					$admin = $this->session->userdata('admin');
					//$user_id = $this->session->userdata('users_id');?>
					<?php if($admin){ ?>
					 - <a href="<?php echo base_url();?>News/add">ADD</a>
					 <?php }?>
				 </h3>
				<?php 
				if(!empty($results)){
				
				foreach($results as $row ){ ?>
                <div class="right-content">
                    <p class="news-title-right">
					<a href=<?php echo base_url() ."News/get_news_detail/" . $row->News_id ;?>>
					<?php 
						 $s = substr($row->News_title, 0, 25);
						 $res = substr($s, 0, strrpos($s, ' '));
						 //$pos=strpos($row->News_title, ' ', 20);
						 //$s = 	substr($row->News_title,0,$pos ); 
						echo $res . "...";
						 ?>
					</a>
					</p>
                    <p class="txt-right">
					<?php
						$abc	= strip_tags($row->News_content);
						$result = substr($abc, 0, strpos($abc, '.'));

						echo $result . "...";
					?>
					</p>

                    <a href=<?php echo base_url() ."News/get_news_detail/" . $row->News_id ;?> class="ca-more"><i class="fa fa-angle-double-right"></i>More...</a>

					<?php 
						$user_id = $this->session->userdata('admin');?>
					<?php if($admin){ ?>
					<p style="float:right"><a href=<?php echo base_url()."News/edit/" . $row->News_id ;?>><u>Edit</u></a>&nbsp;&nbsp;</p>

					<?php }?>
                </div>
            <?php }
            }else{ ?>

                 <div class="right-content">
                    <p class="txt-right">
                     No News found for this Tournament Sports!
                    </p>
                 </div>
            <?php } ?>
          </div>
		  
		  <!-- --------------------------------- End of Latest News Section ------------------------------------------------->
		  <!-- ------------------- Begin RSS Feed ------------------------------------------------------------------------>
		 <?php if(in_array($sport, $sports_feeds_array)){  ?>
		  <script type="text/javascript" src="<?=base_url();?>/js/custom/rss-feed.js"></script>
		  <?php } ?>

		  <!-- -------------- End of RSS Feed ------------- -->
          <div class="top-score-title col-md-12 hidden-xs">
            <a href="http://www.teamusa.org/usa-table-tennis/events" target='_blank'>
			<img src="<?php echo base_url();?>images/USATT.png" alt="" />
			</a>
          </div>
		  <!-- --------------------- End of Image----------------------------- -->
		  
           <div class="top-score-title col-md-12 hidden-xs right-title">
                <h3>Photos</h3> 
           <?php
		   	$get_tour_images = $this->general->get_tournImages_bySportsType($sport);
			//echo "<pre>";print_r($get_tour_images);

		   if(!empty($get_tour_images)){?>
                <ul class="right-last-photo">
				<?php
				//$get_tour_images = $this->general->get_tour_images();
		   
				$a = 1;
				foreach($get_tour_images as $i => $get_info)
				{
				$tour_id		= $get_info->Tournament_id;
				$image_pic = base_url()."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;
				$image_loc = $_SERVER['CONTEXT_DOCUMENT_ROOT']."tour_pictures/".$tour_id."/thumbs/".$get_info->Image_file;
									
				if($a <= 9 && file_exists($image_loc)){
				?>
				<li>
					<div class="jm-item second">
						<div class="jm-item-wrapper">
							<div class="jm-item-image">
							 <a href="<?php echo base_url()."league/".$tour_id; ?>">
							 <img src="<?php echo $image_pic; ?>" width = "83px" height = "62.25px" alt="" />
							 </a>
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
      <?php }else{
		  echo '<ul class="right-last-photo"><li>No Images Found! </li></ul>';
		    }?>
          </div>
          </div>
		  
		  </section>


		  <!-- -----------view_home,view_news_edit,footer,view_right_column----------------------------------------------- -->