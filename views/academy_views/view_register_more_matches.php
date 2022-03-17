<!-- <script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script> -->
<script>
$('#Singles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Doubles_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');
$('#Mixed_levels_div').find('input[type=checkbox]:checked').removeAttr('checked');

	$(document).ready(function(){

		var baseurl = "<?php echo base_url();?>";
		
		   $(".club_page").change(function () { //use change event
        if (this.value == "1") { //check value if it is domicilio
            $('#club').show(); //than show
			$('#club1').show();
        } else {
            $('#club').hide(); //else hide
			$('#club1').hide(); 
        }
    });

		
$('#created_by').autocomplete({
	source: function( request, response ) {
  		$.ajax({
			url: baseurl+'search/autocomplete',
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
		$('#created_users_id').val(names[1]);
	//	$('#phone_code_1').val(names[2]);
		//$('#country_code_1').val(names[3]);
	}		      	
});

//------------------------------------------------------------------------------------------
$('#created_by1').autocomplete({
	source: function( request, response ) {
  		$.ajax({
  			url : baseurl+'search/autocomplete',
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
		$('#created_users_id1').val(names[1]);
	//	$('#phone_code_1').val(names[2]);
		//$('#country_code_1').val(names[3]);
	}		      	
});
// ----------------------------------------------------------------------------------------------

});
</script>

<script>


$(document).ready(function(){
$('input:radio[name=multi_reg]').change(function () {
var is_multi_reg = $("input[name='multi_reg']:checked").val();
if(is_multi_reg == 1){
$("#eligible_events_div").show();
$("#display_multi_reg").show();

}else{
$("#eligible_events_div").hide();	
$("#display_multi_reg").hide();
}
});
$('#myform').submit(function(){
	//alert('test');
    var tournament_format = '<?php echo $r->tournament_format;?>';
    
	if(tournament_format == 'Individual'){
		
	    var event_reg_fee     = '<?php echo $r->Event_Reg_Fee;?>';
	    var cnt_checkbxes     = $("#cnt_checkbxes").val();

	    if(cnt_checkbxes > 0){

	        if(event_reg_fee == "")
	        {
			  	var anyBoxesChecked = false;
			    $('.tour_events_class').each(function() {
			        if($(this).prop("checked") == true){
			            anyBoxesChecked = true;
			        }
			    });
			    if (anyBoxesChecked == false) {
			        alert('Choose atleast one Event to Register!');
			        return false;
			    }else{
			  	    return true;
			    }  
		
		    }else{

				var anyBoxesChecked = false;
			    $('.event_format').each(function() {
			        if($(this).prop("checked") == true){
			           anyBoxesChecked = true;
			        }
			    });
			    if (anyBoxesChecked == false) {
			        alert('Choose atleast one Event to Register!');
			        return false;
			    }else{
			  	    return true;
			    }

		    }
	    }else{
	    	alert("You Don't have any eligible events to register!");
	    	return false;
	    }
	   
	}

	if(tournament_format == 'Teams'){
		return true;
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

   /* ------------------------- Collapse and Expand in Participants ---------------------- */
$(".header").click(function () {
    $header = $(this);
    $content = $header.next();
    $content.slideToggle(500, function () {
        $header.text(function () {
        });
    });
    if($(this).find('b').text() == '( + )'){
          $(this).find('b').html('( - )');
    }else{
    	 $(this).find('b').html('( + )');
    }       

});
/* ------------------------- Collapse and Expand in Participants ---------------------- */ 
		 
});

function getEventTime(events,classname,ag_grp,format){

    var eventtext="";
	var tourn_id = $('#id').val();	
	var is_flag_age = $('#is_flag_age').val();
	var user_age_grp = $('#user_age_grp').val();
	//alert(user_age);die();
	var evnts=[];

	$.ajax({		
		type:'POST',		
		url:baseurl+'league/getEventTime/',		
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
});

}

function getfee(events,classname,ag_grp,format){
	var tourn_id	 = $('#id').val();	
	var is_flag_age  = $('#is_flag_age').val();
	var user_age_grp = $('#user_age_grp').val();
	var user_reg_age_grps = $('#user_reg_age_grps').val();

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
						url:baseurl+'league/get_event_fee/',
						data:{ tour_id:tourn_id, events:events},
						success:function(html){
						  $('#tour_fee').val(html);
						  $('#reg_submit').prop("disabled", false);
						  $('#reg_submit').attr('value', 'Register');
						}
		            }); 
                }

                else if(classname=='tour_events_class'){
                    $.ajax({
						type:'POST',
						url:baseurl+'league/get_tour_fee_more_events/',
				        data:{ tour_id:tourn_id, ag_grp:ag_grp, format:format, is_flag_age:is_flag_age, user_age_grp:user_age_grp, user_reg_age_grps:user_reg_age_grps},
						success:function(html){
							//alert(html);
						  $('#tour_fee').val(html);
						  $('#reg_submit').prop("disabled", false);
						  $('#reg_submit').attr('value', 'Register');
						}
		            }); 
                }

}

function getevents(events,classname,ag_grp,format){
	 
	var eventtext="";
	var tourn_id = $('#id').val();	
	$.ajax({		
		type:'POST',		
		url:baseurl+'league/get_tour_details/',		
		data:{tourn_id:tourn_id,events:events},		
		success:function(event_limitsjsn){		
			console.log(event_limitsjsn);
			var event_limits = JSON.parse(event_limitsjsn);
			if(event_limits.length!=0){
               eventtext+='<label class="control-label col-md-3" for="id_accomodation"><b>Selected Events</b></label><div class="col-md-6 form-group internal text1"><table class="tab-score" style="padding:1px;">';
			}
			
			jQuery.each( event_limits, function( i, limit ) {
                eventtext+='<tr><td>'+i+'</td><td align="center">'+limit+'</td></tr>';
		  	  });
			eventtext+='</table>';
			$("#div_event_section").html(eventtext);
			//alert(events);
			 getfee(events,classname,ag_grp,format);
		}		
	});
	
	        /* jQuery.each( events, function( i, evnt ) {
                eventtext+='<label class="control-label col-md-3" for="id_accomodation">'+evnt+'</label>';
		  	  });*/

		  //	$("#div_event_section").html(eventtext);
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
           baseurl	   = "<?php echo base_url(); ?>";
           tour_id	   = "<?php echo $this->uri->segment(3); ?>";

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
           baseurl	   = "<?php echo base_url(); ?>";
           tour_id	   = "<?php echo $this->uri->segment(3); ?>";

		$('input[class=tour_events_class]:checked').each(function(){
			$val = $(this).val();

	        $sp = $val.split('-');
	        $event = $sp[0]+'-'+$sp[1]+'-'+$sp[2];
			events.push($event);	
	        ag_grp.push($sp[1]);
	        if($sp[0]=="Singles"){
	          format.push('Singles');
	        }
	        if($sp[0]=="Doubles"){
	          format.push('Doubles');	      
	        }
	        if($sp[0]=="Mixed"){
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

baseurl	  = "<?php echo base_url(); ?>";
tour_id	  = "<?php echo $this->uri->segment(3); ?>";

$ag_grp = [];

$('input[class=sel_opt]:checked').each(function(){
	$val = $(this).val();
	$sp = $val.split('_');
	$ag_grp.push($sp[1]);
});

$.ajax({
	type:'POST',
	url:baseurl+'league/get_tour_fee/',
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
  $user_id = $this->session->userdata('users_id'); 
?>
<section id="single_player" class="container secondary-page">
<div class="top-score-title right-score col-md-9">

<!-- start main body --> 
<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Register more events for <?php echo $r->tournament_title; ?></div>

<?php if($this->session->userdata('user')=="") { 
$cur_uri = array('redirect_to'=>$_SERVER['REQUEST_URI']);
$this->session->set_userdata($cur_uri);
?>
<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to register for a tournament</p>
<?php  } ?>
<?php if($this->session->userdata('user')!="") { ?>
<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo $this->config->item('club_pr_url'); ?>/league/buy_more/<?php echo $r->tournament_ID;?>" <?=$block_status;?>>
 
<div class='col-md-8'>
<input type="hidden" id="id" name="id" value="<?php echo $r->tournament_ID; ?>" />
<?php
//$check_user_usatt_membership = league::is_logged_user_having_memeberhip($r->SportsType);

 $get_user_mem_details  = league::get_user_mem_details($user_id, $r->SportsType);
 $get_user_usatt_rating = league::get_user_usatt_rating($get_user_mem_details['Membership_ID']);
 //print_r($get_user_usatt_rating);
 
    if($get_user_usatt_rating){ 
		$rating = $get_user_usatt_rating['Rating']; 
	}

//if($r->SportsType == '2' and !$check_user_usatt_membership){
?>
	<!-- <div class="form-group">
         <label class='control-label col-md-4 padtop' for=""> <b>Do you have USATT Membership?</b></label>
		 <div class='col-md-6 form-group internal text1'>
         <input name="club_page" class="club_page" type="radio" value="1" style="margin-bottom:22px"> Yes  
		 <input name="club_page" class="club_page" type="radio" value="0" checked> No  
		 </div>
    </div>
						
	<div id="club" style="display:none">				
		<div class="form-group">
			<label class='control-label col-md-4 padtop' for="email"><b>MemberShip ID</b></label>
			<div class='col-md-6 form-group internal text1'>
			<input id="usatt_member_id" name="usatt_member_id" class="form-control" type="text" style="width:70%"/>
			</div>
		</div>
	</div> -->
<?php
//}

//if($r->SportsType == '2' and $check_user_usatt_membership){
?>
	<!-- <div class="form-group">
	 <label class='control-label col-md-4 padtop' for=""> <b>USATT Membership ID</b></label>
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
		  echo $get_user_usatt_rating['Rating'];
		?>
	  </div>
	</div>
 -->
 <?php
//}
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
			case "U12":
			$age_grp_list[] = "Under 12";
			break;
			case "U14":
			$age_grp_list[] = "Under 14";
			break;
			case "U16":
			$age_grp_list[] = "Under 16";
			break;
			case "U18":
			$age_grp_list[] = "Under 18";
			break;
			case "Adults":
			$age_grp_list[] = "Adults";
			break;
			case "Adults_30p":
			$age_grp_list[] = "30s";
			break;
			case "Adults_40p":
			$age_grp_list[] = "40s";
			break;
			case "Adults_50p":
			$age_grp_list[] = "50s";
			break;
			case "Adults_60p":
			$age_grp_list[] = "60s";
			break;
			case "Adults_70p":
			$age_grp_list[] = "70s";
			break;
			case "Adults_veteran":
			$age_grp_list[] = "Veteran";
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

$json_array = json_decode($r->Singleordouble);

$numItems   = count($json_array);

$i = 0;

		$age_class   = "";
		$user_gender = $user_age_dat['Gender'];
		$user_dob    = $user_age_dat['DOB'];
		$birthdate	 = new DateTime($user_dob);
		$today		 = new DateTime('today');
		$user_age    = $birthdate->diff($today)->y;
		$db_age      = json_decode($r->Age);

        switch (true) {
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
				case $user_age == 21:
                   $user_age_grp = "U21";
                   break;
                case $user_age>21 && $user_age<=29:
                   $user_age_grp = "Adults";
                   break;
                case $user_age>=30 && $user_age<=39:
                   $user_age_grp = "Adults_30p";
                   break;
                case $user_age>=40 && $user_age<=49:
                   $user_age_grp = "Adults_40p";
                   break;
                case $user_age>=50 && $user_age<=59:
                   $user_age_grp = "Adults_50p";
                   break;
				case $user_age>=60 && $user_age<=69:
                   $user_age_grp = "Adults_60p";
                   break;
				case $user_age>=70 && $user_age<=90:
                   $user_age_grp = "Adults_70p";
                   break;
        }

		if(in_array($user_age_grp, $db_age)){
		   $is_flag_age=1;
		}else{
		   $is_flag_age=0;
		}


    $event_format = array();
    $not_eligible_events = array();

    if($r->Event_Reg_Fee!=NULL){
	    $fee_class = "event_format";
	}
	else{
		$fee_class = "tour_events_class";
	}
	//echo $fee_class;
 
	if($r->Multi_Events != NULL){

       $multi_events = json_decode($r->Multi_Events);

    }else{
    	
       $events       = league::GetTournamentEvents($r);
       $multi_events = league::array_flatten($events);	  
    }
    
    

	$event_formats = league::regenerate_events($multi_events);
   // echo "<pre>"; print_r($event_formats);
    foreach ($event_formats as $key => $event) {
        if(!in_array($key, $regdata)){
		    $event_format[$key] = $event; 
        }
    }

     $res = league::get_reg_tourn_participants_new($r->tournament_ID);
     $reg_users = $res[0];
     
	 if(count($regdata)>0){
        echo "<div class='form-group'>";
		echo "<label class='control-label col-md-4 padtop' for='id_accomodation'>";
		
		echo "<b> Registered Events</b>";
		
		echo "</label>";
	
		echo "<div class='col-md-8 form-group internal text1'><table style='padding:1px;'>";
		    $reg_events = league::regenerate_events($regdata);
		foreach ($reg_events as $key => $value) {
		           $event = $value;
                   $evnt  = $key;
		           $users = league::in_array_r($evnt, $reg_users);
		           $cnt   = count($users);
		          
			echo "<tr class='header' style='cursor:pointer;'><td>";
			echo "<b id='chg_icon'>( + )</b>";
			echo " ".$event." (".$cnt.")";
			echo "</td>";
			echo "</tr>"; 
			echo "<tr class='content' style='display:none'><td>";
            echo "<table>";
            foreach($users as $user){
            	$player	= league::get_username($user);
            	echo "<tr>";
				echo "<td style='color:#808080;'><a target='_blank' href='".base_url()."player/$user'>";
				echo $player['Firstname'] . " " .$player['Lastname'];
				echo "</a></td>";
				echo "</tr>";
            } 
		    echo "</table>";
			echo "</tr>"; 
		}
        echo "</table></div></div>";
    }
	 $eligible_events = array();
     $gender_eligible_events = array();
	//echo $age_class;
	   
		foreach ($event_format as $event => $event1) {

  	    $eventsarr  = explode('-', $event); 
        $ag         = $eventsarr[0];
     	$genderkey  = $eventsarr[1];
     	$format     = $eventsarr[2];
	  	$level_num  = $eventsarr[3];

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
	  	    }else if($genderkey == 1){
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

	  	    }else if($genderkey == 2){
                $gender_eligible_events[$event] = $event1;
	  	    }
            
    }


   // echo $ag_grp;exit();

     //echo "<pre>";print_r($gender_eligible_events);exit();
   
      foreach ($gender_eligible_events as $event => $event1) {
	            $eventsarr = explode('-', $event);
		  		$level_num = $eventsarr[3];
		  		$level_name_arry = league::get_level_name('',$level_num);
	            $LevelName       = $level_name_arry['SportsLevel'];
		  		$ages = $eventsarr[0];
		  		$agegroup = $ages;
      
        if($ag_grp == 'Adults'){  

				if($agegroup == 'U10' or $agegroup == 'U11' or $agegroup == 'U12' or $agegroup == 'U13' or $agegroup == 'U14' or $agegroup == 'U15' or $agegroup == 'U16' or $agegroup == 'U17' or $agegroup == 'U18' or $agegroup == 'U19' or $agegroup == 'U21'){
			          $not_eligible_events['age-'.$event]=$event1;

			    }else if (strpos($agegroup, '_') !== false) {
					$age = preg_replace('/\D/', '', $agegroup);
					
			    	if($age==40 && ($user_age>=40 && $user_age<50)){
		                if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);

					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					        }else{
					        	$eligible_events[$event]=$event1;	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else if($age==50 && $user_age>=50){
                        if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					          
					        }else{
					        	$eligible_events[$event]=$event1;
					        	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else if($age==60 && $user_age>=60){
                        if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					          
					        }else{
					        	$eligible_events[$event]=$event1;
					        	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else if($age==70 && $user_age>=70){
                        if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					          
					        }else{
					        	$eligible_events[$event]=$event1;
					        	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else if($age==80 && $user_age>=80){
                        if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					          
					        }else{
					        	$eligible_events[$event]=$event1;
					        	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
		            }
					else{
				          $not_eligible_events['age-'.$event] = $event1;
				        }
   
                 }else{

			    	if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);		  		
					    if(is_numeric($level_name)){
			 	            if($level_name < $rating){
			 	            	$not_eligible_events['rating-'.$event]=$event1;
					          
					        }else{
					        	$eligible_events[$event]=$event1;
					        	
					        }
					    }else{
					    	$eligible_events[$event]=$event1;
					    }
		  	        }else{
					   $eligible_events[$event]=$event1;
					}
			        
			    } 
		}
		else{ 

				$ag_split		= explode('U', $agegroup);
				$user_ag_split	= explode('U', $ag_grp);
				$ag_split2		= explode('ults', $agegroup);
					
				if(($ag_split[1] >= $user_ag_split[1]) or $agegroup == 'Adults')  {	

					if($r->SportsType == '2'){
		  		        $level_name = substr($LevelName,1);
						
					    if(is_numeric($level_name)){
							//var_dump($level_name);
			 	            if($level_name < $rating){
					           $not_eligible_events['rating-'.$event]=$event1;
					        }else{
					            $eligible_events[$event]=$event1;
					        }
					    }
						else{ $eligible_events[$event]=$event1; }
		  	        }else{
					    $eligible_events[$event]=$event1;
					}	
				}else{
					$not_eligible_events['age-'.$event]=$event1;
						
				}
		}  
                  
   }

   $count_chekboxes = count($eligible_events);
   					/*echo "<pre>";
					print_r($user_reg_ag_grps);
					exit;*/

$now =  time();
$reg_close = strtotime($r->Registrationsclosedon);
$reg_open  = strtotime($r->Registrations_Opens_on);

if($now < $reg_close){
      ?>
        <div class="form-group">
			<div class='form-group internal text1'>
           <label class='control-label padtop' for=""><b>Do you want to register more events?</b>&nbsp;&nbsp;&nbsp;</label>
	           <input name="multi_reg" type="radio" value="1" style="margin-bottom:22px"> Yes  
			   <input name="multi_reg" type="radio" value="0" checked> No  
			</div>
         </div>
      <?php
        echo "<div class='form-group' id='eligible_events_div' style='display:none'>";
	    echo "<label class='control-label col-md-4 padtop' for='id_accomodation'>";
		
		echo "<b>* Eligible Events</b>";
		
		echo "</label>";
		echo "<div class='col-md-8 form-group internal text1'><table style='padding:1px;'>";
  if($count_chekboxes > 0){
   foreach ($eligible_events as $key => $value) {
   
   	if($r->Multi_Event_Time!= NULL){
   		$Multi_Event_Time = json_decode($r->Multi_Event_Time,true);
	    $event  = $key;
        $event_time = ' ('.$Multi_Event_Time[$event].')';
   	}else{
   		$event_time = '';
   	}

      echo "<tr><td><input type='checkbox' class='".$fee_class."' name='events[]' value='".$key."'/>&nbsp;".$value.' '.$event_time."</td></tr>";
   }
   }else{
   	  echo "<tr><td>No Eligible Events</td></tr>";
   }
    
    echo "</table></div></div>";
     echo "<div id='display_multi_reg' style='display:none'>";
	 //echo "<pre>"; print_f($user_reg_ag_grps); exit;
	foreach($regdata as $k => $i){
	echo "<input type='hidden' name='events[]' value='".$i."'/>";
	}
    
    if(count($not_eligible_events)>0){

        echo "<div class='form-group' >";
		echo "<label class='control-label col-md-4 padtop not_eligible_evnts' for='id_accomodation'>";
		
		echo "<b id='change_icon' style='cursor:pointer;'> Not Eligible ( + )</b>";
		
		echo "</label>";
	
		echo "<div class='col-md-8 form-group internal text1'><div class='hider' style='display:none;'><table style='padding:1px;'>";
		foreach ($not_eligible_events as $key => $value) {
			       $vararr = explode('-', $key);
		    	   $title = $vararr[0];
		    	
		    	if($title == 'age'){
                   $reason = $value." (Reason: Age)";
		    	}
		    	if($title == 'rating'){
                   $reason = $value." (Reason: Rating)";
		    	}
		    	if($title == 'gender'){
                   $reason = $value."(Reason: Gender)";
		    	}
			echo "<tr><td style='color:#808080;'><img style='width:18px;height:18px;' title='You are not eligible for this event!' src='".base_url()."icons/
			info_ico.png'>".$reason."</td></tr>"; 
		}
        echo "</table></div></div></div>";
    }

		 echo "<input type='hidden' id='mtype_stat' name='mtype_stat' value='1' />";
		 echo "<input type='hidden' value='".$count_chekboxes."' id='cnt_checkbxes'>";

	
	


?>
<input type="hidden" id="is_flag_age" value="<?php echo $is_flag_age;?>" >
<input type="hidden" id="user_age_grp" value="<?php echo $user_age_grp;?>">
<input type="hidden" id="user_reg_age_grps" value='<?php echo json_encode($user_reg_ag_grps);?>'>

<div class='form-group'  id="doubles_div" style="display : none">
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Partner<br />(Doubles):</b></label>

<?php 
$get_user = league::get_user($user_id);
?>

<input class='ui-autocomplete-input form-control' style='width:55%' id='created_by' name='created_by' type='text' placeholder="Partner's Name" value="" size="5" />
<input class='ui-autocomplete-input form-control' id='created_users_id' name='created_users_id' type='hidden' placeholder="user id" value="" size="5" />
<br>
<br>
<p>Note: If you don't find your partner's name, ask him/ her to register and add your name as partner.</p>
</div>

<div class='form-group'>
<div class='' id="mixed_div" style="display : none">
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Partner<br />(Mixed Doubles):</b></label>

<input class='ui-autocomplete-input form-control' style='width:55%' id='created_by1' name='created_by1' type='text' placeholder="Partner's Name" value="" size="5" />
<input class='ui-autocomplete-input form-control' id='created_users_id1' name='created_users_id1' type='hidden' placeholder="user id" value="" size="5" />
<br>
<br>
<p>Note: If you don't find your partner's name, ask him/ her to register and add your name as partner.</p>
</div>
</div>
<div class='form-group' id="div_event_section">
</div>

<?php
//if($r->TShirt and $r->tournament_format != 'Teams'){
?>
<!-- <div class='form-group'>
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
</div> -->
<?php
//}
?>

<div class='form-group'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Location</b></label>
<div class='col-md-6 form-group internal text1'>
<?php
if($r->venue){ echo $r->venue. ', '; }
if($r->TournamentAddress){ echo $r->TournamentAddress. ', '; }
if($r->TournamentCity){ echo $r->TournamentCity. ', '; }
if($r->TournamentState){ echo $r->TournamentState; }
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

<div class='form-group' id='fee_div'>
<label class='control-label col-md-4 padtop' for='id_accomodation'><b>Fees</b></label>
<div class='col-md-8 form-group internal'>
<input type='text' name='tour_fee' id='tour_fee' style="width:30%" class='form-control' value="" size="6" readonly />
</div>
</div>
<br />
<div class='form-group'>		
		<label class='control-label col-md-4' for='id_accomodation'><b>Note to Admin</b></label>		
		<div class='col-md-8 form-group internal' >		
		<textarea  id="note_to_admin" name="note_to_admin" class="form-control"> 
		</textarea> 		
		</div>		
</div>
<br />
<script>
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
<div class='form-group text1' id='med_div'>
	<label class='control-label col-md-4 padtop text1' for='id_accomodation'> &nbsp;&nbsp;&nbsp; </label>	Please <a style='cursor:pointer;' onclick='medical_form()'><b>Click here</b></a> to print a Medical Release Form. <br />	
</div>	
<div class='form-group text1' id='tc_div'>

<label class='control-label col-md-4 padtop text1' for='id_accomodation'>
<input type="checkbox" name="recommend" id="recommend" value="1" required /></label>
  I accept the Tournament <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports.<br />
</div>

<div class='form-group'>
<label class='control-label col-md-4' for='id_accomodation'></label>
<div class='col-md-7 form-group internal'>
<input name="submit" id="reg_submit" type="submit" value="Register" class="league-form-submit"/>
</div>
</div>

</div>
<?php }		// Closing of RegClose date if statement
?>
</div>
</form>
<?php	
}

?>
<div class='col-md-4' style="padding-bottom:20px">
<?php 
if(!isset($reg_status)) {
?>
	<img class="scale_image"  alt="" width="250px" height="224px" src="<?php echo base_url(); ?>tour_pictures/<?php 
	if($r->TournamentImage != "" and $r->TournamentImage != NULL){ echo $r->TournamentImage; }
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
	?>" />

<?php
}
?>
</div>
</div>
<!-- end main body -->
</div><!-- Close Top Match -->