<script>
var club_baseurl = "<?php echo $this->config->item('club_form_url'); ?>";

$(document).ready(function(){
	$('#membership_type').focus(function(){
		$('#mem_type_stat').html('');
	});

	$('#membership_id').focus(function(){
		$('#mem_id_stat').html('');
	});
/*
	$('#membership_type').blur(function(){
		var mtype = $('#membership_type').val();
		//alert(mtype);
		if(mtype){
				$.ajax({
				url: club_baseurl+'/admin/check_membership_type',
				type: "post",
				data:{mtype:mtype},
				success: function(res) {
					//alert(res);
					if(res == 1){
						$('#membership_type').val('');
						$('#mem_type_stat').html('Membership Type is already exists');
					}
				//	location.reload();
				}
				});
		}
	});
	*/

	$('#membership_id').blur(function(){
		var mem_id = $('#membership_id').val();
		//alert(mem_id);
		if(mem_id){
				$.ajax({
				url: club_baseurl+'/admin/check_membership_id',
				type: "post",
				data:{mem_id:mem_id},
				success: function(res) {
					//alert(res);
					if(res == 1){
						$('#membership_id').val('');
						$('#mem_id_stat').html('Membership ID is already exists');
					}
				//	location.reload();
				}
				});
		}
	});

	$('.edit_membership').click(function(){
		var tab_id = $(this).attr('id');
		//alert(mem_id);
		if(tab_id){
				$.ajax({
				url: club_baseurl+'/admin/get_membership_det',
				type: "post",
				data:{tab_id:tab_id},
				success: function(res) {
					 resultObj = eval (res);
        //alert( resultObj[2] );
					$('#upd_expire_date').val('');

					$('#tab_row_id').val(tab_id);
					$('#upd_membership_id').html("<b>"+resultObj[0]+"</b>");
					$('#upd_membership_type').val(resultObj[1]);
					$('#upd_sport_type option[value="'+resultObj[2]+'"]').prop('selected', true);
					$('#upd_frequency option[value="'+resultObj[3]+'"]').prop('selected', true);
					$('#upd_membership_fee').val(parseFloat(resultObj[4]).toFixed(2));
					$('#upd_membership_acc_fee').val(parseFloat(resultObj[5]).toFixed(2));
					$('#upd_membership_status option[value="'+resultObj[6]+'"]').prop('selected', true);
					//$('#upd_expire_date').val(resultObj[7]);
					
					//alert(typeof(resultObj[3]));
					if(resultObj[3] === 'O'){

						var now = new Date(resultObj[7]);

						var day = ("0" + now.getDate()).slice(-2);
						var month = ("0" + (now.getMonth() + 1)).slice(-2);

						var exp_date = now.getFullYear()+"-"+(month)+"-"+(day) ;
						$('#upd_expire_date').val(exp_date);

						$('#edit_div_activationfee').hide();
						$('#edit_div_expdate').show();				
					}
					else{
						$('#edit_div_activationfee').show();
						$('#edit_div_expdate').hide();				
					}
				}
				});
		}
	});

	$('#court_res_download').click(function(){
		var chk_count = $('input[name="sel_loc_ids[]"]:checked').length;
		if(chk_count > 0){
				
				$.ajax({
				url: '/export/court_reservations',
				type: "post",
				data:{},
				success: function(res) {
					//$('#response').html(data);
					alert('Done');
					//	location.reload();
				}
				});
		}
		else
			alert("Select location");
	});

	$("#add_court").click(function(){
		$("#div_add_court").show();
		$("#div_court_list").hide();
		$(".fromtitle").html('Add Court Details');
	});

	$("#cancel_membership").click(function(){
		$("#div_add_court").hide();
		$("#div_court_list").show();
		//$(".fromtitle").html('Court Details');
	});

	$(".edit_membership").click(function(){
		$("#div_edit_court").show();
		$("#div_court_list").hide();
		//$(".fromtitle").html('Add Membership Details');
	});

	$("#cancel_edit_membership").click(function(){
		$("#div_edit_court").hide();
		$("#div_court_list").show();
		//$(".fromtitle").html('Edit Membership Details');
	});


$('.ed_court').on('touchstart click', function(){
	var loc_id		= $(this).attr('name');
	var baseurl		= "<?php echo base_url();?>";
	var short_code	= "<?php echo $this->short_code;?>";
//alert(loc_id);
	if(loc_id != ""){
		$.ajax({
			type:'POST',
			url:baseurl+short_code+'/courts/get_loc_info',
			data:{ loc_id:loc_id},    //{pt:'7',rngstrt:range1, rngfin:range2},
			success:function(res){
				 $("#div_add_court").hide();
				 $("#div_court_list").hide();
				 $("#div_edit_court").show();
				 $("#div_edit_court").html(res);
				 $(".fromtitle").html('Edit Court Details');
				 //$( "div_edit_court" ).removeClass( "col-md-12" ).addClass( "section-border" );

			}
		}); 
	}
});

	$('#courts_add_form').submit(function(){
		$('#add_courts').hide();
		$('#add_courts_wait').show();
	});

});
</script>
<!-- Breadcromb Wrapper Start -->
<div class="breadcromb-wrapper">
  <div class="breadcromb-overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="breadcromb-left">
          <h3>Manage User Memberships</h3>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Breadcromb Wrapper End --> 

<section class="inner-page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-12">

<!-- <section id="single_player" class="container secondary-page">

<div class="top-score-title right-score col-md-9"> -->
<!-- start main body -->

<?php 
if(isset($add_stat)) { ?>
<div class="name" align='left'>
<label for="name_login" style="color:green"><?php echo $add_stat; ?></label>
</div>
<?php } ?>

<div class="col-md-12 league-form-bg" style="margin-top:18px; margin-bottom:20px;">
<div class="section-label">Membership Details</div>
<!-- Main Body Section -->

<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- Edit a Membership section -->
<div id='div_edit_court' class="col-md-12 form-bg" style='display:none;'> 
<?php
if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
?>
<form class="form-horizontal" id='membership_edit_form' method='post' role="form"  action="/upd_memberships"> 
<?php
}
else{
?>
<form class="form-horizontal" id='membership_edit_form' method='post' role="form" action="<?php echo base_url().$this->short_code; ?>/upd_memberships">
<?php
}
?>
<br /><br />
<div class="col-md-12" id='upd_membership_id' style="margin-bottom: 15px;">
<!-- <input type="text" class='form-control' name="upd_membership_id" id="upd_membership_id" placeholder='Membership Code' required /> 
<span id='upd_membership_id'></span>-->
</div>

<div class="col-md-6">
<label>Membership Type</label>
<input type="text" class='form-control' id="upd_membership_type" name="upd_membership_type" placeholder='Membership Type' required />
<span id='upd_mem_type_stat' style='color:red'></span>
</div>

<div class="col-md-6">
<label>Frequency</label>
<select id='upd_frequency' name='upd_frequency' class='form-control' required>
<option value=''>Select</option>
<option value='O'>One Time Charge</option>
<option value='D'>Daily</option>
<option value='W'>Weekly</option>  
<option value='M'>Monthly</option>
<option value='Y'>Yearly</option>	
</select>
</div>
<script>
$(document).ready(function() {
	$('#upd_frequency').change(function(){
		if($(this).val() == 'O'){
			$('#upd_membership_acc_fee').val('0');
			$('#edit_div_activationfee').hide();
			$('#edit_div_expdate').show();
		}
		else{
			$('#edit_div_activationfee').show();
			$('#edit_div_expdate').hide();
		}
	});

});
</script>
<div class="col-md-6">
<label>Membership Fee</label>
<input type="number" class='form-control' id="upd_membership_fee" name="upd_membership_fee" min=0  required />
</div>

<div class="col-md-6" id="edit_div_activationfee">
<label>Activation Fee (One Time)</label>
<input type="number" class='form-control' id="upd_membership_acc_fee" name="upd_membership_acc_fee" min=0 required />
</div>

<div class="col-md-6" id="edit_div_expdate" style='display:none;'>
<label>Expiration Date</label>
<input type="date" class='form-control' id="upd_expire_date" name="upd_expire_date" min=0 required />
</div>

<div class="col-md-6">
<label>Sport</label>
	<select name="upd_sport_type"  id="upd_sport_type" class='form-control' >
	<option value="">Select</option>
	<option value="1">Tennis</option>
	<option value="2">Table Tennis</option>
	<option value="3">Badminton</option>
	<option value="4">Golf</option>
	<option value="5">Racquetball</option>
	<option value="6">Squash</option>
	<option value="7">Pickleball</option>
	<option value="18">Basketball</option>
	<option value="19">Handball</option>
	<option value="20">Paddleball</option>
	</select>
</div>

<div class="col-md-6">
<label>Status</label>
	<select name="upd_membership_status"  id="upd_membership_status" class='form-control'>
	<option value="1">Active</option>
	<option value="0">Inactive</option>
	</select>
</div>

<div class="col-md-12" id="edit_courts">
<input type="hidden" id="tab_row_id" name="tab_row_id"  value="" />
<input type="submit" id="submit_edit_membership" name="submit_edit_membership"  value=" Update Details " class="btn submit-btn" style="margin:20px 0px"/>&nbsp;&nbsp;
<input type="button" id="cancel_edit_membership" name="cancel_edit_membership"  value=" Cancel " class="league-form-submit1" style="margin:20px 0px"/>
</div>

<div class="col-md-12" id="edit_courts_wait" style="display:none;">
<input type="botton"  value="PLEASE WAIT....." class="league-form-submit1" style="margin:20px 0px"/>
</div>
</form>
</div>	 <!-- End of Edit memberships section -->	


<!-- -------------------------------------------------------------------------------------------------------- -->
<!-- Add a membership section -->
<div id='div_add_court' class="col-md-12 form-bg" style='display:none;'> <!-- Add a court section -->
<?php
if($_SERVER['HTTP_X_FORWARDED_HOST'] != ''){
?>
<form class="form-horizontal" id='courts_add_form' method='post' role="form"  action="/add_memberships"> 
<?php
}
else{
?>
<form class="form-horizontal" id='courts_add_form' method='post' role="form" 
action="<?php echo base_url().$this->short_code; ?>/add_memberships">
<?php
}
?>
<br /><br />
<div class="col-md-6">
<label>Membership Code</label>
<input type="text" class='form-control' name="membership_id" id="membership_id" required />
<span id='mem_id_stat' style='color:red'></span>
</div>

<div class="col-md-6">
<label>Membership Type</label>
<input type="text" class='form-control' id="membership_type" name="membership_type" required />
<span id='mem_type_stat' style='color:red'></span>
</div>

<div class="col-md-6">
<label>Frequency</label>
<select id='frequency' name='frequency' class='form-control' required>
<option value=''>Select</option>
<option value='O'>One Time Charge</option>
<option value='D'>Daily</option>
<option value='W'>Weekly</option>  
<option value='M'>Monthly</option>
<option value='Y'>Yearly</option>	
</select>
</div>
<script>
$(document).ready(function() {
	$('#frequency').change(function(){
		if($(this).val() == 'O'){
			$('#membership_acc_fee').val('0');
			$('#div_activationfee').hide();
			$('#div_expdate').show();
			$("#expire_date").attr('required', 'required');
		}
		else{
			$('#div_activationfee').show();
			$('#div_expdate').hide();
			$("#expire_date").removeAttr('required');
		}
	});

});
</script>

<div class="col-md-6">
<label>Membership Fee</label>
<input type="number" class='form-control' name="membership_fee" min=0 value='0'  style='width: 50%;' required />
</div>

<div class="col-md-6" id="div_activationfee">
<label>Activation Fee (One Time)</label>
<input type="number" class='form-control' name="membership_acc_fee" min=0 value='0'  style='width: 50%;' required />
</div>

<div class="col-md-6" id="div_expdate" style='display:none;'>
<label>Expiration Date</label>
<input type="date" class='form-control' id="expire_date" name="expire_date" min=0 />
</div>

<div class="col-md-6">
<label>Sport</label>
	<select name="sport_type"  id="sport_type" class='form-control'>
	<option value="">Select</option>
	<option value="1" <?php if($sport=="1"){ echo "selected=selected"; } ?>>Tennis</option>
	<option value="2" <?php if($sport=="2"){ echo "selected=selected"; } ?>>Table Tennis</option>
	<option value="3" <?php if($sport=="3"){ echo "selected=selected"; } ?>>Badminton</option>
	<option value="4" <?php if($sport=="4"){ echo "selected=selected"; } ?>>Golf</option>
	<option value="5" <?php if($sport=="5"){ echo "selected=selected"; } ?>>Racquetball</option>
	<option value="6" <?php if($sport=="6"){ echo "selected=selected"; } ?>>Squash</option>
	<option value="7" <?php if($sport=="7"){ echo "selected=selected"; } ?>>Pickleball</option>
	<option value="18" <?php if($sport=="18"){ echo "selected=selected"; } ?>>Basketball</option>
	<option value="19" <?php if($sport=="19"){ echo "selected=selected"; } ?>>Handball</option>
	<option value="20" <?php if($sport=="18"){ echo "selected=selected"; } ?>>Paddleball</option>
	</select>
</div>

<!-- <div class="col-md-12">
Notes
<br />
<textarea class='form-control' name='ins_comments' rows='5'></textarea>
</div>
 -->
<div class="col-md-12" id="add_courts">
<input type="submit" id="submit_membership" name="submit_membership"  value="Create Membership" class="btn submit-btn" style="margin:20px 0px"/>&nbsp;&nbsp;
<input type="button" id="cancel_membership" name="cancel_membership"  value=" Cancel " class="league-form-submit1" style="margin:20px 0px"/>
</div>

<div class="col-md-12" id="add_courts_wait" style="display:none;">
<input type="botton"  value="PLEASE WAIT....." class="league-form-submit1" style="margin:20px 0px"/>
</div>
</form>
</div>	 <!-- End of Add a memberships section -->	


<div id='div_court_list' class="section-border">	<!-- List the courts section -->
<div style='text-align:right'>
<input type="button" id="add_court" name="add_court"  value=" Add New Membership " class="btn submit-btn" style="margin:20px 0px" />
</div>
<!-- <div><?php /*if($this->uri->segment(4) == '2') { echo "Location Updated Successfully"; } */?></div> -->
<?php
if(count($club_memberships) == 0)
{
	echo "Membership details are not added any!";
}
else if(count($club_memberships) > 0)
{
?>
<table class='table'>
<tr align='center'>
<td><b>Membership Code</b></td>
<td><b>Membership Type</b></td>
<td><b>Sport</b></td>
<td><b>Frequency</b></td>
<td><b>Fee</b></td>
<td><b>Activation Fee<br />(One Time)</b></td>
<td><b>Status</b></td>
<td><b></b></td>
</tr>

<?php 
foreach($club_memberships as $row){ 
?>
<tr align='center'>
<!-- <td><input type='checkbox' name='sel_loc_ids[]' id='sel_loc_<?//=$row->tab_id;?>' value='<?//=$row->tab_id;?>' /></td> -->
 <td><?php echo $row->Membership_ID; ?></td>
<td><?php echo $row->Membership_Type; ?></td>
<td><?php 
switch($row->Sport_Type){
	case '1':
		$sport_name = 'Tennis';
		break;
	case '2':
		$sport_name = 'Table Tennis';
		break;
	case '3':
		$sport_name = 'Badminton';
		break;
	case '4':
		$sport_name = 'Golf';
		break;
	case '5':
		$sport_name = 'Racquetball';
		break;
	case '6':
		$sport_name = 'Squash';
		break;
	case '7':
		$sport_name = 'Pickleball';
		break;
	case '18':
		$sport_name = 'Basketball';
		break;
	case '19':
		$sport_name = 'Handball';
		break;
	case '20':
		$sport_name = 'Paddleball';
		break;
	default:
		$sport_name = '';
		break;
 }

 echo $sport_name; ?></td>
<td><?php echo $row->Frequency; ?></td>
<td><?php echo number_format($row->Fee, 2); ?></td>
<td><?php echo number_format($row->ActivationFee, 2); ?></td>
<td><?php echo ($row->Status == 1) ? 'Active' : 'Inactive'; ?></a>
<td><input type='button' name='edit_membership' class='edit_membership' id='<?=$row->tab_id;?>' value=' Edit ' />
</td>
</tr>
<?php } ?>

</table>
<?php
 } ?> 

<?php
// if($this->logged_user == 237){
	?> 
 <!-- <tr align='center'><td>
 <form id='frm_download'  name='frm_download' method='POST' action='<?//=$this->config->item('club_form_url');?>/export/court_reservations'>
	 <input type='hidden' name='sel_locations' id='sel_locations' value='' />
	 <input type="submit" id="court_res_download" name="court_res_download"  value = " Download Reservations " class="btn submit-btn" style="margin:20px 0px" />
 </form>
 </td></tr> -->
<?php
//} 
	?>
	<br /><br /><br />
</div>	<!-- End of List the courts section-->
<!-- End of Main Body Section -->
</div>
<!-- </div> -->
</form>
<div id="dialog-confirm" title="Pricing">
  <!-- <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Do you want to apply this Pricing for all the Courts?</p> -->
</div>
</div><!--Close Top Match-->

<!-- ******************* JQuery Code Of Fee Section Starts Here *********************** -->
<script>
$(document).ready(function(){
	$("[name=is_discount]").click(function(){
		var dis = $(this).val();

		if(dis == 1){
			$('#discount_div').show();
		}
		else{
			$('#discount_div').hide();
		}
	});


	$("[name=court_fee]").click(function(){
		var radio_val = $(this).val();
		var fee_val = $("input[name='fee_per_hour[]']").map(function(){
			return $(this).val();}).get();

		var country_val = $('#country').val();

	/*	if(radio_val == 1 && fee_val == 0.00){
			alert('Payble amount sholud not be 0');	
			return false;
		}
	*/
	//	if(radio_val == 1 && fee_val != 0.00){
		if(radio_val == 1){
			if(country_val != 'India'){
				 $("#court_pay_select").hide();
				 $('#paypal_details').show();
				 $('#paypal_ids').show();
				 $('#addppids').show();
			}
			else {
				$("#court_pay_select").show();
				$('#paypal_details').hide();
			}
		}else{
//		alert('Payble amount sholud not be 0');	
		$('#court_fee_no').prop('checked',true);
		 $("#court_pay_select").hide();
		 $('#ppYesNo').hide();
		 $('#paypal_details').hide();
		 $('#paytm_details').hide(); 
		 $('#court_fee_paytype').val('');
		}
	});

	$("#court_fee_paytype").change(function(){
		var opt_val = $(this).val();
		if(opt_val == 'paypal'){
				$('#paypal_ids').show();
				$('#addppids').show();
			/*	$("input[name='pp']").trigger('click');
				$('#ppYes').prop('checked', true);*/
				$('#paypal_details').show();
				$('#paytm_details').hide();
				$('#ppYesNo').hide();
			}
			if(opt_val == 'paytm'){
				$('#paytm_ids').show();
				$('#addptmids').show();
			/*	$("input[name='petm']").trigger('click');
				$('#ptmYes').prop('checked', true);*/
				$('#paypal_details').hide();
				$('#paytm_details').show();
				$('#peTmYesNo').hide();
			}
			if(opt_val == ''){
				$('#paytm_details').hide();
				$('#paypal_details').hide();
			}
		
	});

	$("#addppids").click(function (){
		$('#paypal_ids').hide();
		$('#ppYesNo').show();
	});

	$("#addptmids").click(function (){
		$('#paytm_ids').hide();
		$('#peTmYesNo').show();
	});

	$('#country').change(function(){
		$('#court_fee_no').trigger('click');
	});
});
</script>

<!-- ********************** JQuery Code Of Fee Section Ends Here *********************** -->

<script>
	var i=0;

	$(document).ready(function(){

	//var i=0;
		//	$('.add_timings').click(function(){
		$(document).on('click', '.add_timings', function(){
			var btn_id = $(this).attr('id');
			//alert(btn_id);
			show_dialog('Do you want to apply this Pricing for all the Courts?', 'Yes', yes_apply, 'No', no_apply, btn_id);
		});
		
		$('#etime').change(function(){
			/*var valuestart = $("#stime").val();
			var valuestop = $("#etime").val();
			var timeStart = new Date("01/01/2007 " + valuestart).getHours();
			var timeEnd = new Date("01/01/2007 " + valuestop).getHours();
			var hourDiff = timeEnd - timeStart;  
			  if(hourDiff < 0){
				alert('End time must be greater than Start time.');
				$("#stime, #etime").val('');
				return false;
			  }else{ return true; }*/
		});

		$(document).on('click', '.add_addn_fee', function(){
			var id = $(this).attr('id');
			var x = id.split('_');
			if($(this).prop("checked") == true){
				$('.addn_fee_'+x[1]).prop( "disabled", false );
			}
			else{
				$('.addn_fee_'+x[1]).val('');
				$('.addn_fee_'+x[1]).prop( "disabled", true );
			}

		});
	});

	$(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id"); 
		   var rowCount = $('#timings_table tr').not('thead tr').length;
		   if(rowCount == 1 && button_id == 1){
			$('#show_timings').hide();
			$('#timings_table').hide();
		   }else{
           $('#row'+button_id).remove();  
           $('#addn_row'+button_id).remove();  
		   }
    });

	$(document).ready(function(){
		$('.addn_fee_all').prop('disabled', true);
	});

	/*$(document).on('click', '.add_timings', function(){
		var id = $(this).attr("id"); 
		//alert("Clicked Add Button ID Is :: "+id);
		//alert('#show_timings_'+id);
 		$('#show_timings_'+id).show();
	});*/
</script>