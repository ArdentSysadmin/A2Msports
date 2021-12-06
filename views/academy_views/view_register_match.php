<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php 		 /*echo "<pre>"; 
		print_r($_SERVER);
		echo "--------------------------------------------------------";
		print_r($GLOBALS); exit; */?>
<script>
function isValidDate(s) {
  var bits = s.split('/');
  var d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
  return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]));
}

//Test it!
//var currentDate = new Date('31/19/2011');
//console.log(isValidDate(currentDate.toString()));
//console.log(isValidDate('30/29/2011'));
$(document).ready(function(){

/*$('#custom_txt_dob').blur(function(){
	if(!isValidDate($(this).val())){
		alert("Invalid date format (" +$(this).val()+ "). It should be mm/dd/yyyy");
		$(this).val('');
	}
});*/

});


var club_baseurl = "<?php if($_SERVER['HTTP_X_FORWARDED_HOST']){ echo $_SERVER['HTTP_X_REQUEST_SCHEME'].'://'.$_SERVER['HTTP_X_FORWARDED_HOST']; } ?>";
//alert(club_baseurl);
$('#Singles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Doubles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Mixed_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');

/* ************************* JQuery Code For Coupon Code Starts Here. *********************************** */
    var is_event_time  = '<?php echo $r->Multi_Event_Time;?>';
    var is_event_limit  = '<?php echo $r->Event_Reg_Limit;?>';
	var tour_id				  = "<?php echo $tourn_id; ?>";

$(document).ready(function(){

	//reset all checkboxes to uncheck
	$("input:checkbox").removeAttr('checked');

	$("#apply_coup").click(function(){
		var coup_value = $("#coup_code").val();
		var coup_pattern = new RegExp('^[0-9A-Za-z\\-]+$');

		if(coup_value == ""){
			alert("Coupon Code required!");
			return false;
		}

		if(!(coup_pattern.test(coup_value))){
			alert("Invalid Code! Please check.");
			return false;
		}
	});

	$("#c_code").click(function(){
		$("#c_code_div").hide();
		$("#coupon_code_div").show();
	});

	$("#cancel_coup").click(function(){
		$('#coup_code').val('');
		$("#c_code_div").show();
		$("#coupon_code_div").hide();
		$('#coupon_code_status').hide();
	});

	$('#apply_coup').click(function(){
		var gc  = $('#coup_code').val();
		var tid = $('#id').val();
		//alert(gc);
		if(gc != ''){		
		$.ajax({		
			type:'POST',		
			url:club_baseurl+'/league/apply_gc/',		
			data:{gc:gc, tid:tid},		
			success:function(res){
				var x = res.split('#');
				var tot = x[0];
				var dis = x[1];
				var cid = x[2];
				if(tot > -1){
					$('#disc_amount').html(dis);		
					$('#tour_fee').val(tot);		
					$('#coup_code_id').val(cid);		
					$('#coup_disc').val(dis);		
					$('#coupon_code_div').hide();		
					$('#coupon_code_status').show();
					$('#cc_status').html("<b style='color:blue;'>Coupon Applied, Discount: $"+dis+"</b>");
				}
				else{
					$('#coupon_code_div').hide();		
					$('#coupon_code_status').show();
					$('#cc_status').html("<b style='color:red;'>Coupon is Expired/Invalid</b>");
					$("#coupon_code_div").show();
				}
			}	
		});
		}
	});

});

function upperCase(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}
/* ************************* JQuery Code For Coupon Code Ends Here. *********************************** */

function selectUser(val, id) {
$("#"+id).val(val);
}

    $.fn.myFunction = function(){ 
        alert('You have successfully defined the function!'); 
    }
    $(".call-btn").click(function(){
        $.fn.myFunction();
    });

$(document).ready(function(){

var baseurl = "<?php echo $this->config->item('club_form_url');?>";
var users = <?php echo $users; ?>;
		
$(".club_page").click(function () { //use change event
	if (this.value == "1") { //check value if it is domicilio
		$('#club').show(); //then show
		$('#club1').show();
	}
	else{
		$('#club').hide(); //else hide
		$('#club1').hide(); 
	}
});


$('.event_format, .tour_events_class').click(function(){
	var src = $(this).val();
	var dbl = 'Doubles';
	var mx  = 'Mixed';
	var lbl_text;
	
	if(!$(this).prop("checked")){
		$("#div_"+src).remove();
	}
	else if((src.indexOf(dbl) != -1) || (src.indexOf(mx) != -1)){
		if($('#partner_section').html() == ''){
			lbl_text = "<div id='lbl_partners'><label class='control-label col-md-4 padtop'><b>Select Partner</b></label><label class='col-md-8'>&nbsp;</label>";
			$('#partner_section').append(lbl_text);
		}

		var label = $(this).next('span').html();

		var html  = '<div id="div_'+src+'"><label class="control-label col-md-4 padtop"></label><input class="ui-autocomplete-input form-control test" style="width:55%" id="'+src+'" name="created_by" type="text" placeholder="'+label+' Partner Name (Optional)" value="" size="5" /><input class="ui-autocomplete-input form-control" id="created_users_'+src+'" name="partners['+src+']" type="hidden" value="" size="5" /></div>';
		
		$('#partner_section').append(html);

		$('#'+src).autocomplete({
			source:users,
			minLength:0,
			select: function(event, ui){ 
				//alert(ui.item.label + ": " + ui.item.value + ": " + ui.item.value2);
				$('#created_users_'+src).val(ui.item.value2);
			}
		});
	}
});
	      	
});

$(document).ready(function(){
var baseurl = "<?php echo $this->config->item('club_form_url');?>";
		
	$('#hc_loc').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: club_baseurl+'/league/autocomplete_hloc',
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
  	select: function( event, ui ){
		var names = ui.item.data.split("|");						
		$('#hc_loc_id').val(names[1]);
	}		      	
	});

	$('#hc_loc').bind('blur', function(){
		 
		var loc_title = $(this).val();
		var loc_id	  = $('#hc_loc_id').val();
		//alert(loc_id);
		if(loc_title == "" || loc_id ==""){
			$('#hc_loc_id').val("");
			$(this).val("");
			alert("Invalid Home Court Location!");
		}
	});

});

</script>

<script>
$(document).ready(function(){

$('#myform').submit(function(){
	//alert('test');
    var tournament_format = '<?php echo $r->tournament_format;?>';
    
	if(tournament_format == 'Individual'){
		
	    var event_reg_fee = '<?php echo $r->Event_Reg_Fee;?>';
	    var cnt_checkbxes = $("#cnt_checkbxes").val();

	    if(cnt_checkbxes > 0){

	        if(event_reg_fee == ""){
			  	var count = $('.tour_events_class:checked').length;
			 
			    if(count == 0){
			        alert('Choose atleast one Event to Register!');
			        return false;
			    }
				else{
			  	    return true;
			    }  
		
		    }
			else{
		    	
			    var count = $('.event_format:checked').length;
			    
			    if (count == 0) {
			        alert('Choose atleast one Event to Register!');
			        return false;
			    }
				else{
			  	    return true;
			    }
		    }
	    }
		else{
	    	alert("You Don't have any eligible events to register!");
	    	return false;
	    }
	   
	}

	if(tournament_format == 'Teams'){
		return true;
	}
});

$('#team').change(function(){		
var baseurl  = "<?php echo $this->config->item('club_form_url');?>";		
var team_id	 = $(this).val();		
var tourn_id = $('#id').val();		
	if(team_id != ''){		
	$.ajax({		
		type:'POST',		
		url:club_baseurl+'/teams/get_team/',		
		data:{team_id:team_id, tourn_id:tourn_id},		
		success:function(res){		
			if(res){	
			$('#sel_team_players').html(res);		
			$('#sel_team_players').show();	
			}
		}		
	});		
	}		
	else{		
			$('#sel_team_players').html('');		
			$('#sel_team_players').hide();		
	}		
});		

$('#upd_membership').click(function(){		
var baseurl		   = "<?php echo $this->config->item('club_form_url');?>";
var ipt_membership = $('#input_usatt_member_id').val();
var tourn_id	   = $('#id').val();
var txt_red	       = '-1';

	if(ipt_membership != ''){
	$.ajax({
		type:'POST',
		url:club_baseurl+'/league/user_usatt_update/',
		data:{txt_tid:tourn_id,txt_red:txt_red,usatt_member_id:ipt_membership},
		success:function(res){		
			if(res){
			location.reload();
			}
		}
	});
	}	
	else{		
	$('#input_usatt_member_id').attr("placeholder", "Enter Membership ID");
	}		
});	

$('#btn_location').click(function(){

var baseurl = "<?php echo $this->config->item('club_form_url');?>";
var Title	= $("#loc_title").val();

if(Title != ""){
var Add		= $("#loc_add").val();
var City	= $("#loc_city").val();
var State	= $("#loc_state").val();
var Country = $("#loc_country").val();
var Zip		= $("#loc_zipcode").val();

$.ajax({
		type:'POST',
		url:club_baseurl+'/league/homeloc_add/',
		data:{title:Title, add:Add, city:City, state:State, country:Country, zip:Zip},
		success:function(res){
			$('#loc_form').each(function(){
			this.reset();
			});
			$('#location_form').hide();
			$('.loc_section').show();
		}
});
}
else {

alert("Location Name should not be empty!");

}

});

$('.is_captain').click(function(){
	var a = $(this).val();
	if(a == '1'){
		$('#inst').hide();
		$('#myform').show();
	}
	else{
		$('#inst').show();
		$('#myform').hide();
	}
});

var formats = [];
var events = [];

	$('.format').click(function(){
		var ft = $(this).attr('id');
		$('#'+ft+'_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
		$('#'+ft+'_levels_div').toggle(); 
		$('#div_event_section').html('');
	});
 
    $(".sel_opt").click( function () {
            if(this.checked) {

                var level = $(this).val();
				    events.push(level);
		    }else{
				var level = $(this).val();
                var index = events.indexOf(level);
			    if (index > -1) {
					events.splice(index, 1);
			    }
		    }

		    getevents(events);
		       	
		   // alert(events);           
    });  
    $('.not_eligible_evnts').click(function(){
    $('.hider').toggle();
    if ( $(".hider").css('display') == 'block' ){
     $('#change_icon').html('Not Eligible ( - )');
    }else{
     $('#change_icon').html('Not Eligible ( + )');
    }
    
   });  

$(".team_ag").click(function(){
	var baseurl = "<?php echo $this->config->item('club_form_url');?>";
	var ag_grp  = $(this).val();

	$.ajax({
		type:'POST',
		url:club_baseurl+'/league/get_team_reg_fee/',
		data:{tour_id:tour_id, ag_grp:ag_grp},
		success:function(html){
		 $('#tour_fee').val(html);
		}
	}); 

});
});
function getEventTime(events,classname,ag_grp,format){

if(is_event_time){

    var eventtext="";
	var tourn_id = $('#id').val();	
	var is_flag_age = $('#is_flag_age').val();
	var user_age_grp = $('#user_age_grp').val();
	//alert(user_age);die();
	var evnts=[];

	$.ajax({		
		type:'POST',		
		url:club_baseurl+'/league/getEventTime/',		
		data:{tourn_id:tourn_id,events:events},		
		success:function(event_timejsn){	
         // console.log(event_timejsn);die();
		var event_time = JSON.parse(event_timejsn);	
			                         	
                $("[name='events[]']:checked").each(function() {
                    var evnt = $(this).val();
                  if(event_time.length!=0){    
                    jQuery.each( event_time, function( i, time ) {
                    	//alert(i);
                        if(evnt==i){
                           $("[name='events[]'][value='"+i+"']").prop("checked", false); 
                            //events.pop(i);         
							events = jQuery.grep(events, function(value) {
							return value != i;
							
							});
							evnts.push(i);
                        }
 
            	    });

            	    }
             
	  	       });
               
                if(evnts.length!=0){
                   alert("Selected Events Start Time should not be same! Select anyone of the following!");
                }

              
  
		}
      

	});
	
	
}
                ag_grp = [];
                format = [];
                for (i = 0; i < events.length; i++) { 
                    $sp = events[i].split('-');
	                ag_grp.push($sp[0]);
	                if($sp[2]=="Singles"){
			          format.push('Singles');
			        }
			        if($sp[2]=="Doubles"){
			          format.push('Doubles');	      
			        }
			        if($sp[2]=="Mixed"){
			          format.push('Mixed');	  
			        }
			               
		        }
               getevents(events,classname,ag_grp,format);
}

function getfee(events,classname,ag_grp,format){
	var tourn_id = $('#id').val();	
	var is_flag_age = $('#is_flag_age').val();
	var user_age_grp = $('#user_age_grp').val();
	var coupon_code  = $('#coup_code').val();

	if(format.indexOf('Doubles')!=-1){
		            $('#doubles_div').css('display', 'block'); 
				}else{
                    $('#doubles_div').css('display', 'none'); 
				}
				if(format.indexOf('Mixed')!=-1){
		            $('#mixed_div').css('display', 'block'); 
				}else{
                    $('#mixed_div').css('display', 'none'); 
				}
			
                if(classname=='event_format'){
                    $.ajax({
						type:'POST',
						url:club_baseurl+'/league/get_event_fee/',
						data:{ tour_id:tourn_id, events:events, coupon:coupon_code},
						success:function(html){
							var res = html.split('#');
						  $('#tour_fee').val(res[0]);
						  $('#reg_submit').prop("disabled", false);
						  $('#reg_submit').attr('value', 'Register');
						 if(res[1] > 0){
							 $('#coupon_code_div').hide();		
							 $('#coupon_code_status').show();
							 $('#cc_status').html("<b style='color:blue;'>Coupon Applied, Discount: $"+res[1]+"</b>");
						 }
						}
		            }); 
                }

                else if(classname=='tour_events_class'){
                    $.ajax({
						type:'POST',
						url:club_baseurl+'/league/get_tour_fee',
				        data:{ tour_id:tour_id, ag_grp:ag_grp, format:format, is_flag_age:is_flag_age, user_age_grp:user_age_grp, coupon:coupon_code },
						success:function(html){
							//alert(html);
							var res = html.split('#');
						  $('#tour_fee').val(res[0]);
						  $('#reg_submit').prop("disabled", false);
						  $('#reg_submit').attr('value', 'Register');
						 
						 if(res[1] > 0){
							 $('#coupon_code_div').hide();		
							 $('#coupon_code_status').show();
							 $('#cc_status').html("<b style='color:blue;'>Coupon Applied, Discount: $"+res[1]+"</b>");
						 }
						}
		            }); 
                }

}
function getevents(events,classname,ag_grp,format){

if(is_event_limit){
	var eventtext="";
	var tourn_id = $('#id').val();	
	$.ajax({		
		type:'POST',		
		url:club_baseurl+'/league/get_tour_details/',		
		data:{tourn_id:tourn_id,events:events},		
		success:function(event_limitsjsn){		
			//console.log(event_limitsjsn);
			var event_limits = JSON.parse(event_limitsjsn);
			if(event_limits.length!=0){
               eventtext+='<label class="control-label col-md-3" for="id_accomodation"><b>Selected Events</b></label><div class="col-md-8 form-group internal text1"><table class="tab-score" style="padding:1px;">';
			
			
			jQuery.each( event_limits, function( i, limit ) {
                eventtext+='<tr><td>&nbsp;'+i+'</td><td align="center">'+limit+'</td></tr>';
		  	  });
			eventtext+='</table>';
			}
			$("#div_event_section").html(eventtext);
			//alert(events);
			
               	
                

            // alert(events);
			//return events;
			
		}		
	});
	
	        /* jQuery.each( events, function( i, evnt ) {
                eventtext+='<label class="control-label col-md-3" for="id_accomodation">'+evnt+'</label>';
		  	  });*/

		  //	$("#div_event_section").html(eventtext);
}
	 getfee(events,classname,ag_grp,format);
}
</script>


<script type="text/javascript">
$(function () {
 $(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
        e.preventDefault();
    });
$("input[name='chkPassPort']").click(function () {
if ($("#chkYes").is(":checked")) {
$("#dvPassport").show();
} else {
$("#dvPassport").hide();
}
});
});
</script>


<?php $fee = number_format($r->TournamentAmount); ?>
<?php $extra_fee = number_format($r->extrafee); ?>
<?php 	
$sum = $fee + $extra_fee;
?>
<script type="text/javascript">
$(document).ready(function(){

var fee = "<?php echo $fee; ?>";
var sum = "<?php echo $sum; ?>";

$(".event_format").click(function(){

		 var isReadOnly = $(this).attr("readonly") === undefined ? false : true;

    if (isReadOnly) {
        alert("You are not eligible for this event!");
    }else{
		$('#reg_submit').prop("disabled", true);
		$('#reg_submit').attr('value', 'Please wait...');

    	var events = [];
    	var evnts  = [];
    	var format = [];
           baseurl	   = "<?php echo $this->config->item('club_form_url'); ?>";
          // tour_id	   = "<?php echo $this->uri->segment(3); ?>";

		$('input[class=event_format]:checked').each(function(){
			$val = $(this).val();
			events.push($val);	

			$sp = $val.split('-');

	        if($sp[2]=="Singles"){
	          format.push('Singles');
	        }
	        if($sp[2]=="Doubles"){
	          format.push('Doubles');	      
	        }
	        if($sp[2]=="Mixed"){
	          format.push('Mixed');	  
	        }    
		});
		getEventTime(events,'event_format','',format); 
       // alert(evnts);
       // 
		
    }

});

$(".tour_events_class").click(function(){
    var isReadOnly = $(this).attr("readonly") === undefined ? false : true;

    if (isReadOnly) {
        alert("You are not eligible for this event!");
    }else{
		$('#reg_submit').prop("disabled", true);
		$('#reg_submit').attr('value', 'Please wait...');

    	var events = [];
    	var evnts  = [];
    	var ag_grp = [];
    	var format = [];
           baseurl	   = "<?php echo $this->config->item('club_form_url'); ?>";
           //tour_id	   = "<?php echo $this->uri->segment(3); ?>";

		$('input[class=tour_events_class]:checked').each(function(){
			$val = $(this).val();
	        $sp = $val.split('-');
	        $formatkey = $sp[2];	
            $event = $sp[0]+'-'+$sp[1]+'-'+$sp[2]+'-'+$sp[3];
			//events.push($event);	
			//alert($val);
			events.push($val);	
	        ag_grp.push($sp[0]);
	        if($formatkey=="Singles"){
	          format.push('Singles');
	        }
	        if($formatkey=="Doubles"){
	          format.push('Doubles');	      
	        }
	        if($formatkey=="Mixed"){
	          format.push('Mixed');	  
	        }
		});

        getEventTime(events,'tour_events_class',ag_grp,format);
		
    }

});

$(".format").click(function(){

	if($('#Doubles:checkbox:checked').length > 0){
		$('#doubles_div').css('display', 'block');
	}
	else{
		$('#doubles_div').css('display', 'none');
	}

	if($('#Mixed:checkbox:checked').length > 0){
		$('#mixed_div').css('display', 'block');
	}
	else{
		$('#mixed_div').css('display', 'none');
	}
});

$(".format, .sel_opt").click(function(){

$format = [];

if($('#Singles:checkbox:checked').length > 0){
	$format.push('Singles');
}

if($('#Doubles:checkbox:checked').length > 0){
	$format.push('Doubles');
}

if($('#Mixed:checkbox:checked').length > 0){
	$format.push('Mixed');
}

baseurl	  = "<?php echo $this->config->item('club_form_url'); ?>";
//tour_id	  = "<?php echo $this->uri->segment(3); ?>";

$ag_grp = [];

$('input[class=sel_opt]:checked').each(function(){
	$val = $(this).val();
	$sp = $val.split('_');
	$ag_grp.push($sp[1]);
});

$.ajax({
	type:'POST',
	url:club_baseurl+'/league/get_tour_fee',
	data:{ tour_id:tour_id, ag_grp:$ag_grp, format:$format},
	success:function(html){
	 $('#tour_fee').val(html);
	}
}); 


});
});
</script>


<!-- -----------------Terms and conditions--------------------- -->
<script language="javascript" type="text/javascript">

function terms_conditions()
{
var path = "<?php echo base_url(); ?>";
var left  = ($(window).width()/2)-(725/2),
	top   = ($(window).height()/2)-(600/2),
	popup = window.open (path+'terms_conditions/', "popup", "width=725,scrollbars=1,height=600, top="+top+", left="+left);

   // window.open(path+'league/terms_conditions/',null,"height=650,width=700,status=yes,toolbar=no,menubar=no,location=no, top="+top+", left="+left");
}

function medical_form()
{
var path = "<?php echo base_url(); ?>";
var left  = ($(window).width()/2)-(725/2),
	top   = ($(window).height()/2)-(600/2),
	popup = window.open(path+'medical_form/', "popup", "width=725, scrollbars=1,height=600, top="+top+", left="+left);

   // window.open(path+'league/terms_conditions/',null,"height=650,width=700,status=yes,toolbar=no,menubar=no,location=no, top="+top+", left="+left");
}

</script>
<!-- -----------------end of Terms and conditions--------------------- -->

<script>
function GetRating() {
		var usatt_member_id = document.getElementById("usatt_member_id").value;
	}
</script>
<?php 
  $user_id = $this->logged_user; 
?>
<div class="container">
<div class="row">

<section id="single_player" class="secondary-page">
<div class="col-md-9">

<!-- start main body --> 
<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Register for <?php echo $r->tournament_title; ?></div>

<?php if($this->session->userdata('user')=="") { 
$cur_uri = array('redirect_to'=>$_SERVER['REQUEST_URI']);
$this->session->set_userdata($cur_uri);
?>
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo $this->config->item('club_form_url')."login"; ?>'><b>Login</b> </a>to register for a tournament</p>
<?php  } ?>
<?php if($this->session->userdata('user')!="") { ?>
<?php 
if(isset($reg_status)) { ?>
	<div class="name" align='left'>
	<label for="name_login" style="color:green"><?php echo $reg_status; ?></label>
	</div>
<?php
}
else
{
		$is_usatt_sanctioned = 0;
	//$is_valid_usatt_membership = 1;

	if($r->Is_USATT_Approved)
		$is_usatt_sanctioned = 1;

	$check_user_usatt_membership = league::is_logged_user_having_memeberhip($r->SportsType);
//echo $ugender; exit;
	if(!$udob or !$uaddr or !$uemail or !$ugender or !$umob){
?>
<form class="form-horizontal" id='myform_dob' method='post' role="form"  action="<?php echo $this->config->item('club_form_url'); ?>/league/uprofile">
<div class='col-md-8'>

	<div class='form-group'>
	<label class='col-md-12 form-group internal' for='id_accomodation' style='font-size: 12px;'><b style='color:red'>Note: </b>
	<?php echo "We found that some required information is missing in your profile. Please update the information and proceed to registration. Thankyou"; ?></label>
	</div>

	<?php if(!$udob) { ?>
	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Date of Birth:</label>
	<div class='col-md-8 form-group internal text1'>
		<div class='input-group date'>
		<!-- <input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_txt_dob" name="txt_dob" maxlength="10" required /> 
		<span class="input-group-addon custom_datepicker" id='txt_dob' style="cursor:pointer;">
			<span class="fa fa-calendar"></span> 
		</span> -->
		<input type="date" class='form-control' placeholder="MM/DD/YYYY" id="custom_txt_dob" name="txt_dob"  max="<?php echo date('Y-m-d', strtotime('-3 years')); ?>" required />
		</div>
	</div>
	</div>
	<?php }
	if(!$ugender) { ?>
	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Gender:</label>
	<div class='col-md-8 form-group internal text1'>
		<div class='input-group date'>
		<select class='form-control' id='gender' name='txt_gender' required>
		<option value="">Select</option>
		<option value="1">Male</option>
		<option value="0">Female</option>
		</select>
		</div>
	</div>
	</div>
	<?php }
	if(!$uemail) { ?>
	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Email:</label>
	<div class='col-md-8 form-group internal text1'>
	<input class='form-control' id="txt_email" type="text" name="txt_email" value="" required />
	</div>
	</div>
	<?php }
	if(!$umob) { ?>
	<div class='form-group'>
	<label class='control-label col-md-3 padtop' for='id_accomodation'>Mobile #:</label>
	<div class='col-md-8 form-group internal text1'>
	<input class='form-control' id="txt_mob" type="text" name="txt_mob" value="" required />
	</div>
	</div>
	<?php }
	if(!$uaddr) { ?>
	<!-- Gather address info. if not available -->

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Address Line1 </label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='addr1' name='UserAddressline1' type='text' style="width:80%" value="<?php if($user_info->UserAddressline1){ echo $user_info->UserAddressline1; }?>" required>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='addr2' name='UserAddressline2' type='text' style="width:80%" value="<?php if($user_info->UserAddressline2){ echo $user_info->UserAddressline2; }?>">
	</div>
	</div>

	<div class='form-group'>

	<label class='control-label col-md-3' for='id_accomodation'>Country</label>
	<div class='col-md-6 form-group internal'>
	<select class='form-control' id='country' name='CountryName' required>
	<option value="">Select</option>
	<?php
	$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

	foreach($countries as $country)
	{
	($country==$user_info->Country) ? $sel = "selected='selected'" : $sel = "";
	echo "<option value='$country' $sel>$country</option>";
	}
	?>
	</select>

	</div>
	</div>

	<div class='form-group' id='state_box' style='<?php if($user_info->Country=="United States of America") { echo "display:none;"; } ?>'>
	<label class='control-label col-md-3' for='id_accomodation'> State</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='state1' name='StateName1' type='text' style="width:45%" value="<?php if($user_info->State){ echo $user_info->State; }?>">
	</div>
	</div>

	<div class='form-group' id="state_drop" style='<?php if($user_info->Country!="United States of America") { echo "display:none;"; } ?>'>
	<label class='control-label col-md-3' for='id_title'>State</label>
	<div class='col-md-4 form-group internal'>
	<select name="StateName" id="state" class='form-control' onChange="stateChange();">
	<option value="">Select</option>
	<?php
	$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
	'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
	'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
	'Wisconsin','Wyoming'); 


	foreach($states as $state)
	{
	($state==$user_info->State) ? $sel_state = "selected='selected'" : $sel_state = "";

	echo "<option value='$state' $sel_state>$state</option>";
	}
	?>
	</select>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'> City</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='city' name='CityName' type='text' style="width:45%" value="<?php if($user_info->City){ echo $user_info->City; }?>" />
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Postal Code</label>
	<div class='col-md-8 form-group internal'>
	<input class='form-control' id='zipcode' name='zipcode' type='text' style="width:45%" value="<?php if($user_info->Zipcode){ echo $user_info->Zipcode; }?>" />
	</div>
	</div>
	
	<!-- End of address info. -->
	<?php } ?>
<input class='form-control' id="txt_tid" type="hidden" name="txt_tid" value="<?php echo $r->tournament_ID; ?>" required />
<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'></label>
	<div class='col-md-7 form-group internal'>
	<input name="btn_udob" type="submit" value="Update" class="league-form-submit"/>
	</div>
</div>

</form>	

<?php	
	}
	else if($is_usatt_sanctioned and !$check_user_usatt_membership){
?>
<form class="form-horizontal" id='myform_dob' method='post' role="form"  action="<?php echo $this->config->item('club_form_url'); ?>/league/user_usatt_update">
<div class='col-md-8'>

	<div class='form-group'><label class='col-md-12 form-group internal' for='id_accomodation' style='font-size: 12px;'><b style='color:red'>Note: </b>
	<?php echo "We require your USATT rating for this league. Please update the information and proceed to registration. Thankyou"; ?></label></div>
	<div id="club">				
		<div class="form-group">
			<label class='control-label col-md-4 padtop' for="email"><b>USATT Membership ID</b></label>
			<div class='col-md-8 form-group internal text1'>
			<input id="usatt_member_id" name="usatt_member_id" class="form-control" type="text" style="width:70%"/>
			</div>
		</div>
	</div>
<input class='form-control' id="txt_tid" type="hidden" name="txt_tid" value="<?php echo $r->tournament_ID; ?>" />
<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'></label>
	<div class='col-md-7 form-group internal'>
	<input name="btn_udob" type="submit" value="Update" class="league-form-submit"/>
	</div>
</div>

</form>	
<?php
	}
	else
	{
		$block_status = "style='display:block;'";
		if($r->tournament_format == 'Teams' or $r->tournament_format == 'TeamSport'){
					$block_status = "style='display:none;'";
?>
<!-- <form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url(); ?>league/register_trnmt"> -->
<script>
$(document).ready(function(){
	$('#div_is_captain').hide();
	$('#is_captain_yes').trigger('click');
});
</script>
<div class='col-md-9' id='div_is_captain' style='display:none;'>
	<div class='form-group'>
	<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Are you a Team Captain ?</b></label>
		<div class='col-md-6 form-group internal text1'>
			<input type='radio' class='is_captain' name='is_captain' id='is_captain_yes' value='1' /> Yes 
			<input type='radio' class='is_captain' name='is_captain' id='is_captain_no' value='0' /> No
		</div>
	</div>
</div>
<?php
} ?>
<div class='col-md-12' id='inst' style='display:none;'>		
<div class='form-group'><label class='control-label col-md-8 padtop' for='id_accomodation'>&nbsp;</label></div>
<div class='form-group'>
<label class='control-label col-md-8 padtop' for='id_accomodation'>Only Team Captains can register for Team Leagues. To find partipating teams and to join them <a href="<?=$this->config->item('club_form_url');?>teams">Click Here</a></label>
</div>

</div>
<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo $this->config->item('club_form_url'); ?>/league/buy/<?php echo $r->tournament_ID;?>" <?=$block_status;?>>
 
<div class='col-md-8'>
	
<input type="hidden" id="id" name="id" value="<?php echo $r->tournament_ID; ?>"/> 

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Tournament</b></label>
<div class='col-md-6 form-group internal text1'>
<?php echo $r->tournament_title; ?>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Period </b></label>
<div class='col-md-6 form-group internal text1'>
<?php echo date('m/d/Y',strtotime(substr($r->StartDate,0,10))); ?> - <?php echo date('m/d/Y',strtotime(substr($r->EndDate,0,10))); ?>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Sport</b></label>
<div class='col-md-6 form-group internal text1'>
<?php 
$get_sport = league::get_sport($r->SportsType);
echo $get_sport['Sportname'];
?>
</div>
</div>
<?php
//$check_user_usatt_membership = league::is_logged_user_having_memeberhip($r->SportsType);

 $get_user_mem_details  = league::get_user_mem_details($user_id, $r->SportsType);
 $get_user_usatt_rating = league::get_user_usatt_rating($get_user_mem_details['Membership_ID']);
 //print_r($get_user_usatt_rating);
 
 $rating = 0;
    if($get_user_usatt_rating['Rating']){ 
		$rating = $get_user_usatt_rating['Rating']; 
	}
//echo 'rat'.$rating; exit;
if($r->SportsType == '2' and !$check_user_usatt_membership){
?>
	<div class="form-group">
         <label class='control-label col-md-4 padtop' for=""> <b>Do you have USATT Membership?</b></label>
		 <!--<div class="clear"></div>-->
		 <div class='col-md-6 form-group internal text1'>
         <input name="club_page" class="club_page" type="radio" value="1" style="margin-bottom:22px"> Yes  
		 <input name="club_page" class="club_page" type="radio" value="0" checked> No  
		 </div>
    </div>
						
	<div id="club" style="display:none">				
		<div class="form-group">
			<label class='control-label col-md-4 padtop' for="email"><b>MemberShip ID</b></label>
			<div class='col-md-4 form-group internal text1'>
			<input id="input_usatt_member_id" name="input_usatt_member_id" class="form-control" type="text" />
			</div>
			<div class='col-md-3 form-group internal text1'>
			<input name="upd_membership" id="upd_membership" type="button" value="Update" class="league-form-submit1"/>
			</div>

		</div>
	</div>
<?php
}

if($r->SportsType == '2' and $check_user_usatt_membership){
?>
<div class="form-group">
 <label class='control-label col-md-4 padtop' for=""> <b>USATT Membership ID</b></label>
 <!--<div class="clear"></div>-->
 <div class='col-md-6 form-group internal text1'>
<?php 
   echo $get_user_mem_details['Membership_ID'];
?>
 </div>
</div>
					
<div class="form-group">
<label class='control-label col-md-4 padtop' for="email"><b>Rating</b></label>
<div class='col-md-6 form-group internal text1'>
<?php 
if($rating)
  echo $rating;
else
	echo "<span style='color:red'>Your USATT membership info is not matching our database. Please update your <a href='".$this->config->item('club_form_url')."profile'> Profile </a> so you can register for USATT rated events.</span>";
 /* echo "<span style='color:red'>We couldn't find your rating with provided Membership ID <b>{$get_user_mem_details['Membership_ID']}</b> <br>Please update your profile with USATT ID and try to register again. If you still have issues, please contact your Tournament/ League Director</span>";*/
?>
</div>
</div>
<?php
}
$option_array = array();
if($r->Age != "")
{
$option_array = json_decode($r->Age);
$age_grp_list = array();
$numItems     = count($option_array);
$i = 0;
	if($numItems > 0)
	{
		foreach($option_array as $group){
			switch ($group){
			case "U9":
			$age_grp_list['U9'] = "Under 9";
			break;
			case "U10":
			$age_grp_list['U10'] = "Under 10";
			break;
			case "U11":
			$age_grp_list['U11'] = "Under 11";
			break;
			case "U12":
			$age_grp_list['U12'] = "Under 12";
			break;
			case "U13":
			$age_grp_list['U13'] = "Under 13";
			break;
			case "U14":
			$age_grp_list['U14'] = "Under 14";
			break;
			case "U15":
			$age_grp_list['U15'] = "Under 15";
			break;
			case "U16":
			$age_grp_list['U16'] = "Under 16";
			break;
			case "U17":
			$age_grp_list['U17'] = "Under 17";
			break;
			case "U18":
			$age_grp_list['U18'] = "Under 18";
			break;
			case "U19":
			$age_grp_list['U19'] = "Under 19";
			break;
			case "Adults":
			$age_grp_list['Adults'] = "Adults";
			break;
			case "Adults_30p":
			$age_grp_list['Adults_30p'] = "30s";
			break;
			case "Adults_40p":
			$age_grp_list['Adults_40p'] = "40s";
			break;
			case "Adults_50p":
			$age_grp_list['Adults_50p'] = "50s";
			break;
			case "Adults_veteran":
			$age_grp_list['Adults_veteran'] = "Veteran";
			break;
			case "Junior":
			$age_grp_list['Junior'] = "Junior";
			break;
			case "Senior":
			$age_grp_list['Senior'] = "Senior";
			break;
			default:
			$age_grp_list[] = "";
			}
		}
	}

}
?>

<?php
    $gender = $r->Gender;

	if($gender == 0){

	   $gender_symbol = "Women";

	}elseif($gender == 1){

	   $gender_symbol = "Men";

	}else{

	   $gender_symbol = "All";
	}

$json_array = array();

if($r->tournament_format == "Individual"){

$json_array = json_decode($r->Singleordouble);
$numItems   = count($json_array);

$i = 0;
	if($numItems > 0)
	{
		$age_class   = "";
		$user_gender = $user_age_dat['Gender'];
		$user_dob    = $user_age_dat['DOB'];
		$birthdate	 = new DateTime($user_dob);
		$today		 = new DateTime('today');
		$user_age    = $birthdate->diff($today)->y;
		$db_age      = json_decode($r->Age);

        switch (true) {
                case $user_age <= 9:
                   $user_age_grp = "U9";
                   break;
                case $user_age <= 10:
                   $user_age_grp = "U10";
                   break;
                case $user_age == 11:
                   $user_age_grp = "U11";
                   break;
                case $user_age == 12:
                   $user_age_grp = "U12";
                   break;
                case $user_age == 13:
                   $user_age_grp = "U13";
                   break;
                case $user_age == 14:
                   $user_age_grp = "U14";
                   break;
                case $user_age == 15:
                   $user_age_grp = "U15";
                   break;
                case $user_age == 16:
	               $user_age_grp = "U16";
	               break;
                case $user_age == 17:
                   $user_age_grp = "U17";
                   break;
                case $user_age == 18:
                   $user_age_grp = "U18";
                   break;
                case $user_age == 19:
                   $user_age_grp = "U19";
                   break;
                case $user_age>19 && $user_age<=29:
                   $user_age_grp = "Adults";
                   break;
                case $user_age>=30 && $user_age<=39:
                   $user_age_grp = "Adults_30p";
                   break;
                case $user_age>=40 && $user_age<=49:
                   $user_age_grp = "Adults_40p";
                   break;
                case $user_age>=50 && $user_age<=60:
                   $user_age_grp = "Adults_50p";
                   break;
        }

		if(in_array($user_age_grp, $db_age)){
		   //$is_flag_age=1;
		   $is_flag_age=0;
		}else{
		   $is_flag_age=0;
		}


    $event_format = array();

	if($r->Event_Reg_Fee!=NULL){
	    $fee_class = "event_format";
	}
	else{
		$fee_class = "tour_events_class";
	}

    if($r->Multi_Events != NULL){

       $multi_events = json_decode($r->Multi_Events);

    }else{

       $events       = league::GetTournamentEvents($r);
       $multi_events = league::array_flatten($events);	 
    }
	 $event_format = league::regenerate_events($multi_events);
//if($this->logged_user == 240){
//echo "<pre>"; print_r($event_format); exit;
//}
	$eligible_events = array();
    $not_eligible_events = array();
    $gender_eligible_events = array();
	//echo $age_class;
	    echo "<div class='form-group'>";
	    echo "<label class='control-label col-md-4 padtop' for='id_accomodation'>";
		
		echo "<b>* Eligible Events</b>";
		
		echo "</label>";
		echo "<div class='col-md-8 form-group internal text1'><table style='padding:1px; font-family:Open Sans, sans-serif; font-size:14px;'>";
		//echo "<pre>";
		//print_r();
		foreach ($event_format as $event => $event1) {
			
  	    $eventsarr  = explode('-', $event); 
        $ag         = $eventsarr[0];
     	$genderkey  = $eventsarr[1];
     	$format     = $eventsarr[2];
	  	//$level_num  = $eventsarr[3];
		if($eventsarr[3]){
		$level_num = $eventsarr[3];
		}
		else{
		$level_num = $eventsarr[2];
		}
	  
        	//echo $gender;
	  	    if($genderkey == 0){
              if($user_gender == 1){
	            if($format == 'Singles' || $format == 'Doubles'){
	                $not_eligible_events['gender-'.$event] = $event1;
	            }
	            else{
	             	$gender_eligible_events[$event] = $event1;
	            }
            }
            else{
           	    $gender_eligible_events[$event] = $event1;
            }
	  	    }else if($genderkey==1){
	  	    	if($user_gender == 0){
	            if($format == 'Singles' || $format == 'Doubles'){
	                $not_eligible_events['gender-'.$event] = $event1;
	            }
	            else{
	             	$gender_eligible_events[$event] = $event1;
	            }
            }
            else{
           	    $gender_eligible_events[$event] = $event1;
            }

	  	    }
			else if($genderkey==2){
                $gender_eligible_events[$event] = $event1;
	  	    }
			else if($genderkey == 'Open'){
                $gender_eligible_events[$event] = $event1;
	  	    }
			else if($ag == 'Open'){
                $gender_eligible_events[$event] = $event1;
	  	    }
		}

     // echo $ag_grp;exit();
//echo $ag_grp;
      foreach ($gender_eligible_events as $event => $event1) {
	            $eventsarr = explode('-', $event);
				if($eventsarr[3]){
		  		$level_num = $eventsarr[3];
				}
				else{
		  		$level_num = $eventsarr[2];
				}

	            $ages      = $eventsarr[0];
		  		$level_name_arry = league::get_level_name('',$level_num);
	            $LevelName       = $level_name_arry['SportsLevel'];
		  		$agegroup = $ages;
      
        if($ag_grp == 'Adults'){  

				if($agegroup == 'U9' or $agegroup == 'U10' or $agegroup == 'U11' or $agegroup == 'U12' or $agegroup == 'U13' or $agegroup == 'U14' or $agegroup == 'U15' or $agegroup == 'U16' or $agegroup == 'U17' or $agegroup == 'U18' or $agegroup == 'U19' or $agegroup == 'Junior'){
			          $not_eligible_events['age-'.$event] = $event1;
			    }
				else if(strpos($agegroup, '_') !== false){
					$age = preg_replace('/\D/', '', $agegroup);
					
			    	if($age==40 && ($user_age>=40 && $user_age<50)){
		                if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);

					    if(is_numeric($level_name)){
			 	            if($level_name <= $rating or $rating == 0){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					        }
							else{
					        	$eligible_events[$event]=$event1;	
					        }
					    }
						else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }
					else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else if($age==50 && $user_age>=50){
                        if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
							if(is_numeric($level_name) or $rating == 0){
								if($level_name < $rating){
									$not_eligible_events['rating-'.$event]=$event1;
								}
								else{
									$eligible_events[$event]=$event1;
								}
							}
							else{
								$eligible_events[$event]=$event1;
							}
		  				}
						else{
						   $eligible_events[$event]=$event1;
						}
		            }
					else{
				          $not_eligible_events['age-'.$event] = $event1;
				    }
                 }
				 else if($agegroup == 'Open'){
					$eligible_events[$event] = $event1;
				 }
				 else{
			    	if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name <= $rating or $rating == 0){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					        }
							else{
					        	$eligible_events[$event] = $event1;
					        }
					    }
						else{
					    	$eligible_events[$event] = $event1;
					    }
		  	        }
					else{
					   $eligible_events[$event] = $event1;
					}
			    } 
		}
		else{
				$ag_split		= explode('U', $agegroup);
				$user_ag_split	= explode('U', $ag_grp);
				$ag_split2		= explode('ults', $agegroup);

				if(($ag_split[1] >= $user_ag_split[1]) or $agegroup == 'Adults'){	

					if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName, 1);
						
					    if(is_numeric($level_name)){
							//var_dump($level_name);
			 	            if($level_name <= $rating or $rating == 0){
					           $not_eligible_events['rating-'.$event] = $event1;
					        }
							else{
					            $eligible_events[$event] = $event1;
					        }
					    }
						else{ 
							$eligible_events[$event] = $event1; 
						}
		  	        }
					else{
					    $eligible_events[$event] = $event1;
					}
				}
				else if($agegroup == 'Open'){
					$eligible_events[$event] = $event1;
				}
				else if($agegroup == 'Junior'){
					$eligible_events[$event] = $event1;
				}
				else{
					$not_eligible_events['age-'.$event] = $event1;
				}
		}
   }

   $count_chekboxes = count($eligible_events);

   foreach ($eligible_events as $key => $value) {

   	if($r->Multi_Event_Time != NULL){

   		$Multi_Event_Time = json_decode($r->Multi_Event_Time,true);
   	
	    $event  = $key;
	   if($Multi_Event_Time[$event]!=NULL){
	   	$event_date = ' ('.date('m-d-Y', strtotime($Multi_Event_Time[$event])).')';
	   }else{
	   	$event_date = "";
	   }
        $event_time = $event_date;
   	}else{
   		$event_time = '';
   	}

				/*if($key == 'Adults-2-Mixed-44'){
				$value ="Adults Mixed Doubles Championship";
				}*/

      //echo "<tr><td><input type='checkbox' class='".$fee_class."' name='events[]' value='".$key."'/>".$value.' '.$event_time."</td></tr>";
      echo "<tr><td><input type='checkbox' class='".$fee_class."' name='events[]' value='".$key."' autocomplete='off'/>&nbsp;"."<span>".trim($value)."</span>"."</td></tr>";
   }
    echo "</table></div></div>";

    if(count($not_eligible_events)>0){
        echo "<div class='form-group'>";
		echo "<label class='control-label col-md-4 padtop not_eligible_evnts' for='id_accomodation'>";
		
		echo "<b id='change_icon' style='cursor:pointer;'> Not Eligible ( + )</b>";
		
		echo "</label>";
	
		echo "<div class='col-md-8 form-group internal text1'><div class='hider' style='display:none;'><table style='padding:1px; font-family:Open Sans, sans-serif; font-size:14px;'>";
		foreach ($not_eligible_events as $key => $value) {
				/*if($key == 'Adults-2-Mixed-44'){
				$value ="Adults Mixed Doubles Championship";
				}*/

			       $vararr = explode('-', $key);
		    	   $title = $vararr[0];
		    	if($title == 'age'){
                   $reason = $value." (Reason: Age)";
		    	}
		    	if($title == 'rating'){
                   $reason = $value." (Reason: Rating)";
		    	}
		    	if($title == 'gender'){
                   $reason = $value." (Reason: Gender)";
		    	}
		    	
			echo "<tr><td style='color:#808080;'><img style='width:18px;height:18px;' title='You are not eligible for this event!' src='".base_url()."icons/
			info_ico.png'>".$reason."</td></tr>"; 
		}
        echo "</table></div></div></div>";
    }

		 echo "<input type='hidden' id='mtype_stat' name='mtype_stat' value='1' />";
		 echo "<input type='hidden' value='".$count_chekboxes."' id='cnt_checkbxes'>";

	}

	else{
		echo "<input type='hidden' id='mtype_stat' name='mtype_stat' value='0' />";
	}

echo "<div id='partner_section'></div>";   // Event based Partners 
}
else{
?>
<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Levels</b> </label>
<div class='col-md-6 form-group internal text1'>

<?php 
$level_array = array();
if($r->Sport_levels!="")
{
$level_array = json_decode($r->Sport_levels);
	$lvl_checked = '';
	if(count($level_array) == 1){
	$lvl_checked = 'checked';
	}
  foreach($level_array as $row){ ?>
 <input type="radio"  name="level" value="<?php echo $row ;?>" <?=$lvl_checked;?> required /> 
<?php $get_level = league::get_level_name($r->SportsType,$row);
 echo $get_level['SportsLevel'];
?> &nbsp;
		
<?php 
 } 
}
?>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'> <b>* Age Group </b></label>
<div class='col-md-7 form-group internal text1'>
<?
	$ag_checked = '';
	if(count($level_array) == 1){
	$ag_checked = 'checked';
	}
foreach($option_array as $group){
	echo "<input type='radio' class='team_ag' name='age_group' value='$group' $ag_checked required /> $age_grp_list[$group]<br>";
}
?>
</div>
</div>
<?php
}
?>
<input type="hidden" id="is_flag_age" value="<?php echo $is_flag_age;?>" >
<input type="hidden" id="user_age_grp" value="<?php echo $user_age_grp;?>">

<!-- <div class='form-group'  id="doubles_div" style="display : none">
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Partner<br />(Doubles):</b></label>

<input class='ui-autocomplete-input form-control' style='width:55%' id='created_by' name='created_by' type='text' placeholder="Partner's Name" value="" size="5" />
<input class='ui-autocomplete-input form-control' id='created_users_id' name='created_users_id' type='hidden' placeholder="user id" value="" size="5" />
<br>
<p>Note: If you don't find your partner's name, ask him/ her to register and add your name as partner.</p>
</div> -->

<div class='form-group' id="div_event_section"></div>

<?php
if($r->TShirt and ($r->tournament_format != 'Teams' and $r->tournament_format != 'TeamSport')){
?>
<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Please choose your TShirt Size</b></label>
<div class='col-md-3 form-group internal text1'>
<select class='form-control' name='tshirt_size' id='tshirt_size'>
	<option value='S' selected>Small</option>
	<option value='M'>Medium</option>
	<option value='L'>Large</option>
	<option value='XL'>X Large</option>
	<option value='XXL'>XX Large</option>
</select>
</div>
</div>
<?php
}
?>

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Location</b></label>
<div class='col-md-6 form-group internal text1'>
<?php
if($r->venue){ echo $r->venue. ', '; }
if($r->TournamentAddress){ echo $r->TournamentAddress. ', '; }
echo $r->TournamentCity. ', ' .$r->TournamentState;
?>
</div>
</div>

<script>
$(document).ready(function(){	

	$('#add_location, #btn_loc_cancel').click(function(){
		if($('#location_form').css('display')=='none'){
			$('#location_form').show();
			$('.loc_section').hide();
		}
		else{
			$('#location_form').hide();
			$('.loc_section').show();
		}
	});

});
</script>
<?php if($r->Tournament_type == 'Flexible League' and ($r->tournament_format != 'Teams' and $r->tournament_format != 'TeamSport')) { ?>
<!-- Home Court Location -->

	<div class='form-group loc_section' id='ev_loc1'>
		<label class='control-label col-md-4' for='id_accomodation'><b>Home Court Location</b></label>
		<div class='col-md-8 form-group internal'>
		<input class='ui-autocomplete-input form-control' id='hc_loc' name='hc_loc' type='text' placeholder="Start Typing and Select" value='' />
		<input id='hc_loc_id' name='hc_loc_id' type='hidden' value="" />
		</div>
	</div>

	<div class='form-group loc_section'>
		<label class='control-label col-md-4' for='id_accomodation'></label>
		<div class='col-md-8 form-group internal'><b>Note:</b> Click <b><input type="button" id="add_location" value="Add New" class="league-form-submit1"></b> if your location didn't auto populate.</div>
	</div>

	<div class='form-group' id="location_form" style="display:none">
		<!-- <form name='loc_form' id='loc_form' method="post" action='<?php echo base_url();?>events/location_add'> -->			
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Location Title </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_title" name="loc_title" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Address </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_add" name="loc_add" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>City </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_city" name="loc_city" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>State </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_state" name="loc_state" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Country </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_country" name="loc_country" class='form-control' />
			</div>
		</div>

		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'>Zip Code </label>
			<div class='col-md-5 form-group internal'>
			<input type="text" id="loc_zipcode" name="loc_zipcode" class='form-control' />
			</div>
		</div>
		
		<div class='form-group'>
			<label class='control-label col-md-4' for='id_accomodation'></label>
			<div class='col-md-8 form-group internal'>
			<input type="button" id="btn_location" name="btn_location"  value=" Add " class="league-form-submit1" />
			<input type="button" id="btn_loc_cancel" name="btn_location_cancel"  value=" Cancel " class="league-form-submit1" />
			</div>
		</div>
		<!-- </form> -->
	</div>

<!-- Home Court Location -->
<?php
} 
else if($r->tournament_format == 'Teams' or $r->tournament_format == 'TeamSport'){ ?>
		<div class='form-group'>		
		<label class='control-label col-md-4' for='id_accomodation'><b>Select Team</b></label>		
		<div class='col-md-8 form-group internal'>		
		<select name='team' id='team' class='form-control' required>		
		<option value=''>Your Teams</option>		
		<?php /* echo"<pre>";
			print_r($user_created_teams);
			exit;*/

		if($user_created_teams){		
			foreach($user_created_teams as $team){ ?>		
			<option value='<?=$team->Team_ID;?>'><?=$team->Team_name;?></option>
		<?php }
		}
		if($user_existed_teams){
			foreach($user_existed_teams as $team){ ?>
			<option value='<?=$team->Team_ID;?>'><?=$team->Team_name;?></option>
		<?php
			}
		}

		if(!$user_created_teams and !$user_existed_teams){
		?>		
		<option value='' disabled>No Teams Found!!</option>		
		<?php
		}
		?>		
		</select>	
		</div>		
	</div>		
<div id='sel_team_players' style='overflow-y: scroll; display:none;' class="tab-content table-responsive"></div>		
<br />		
<script>		
$(document).ready(function(){		
	$('#add_location').click(function(){		
		var baseurl = "<?php echo $this->config->item('club_form_url'); ?>";
		window.location.href = club_baseurl+'/teams/addnew';		
	});		
});		
</script>		
	<div class='form-group'>		
		<!-- <label class='control-label col-md-4' for='id_accomodation'></label> -->		
		<div class='col-md-12 form-group internal' align='center'>		
		<b>Note:</b> Click <b>		
		<input type="button" id="add_location" value="Add New " class="league-form-submit1" /></b> to create your own team. If you want to join an existing team, please check Teams and Request to Join a team. 		
		</div>		
	</div>
<?php		
}
?>
<div class='form-group' id='fee_div'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Fees</b></label>
<div class='col-md-8 form-group internal'>
<input type='text' name='tour_fee' id='tour_fee' style="width:30%" class='form-control' value="" size="6" readonly />
</div>
</div>

<!-- ************************** Coupon Code Starts Here. ********************************** -->
<?php
if($r->Is_Coupon){
?>
<div class='form-group' id='c_code_div'>
<label class='control-label col-md-4 padtop' for='id_accomodation'>&nbsp;</label>
<div class='col-md-8 form-group internal'>
<b><a id="c_code" style="padding-right:10px;text-decoration:none !important; cursor:pointer;">Have a coupon code?</a></b>
</div>
</div>

<div class='form-group' id='coupon_code_div' style="display:none">
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Coupon Code</b></label>
<div class='col-md-8 form-group internal'>
<input type='text' name='coup_code' id='coup_code' style="width:60%" class='form-control' pattern="[0-9A-Za-z\\-]+"		   onkeydown="upperCase(this);" />
<input type='hidden' name='coup_code_id' id='coup_code_id' />
<input type='hidden' name='coup_disc' id='coup_disc' />
<br>
<input name="apply_coup" id="apply_coup" type="button" style="padding:5px 10px;"value="Apply" class="league-form-submit"/>
&nbsp;&nbsp;
<b><a id="cancel_coup" style="padding-right:10px;text-decoration:none !important; cursor:pointer;"> Cancel</a></b>
<!-- <input name="cancel_coup" id="cancel_coup" type="button" value="Cancel" class="league-form-submit"/> -->
</div>
</div>

<div class='form-group' id='coupon_code_status' style="display:none">
<label class='control-label col-md-4 padtop' for='id_accomodation'>&nbsp;</label>
<div class='col-md-8 form-group internal'>
<span id='cc_status'></span>
</div>
</div>
<?php
}?>
<!-- ************************** Coupon Code Ends Here. ********************************** -->

<?php
if($school_info_req and !$is_school_info){
?>
<div class='form-group' id='fee_div'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>School Name</b>&nbsp;<img src='<?=base_url();?>icons/question-mark.png' width='20px' height='20px' title='We use this to add your school name in our certificates' /></label>
<div class='col-md-8 form-group internal'>
<input type='text' name='txt_school' id='txt_school' style="width:80%" class='form-control' value="" />
</div>
</div>
<?php
}
?>

<div class='form-group'>		
	<label class='control-label col-md-4' for='id_accomodation'><b>Note to Admin</b></label>		
	<div class='col-md-8 form-group internal'>		
	<textarea id="note_to_admin" name="note_to_admin" class="form-control" rows='3'></textarea> 		
	</div>		
</div>
<!--<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Description</b> </label>
<div class="text1">
<?php echo $r->TournamentDescription; ?>
</div>
</div>
<br />
-->
<br />
<script>
$(document).ready(function(){
$('.team_ag').trigger('click');
});
/*$(document).ready(function(){
    $('#myform').submit(function() {

var sg =  $('#Singles:checkbox:checked').length > 0;
var db =  $('#Doubles:checkbox:checked').length > 0;
var mx =  $('#Mixed:checkbox:checked').length > 0;

var count = (db+mx+sg);

		if(count < 1 && $('#mtype_stat').val() != 0){
			alert("Select atleast one play format");
			return false;
		}
        else if (!($('#recommend').is(':checked'))) {
            alert("Please accept the Terms & Conditions");
			return false;
        }
	    else { return true; }
    });
});*/
</script>
<!-- <div class='form-group text1' id='med_div'>
	<label class='control-label col-md-4 padtop text1' for='id_accomodation'> &nbsp;&nbsp;&nbsp; </label>	Please <a style='cursor:pointer;' onclick='medical_form()'><b>Click here</b></a> to print a Medical Release Form. <br />	
</div> -->

<?php 
	if($r->MedicalRelease_pdf != NULL or $r->MedicalRelease_pdf != '') { 
		$url = base_url().'tour_pictures\\'.$r->tournament_ID.'\\'.$r->MedicalRelease_pdf;
?>
<div class='form-group text1' id='med_div'>
	<label class='control-label col-md-4 padtop text1' for='id_accomodation'> &nbsp;&nbsp;&nbsp; </label>	Please <a href="<?=$url;?>" style='cursor:pointer;' target="_blank" ><b>Click here</b></a> to print a Medical Release Form. <br />	
</div>
<?php
	}
	else{
?>
<div class='form-group text1' id='med_div'>
	<label class='control-label col-md-4 padtop text1' for='id_accomodation'> &nbsp;&nbsp;&nbsp; </label>	Please <a  onclick='medical_form()' style='cursor:pointer;'><b>Click here</b></a> to print a Medical Release Form. <br />	
</div>
<?php
	}
?>


<div class='form-group text1' id='tc_div'>

<label class='control-label col-md-4 padtop text1' for='id_accomodation'> <input type="checkbox" name="recommend" id="recommend" value="1" autocomplete='off' required /></label>
  I accept the Tournament <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of <br />A2M Sports.<br />
  
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'></label>
<div class='col-md-7 form-group internal'>
<input name="submit" id="reg_submit" type="submit" value="Register" class="league-form-submit"/>
</div>
</div>

<?php } // end of else for UDOB
}
?>
</div>

<?php
if(!isset($reg_status)) { 
?>
<div class='col-md-4'>
	<!-- <img class="img-djoko" src="<?php echo $this->config->item('club_form_url'); ?>tour_pictures/<?php if($r->TournamentImage!=""){echo $r->TournamentImage; } else { echo "default_image.png";}?>" alt="" />
	 -->
	<img class="scale_image" src="<?=base_url();?>tour_pictures/
	<?php if($r->TournamentImage != ""){ echo $r->TournamentImage; }
	/*else if($this->sports_dets[$r->SportsType]['Image'] != "") { 
		echo $this->sports_dets[$r->SportsType]['Image']; 
	}*/
	else if($r->SportsType == 1){echo "default_tennis.jpg"; }
	else if($r->SportsType == 2){echo "default_table_tennis.jpg"; }
	else if($r->SportsType == 3){echo "default_badminton.jpg"; }
	else if($r->SportsType == 4){echo "default_golf.jpg"; }
	else if($r->SportsType == 5){echo "default_racquet_ball.jpg"; }
	else if($r->SportsType == 6){echo "default_squash.jpg"; }
	else if($r->SportsType == 7){echo "default_pickleball.jpg";}
	else if($r->SportsType == 8){echo "default_chess.jpg";}
	else if($r->SportsType == 9){echo "default_carroms.jpg";}
	else if($r->SportsType == 10){echo "default_volleyball.jpg";}
	else if($r->SportsType == 11){echo "default_fencing.jpg";}
	else if($r->SportsType == 12){echo "default_bownling.jpg";}
	else if($r->SportsType == 16){echo "default_cricket.jpg";}
	else if($r->SportsType == 18){echo "default_basketball1.jpg";}
	?>" alt="" width="250px" height="210px" />
</div>
</form>

<?php
	}
} ?>
</div>
<div style='clear:both;'></div>
</div>

<!-- end main body -->
<!-- </div> --><!-- Close Top Match -->