<script>
$(document).ready(function(){
var baseurl			= "<?php echo base_url();?>";
var club_baseurl		= "<?php if($this->config->item('club_form_url') != '') { echo base_url(); } else  { echo $this->config->item('proxy_url').'/';  } ?>";

var tourn_id = "<?php echo $tourn_id;?>";
 //$('.change_grp').change(function() {
 $(document).on('change', '.change_grp, .add_newUser', function() {
	var target_group = $(this).val();
	var groups		 = $('#groups').val();
	var tformat		 = $('#tformat').val();
	var brc_type		 = $('#brc_type').val();
	var br_game_day		 = $('#br_game_day').val();
	var is_publish_draw	 = $('#is_publish_draw').val();
	var draw_format		= $('#draw_format').val();
	var sport					= $('#sport').val();
	var rr_multi_rounds	= $('#rr_multi_rounds').val();
	var courts_new		= $('#courts_new').val();
	var match_timings	= $('#match_timings').val();
	var user					= $(this).attr('id');

	$('#td_'+user).html("<span style='color:blue'><b>Please wait ....</b></span>");
	//$('#div_groups').html('');
	setTimeout( function(){ 
		 $.ajax({
			type: "POST",
			async:false,
			url:club_baseurl+'league/swap_group_players/',
			data:{user:user,sport:sport,groups:groups,tourn_id:tourn_id,brc_type:brc_type,br_game_day:br_game_day,is_publish_draw:is_publish_draw,draw_format:draw_format,tformat:tformat,target_group:target_group,rr_multi_rounds:rr_multi_rounds,match_timings:match_timings,courts_new:courts_new},
			dataType: "html",
			success: function(res){
				$('#div_groups').html(res);
		    }
		});
	 }  , 100 );
	});


	
 $(document).on('click', '.remove_user', function() {	
 //$('.remove_user').click(function() {	
	 if(!confirm("Are you sure to remove the user from group?")){	
		return false;	
	 }	
	var attr_id			= $(this).attr('id');	
	var x					= attr_id.split('_');	
	var user			= x[2];	
	var group_id		= x[1];	
	var groups		 = $('#groups').val();	
	//var new_grp	 = $('.new_grp').val();	
	var tformat		 = $('#tformat').val();	
	var brc_type		 = $('#brc_type').val();	
	var br_game_day		 = $('#br_game_day').val();	
	var is_publish_draw	 = $('#is_publish_draw').val();	
	var draw_format		= $('#draw_format').val();	
	var sport					= $('#sport').val();	
	var rr_multi_rounds	= $('#rr_multi_rounds').val();	
	var courts_new		= $('#courts_new').val();	
	var match_timings	= $('#match_timings').val();

	$('#plyr_'+user).html("<span style='color:blue'><b>Please wait ....</b></span>");	
	setTimeout( function(){ 	
		 $.ajax({	
			type: "POST",	
			async:false,	
			url:club_baseurl+'league/remove_group_players/',	
			data:{user:user,sport:sport,groups:groups,tourn_id:tourn_id,brc_type:brc_type,br_game_day:br_game_day,is_publish_draw:is_publish_draw,draw_format:draw_format,tformat:tformat,group_id:group_id,rr_multi_rounds:rr_multi_rounds,match_timings:match_timings,courts_new:courts_new},	
			//data: $('#frm_draw_groups').serialize() + "&user="+user+"&target_group="+target_group,	
			dataType: "html",	
			success: function(res){	
				$('#div_groups').html(res);	
		    }	
		});	
	 }  , 100 );	
});

$('#groupds_cont').click(function (){	
		
	if($('#brc_type').val() == "Switch Doubles"){	
		var ng = $('#num_grps').val();	
		$.each(ng, function(n) {	
		var ttl = $("#tbl_"+n).find(".change_grp").length;	
			if(ttl != 4 && ttl != 5 && ttl != 8){	
				alert("Please make sure that all groups should have 4 or 5 or 8 Players to create Switch Doubles");	
				return false;	
			}	
		});	
	}	
	else{	
		return true;	
	}	
});	

});
</script>