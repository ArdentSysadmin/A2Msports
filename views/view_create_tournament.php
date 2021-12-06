<script src="<?=base_url();?>assets/tinymce/tinymce.min.js"></script>
<link href="<?php echo base_url();?>css/foundation-datepicker.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/bootstrap-timepicker.min.css" rel="stylesheet">
<script>
tinymce.init({
selector: 'textarea',
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

<script>
$(document).ready(function(){

$(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
e.preventDefault();
});

$("#fee_type").hide();
//$('.age').attr('disabled', true);
var tf1 = $("#tour_format1").val();
$("#tour_format").change(function (){
var tf = $(this).val();
if(tf == 'Teams' || tf1 == 'Team Sport'){
$('.age').attr('disabled', false);
$(".age").prop("checked", false);
$("#dyn_courts").html('');
$('#num_lines_div').show();
$('#mtype').hide();
$('#addl_fee_div').hide();
$('#event_section').hide();
$('#generate_events').hide();
//$('#team_event_section').show();
$('#event_fee_section').hide();
$('#event_time_section').hide();
$("#fee_type").show();
$(".x1").attr("disabled", true);
$("#second_section").show();
$("#confirm_proceed").hide();
$("#TShirt_Info").hide();
}
else{
$(".age").prop("checked", false);
$("#dyn_courts").html('');
$('#num_lines').val('');
$('#lines_section').html('');
$('#num_lines_div').hide();
$('#lines_div').hide();
$('#event_section').show();
$('#generate_events').show();
//$('#team_event_section').hide();
$('#event_fee_section').show();
$('#event_time_section').show();
$('#mtype').show();
$('#addl_fee_div').show();
$("#fee_type").hide();
$(".x1").attr("disabled", false);
$("#second_section").hide();
$("#tour_format1").val('');
}
});


$(".x1").click(function (){
//var mtype_id = $(this).attr('id');

var s_stat  = $('#singles').is(":checked");
var d_stat  = $('#doubles').is(":checked");
var m_stat  = $('#mixed').is(":checked");

var i = 0;
$('.sp_levels:checked').each(function(){
i++;
});

if((s_stat && d_stat) || (d_stat && m_stat) || (m_stat && s_stat) || i > 1){
if($('input[name^="addn_fee_collect"]').length == 0){
$('.div_grp').each(function() {
var $ctrl = $("<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>");
$(this).append($ctrl);
});
}
}
else{
//$('.age').attr('disabled', true);
$('input[name^="addn_fee_collect"]').each(function() {
$(this).parent('div').remove();
$(this).remove();
});
}
});

var baseurl = "<?php echo base_url();?>";

$("#academy").autocomplete({

source: function( request, response ) {
$.ajax({
url: baseurl+'Opponent/autocomplete',
dataType: "json",
method: 'post',
data: {
name_startsWith: request.term,
type: 'Academy',
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
$('#org_id').val(names[1]);
}	      	
});


$("#tourn_dir").autocomplete({

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
label: code[0]+' ('+code[1]+' | '+code[2]+')',
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
$('#tourn_dir_id').val(names[1]);
$('#org_contact').val(names[6]);
}	      	
});


});
</script>

<!------------------------------- Date Validations Starts Here --------------------------------------->
<script>
$( document ).ready(function() {
	$('input[name="sdate"]').blur(function () {
		if (!$("#start_date").val()){ 
		$("#reg_opens_on").prop("disabled", true);
		$("#reg_closed_on").prop("disabled", true);
		$("#refund_date").prop("disabled", true);
		}
	});

	$('input[name="edate"]').change(function () {
		if (!$("#start_date").val() || !$("#end_date").val()){ 
		$("#reg_opens_on").prop("disabled", true);
		$("#reg_closed_on").prop("disabled", true);
		$("#refund_date").prop("disabled", true);
		}
		else{
		$("#reg_opens_on").prop("disabled", false);
		$("#reg_closed_on").prop("disabled", false);
		$("#refund_date").prop("disabled", false);
		}
	});
});


$(document).ready(function() {
$("#reg_opens_on").change(function(){
var sd			= $("#start_date").val();
var reg_opens	= $("#reg_opens_on").val();
var toDayDate	= new Date();

if($("#start_date").val()=="" || $("#end_date").val()==""){
alert("Please Provide Values For Start & End Dates.");
$("#reg_opens_on").val('');
return false;
}

sd_ts		 = parseInt((new Date(sd).getTime() / 1000).toFixed(0));
reg_opens_ts = parseInt((new Date(reg_opens).getTime() / 1000).toFixed(0));
today_ts	 = parseInt((new Date(toDayDate).getTime() / 1000).toFixed(0));

//if (reg_opens_ts >= today_ts && reg_opens_ts < sd_ts) {
if (reg_opens_ts) {
return true;
}
else{
alert("Registrations Open date Should be greater than OR Equal To Current date & Less Than Start Date.");
$("#reg_opens_on").val('');
return false;
}
});


$("#reg_closed_on").change(function(){
var sd		   = $("#start_date").val();
var reg_opens  = $("#reg_opens_on").val();
var reg_closes = $("#reg_closed_on").val();

sd_ts		 = parseInt((new Date(sd).getTime() / 1000).toFixed(0));
reg_opens_ts = parseInt((new Date(reg_opens).getTime() / 1000).toFixed(0));
reg_closes_ts	 = parseInt((new Date(reg_closes).getTime() / 1000).toFixed(0));


//if ((reg_closes_ts < sd_ts ) && (reg_closes_ts > reg_opens_ts)) {
if (reg_closes_ts) {
return true;
}
else
{	
alert("Registrations Closes date Should be greater than Registrations Open date & Less Than Start Date.");
$("#reg_closed_on").val(''); 	
return true;;
}
});


$("#refund_date").change(function(){
var withdraw	= $("#refund_date").val();
var reg_opens	= $("#reg_opens_on").val();
var reg_closes	= $("#reg_closed_on").val();
var sd		    = $("#start_date").val();

wd_ts		  = parseInt((new Date(withdraw).getTime() / 1000).toFixed(0));
sd_ts		  = parseInt((new Date(sd).getTime() / 1000).toFixed(0));
reg_opens_ts  = parseInt((new Date(reg_opens).getTime() / 1000).toFixed(0));
reg_closes_ts = parseInt((new Date(reg_closes).getTime() / 1000).toFixed(0));

//if ((wd_ts > reg_opens_ts ) && (wd_ts < sd_ts)) {
if (wd_ts) {
return true;
}
else
{
alert("WithDraw date Should be greater than Registrations Open date & Less Than Registrations Closes Date.");
$("#refund_date").val('');
return false;
}

});
});
</script>

<!------------------------------- Date Validations Ends Here ----------------------------------------->

<script>
$( document ).ready(function() {
$('input[name="sdate"]').blur(function () {
if (!$("#start_date").val()){ 
$("#reg_opens_on").prop("disabled", true);
$("#reg_closed_on").prop("disabled", true);
$("#refund_date").prop("disabled", true);
}
});

$('input[name="edate"]').change(function () {
if (!$("#start_date").val() || !$("#end_date").val()){ 
$("#reg_opens_on").prop("disabled", true);
$("#reg_closed_on").prop("disabled", true);
$("#refund_date").prop("disabled", true);
}
else{
$("#reg_opens_on").prop("disabled", false);
$("#reg_closed_on").prop("disabled", false);
$("#refund_date").prop("disabled", false);
}
});
});
</script>

<script>
$( document ).ready(function() {
/*$('#start_date').fdatepicker({
format: 'mm/dd/yyyy',
disableDblClickSelection: true,
language: 'en',
pickTime: false
});*/
$('#start_time').timepicker();
$('#end_time').timepicker();

$('#regs_open_time').timepicker();
$('#regs_close_time').timepicker();


$('#eventTime').fdatepicker({
format: 'mm/dd/yyyy',
disableDblClickSelection: true,
language: 'en',
pickTime: false
});


/* ********************* Date Picker Code For Coupon Codes Starts Here. ********************************* */
$('body').on('focus',".expiry_date", function(){
$(this).fdatepicker({
format: 'mm/dd/yyyy',
disableDblClickSelection: true,
language: 'en',
pickTime: false
});
});
});
</script>

<script>
function upperCase(a){
setTimeout(function(){
a.value = a.value.toUpperCase();
}, 1);
}
</script>
<!-- ********************* Date Picker Code For Coupon Codes Ends Here. ********************************* -->
<script>
$(document).ready(function(){

$(".age").click(function (){
var ch_id		   = $(this).attr('id');
var stat		   = $('#' + ch_id).is(":checked");
var is_team        = $('#tour_format').val();
var is_team1       = $('#tour_format1').val();

var age_grp_label  = $('label[for='+ch_id+']').text();
var add_fee_amount = "";

if(is_team != 'Teams' && is_team1 != 'Team Sport'){
//if(is_team != 'Teams'){

var label_text = "";
var fee_amount = "";
var add_fee_amount = "";

if($('#singles').is(":checked") || $('#doubles').is(":checked") || $('#mixed').is(":checked")){
label_text = "<div class='col-md-2' style='padding-top:5px;'>"+age_grp_label+"<input type='hidden' class='form-control' name='age_group[]' value='"+ch_id+"' /></div>";	
}

if($('#singles').is(":checked") || $('#doubles').is(":checked") || $('#mixed').is(":checked")){
fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' value='0.00' /></div>";
}

/*if(
($('#singles').is(":checked") && $('#doubles').is(":checked")) || 
($('#singles').is(":checked") && $('#mixed').is(":checked")) ||
($('#mixed').is(":checked") && $('#doubles').is(":checked"))
){*/
if($('#singles').is(":checked") || $('#doubles').is(":checked") || $('#mixed').is(":checked")){

add_fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='addn_fee_collect[]' placeholder='Additional Fee' value='0.00' /></div>";
}

$('#addl_fee_div').show();
}
else{
var	label_text = "<div class='col-md-2' style='padding-top:5px;'>"+age_grp_label+"<input type='hidden' class='form-control' name='age_group[]' value='"+ch_id+"' /></div>";

var	fee_amount = "<div class='col-md-2'><input type='text' class='form-control' name='fee_collect[]' placeholder='Fee Amount' value='0.00' /></div>";
$('#addl_fee_div').hide();
}
if(stat){
var i = 0;
var $ctrl = $("<div class='col-md-12 div_grp' id='div_"+ch_id+"' style='padding-bottom:4px;'>"+label_text+fee_amount+add_fee_amount+"</div>");
$("#dyn_courts").append($ctrl);
}
else{
$("#dyn_courts #div_"+ch_id+"").remove();
}

});

$("#tourn_type").change(function(){
if($(this).val() == 'Flexible League'){
$("#addr_group").hide();
$("#addr_group :input").attr("disabled", true);
}else{
$("#addr_group :input").attr("disabled", false);
$("#addr_group").show();
}
});

});
</script>

<script>
function CompareDate() {
var sdate1 = document.getElementById("start_date").value;
var edate1 = document.getElementById("end_date").value;

var x = new Date(sdate1);
var y = new Date(edate1);

if (x > y){
alert("Start date can not be greater than End date.");
return false;
}
}
</script>

<script type="text/javascript">
$(function () {
$("input[name='fee']").click(function (){
if ($("#chkYes").is(":checked")){
var checked  =  $('#singles:checkbox:checked').length > 0;
var checked1 =  $('#doubles:checkbox:checked').length > 0;
var checked2 =  $('#mixed:checkbox:checked').length > 0;

//if((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)){
if(checked == true || checked1 == true || checked2 == true){
if ($("#chkYes").is(":checked")) {
$("#div_fee_section").show();	
$("#event_fee_section").show();
}
}
else{
$("#div_fee_section").hide();
$("#event_fee_section").hide();
}

/*$("#dvPassport").show();
$("#div_fee_section").show();
//$("#event_fee_section").hide();
$("#event_fee_section").show();

if($('#tour_format').val() == 'Teams' || $('#tour_format1').val() == 'Team Sport'){ 
$("#fee_type").show(); 
$("#event_fee_section").hide();
}*/

$("#dvPassport").show();
$("#div_fee_section").show();
$("#event_fee_section").show();
$("#div_crcy_frmt").show();
$("#Currency_code").show();
$("#couponCode_section").show();
$("#paypal_details").show();
$('#ag_grp_fee').show();

if(($('#tour_format').val() == 'Individual') && ($('#Sport').val() != '10' && $('#Sport').val() != '13' && $('#Sport').val() != '14' && $('#Sport').val() != '15' && $('#Sport').val() != '16' && $('#Sport').val() != '18')) {
		//alert('1');
	$("#event_fee_section").show();
	$("#fee_type").hide(); 
	//$("#fee_type").html(''); 
	//$("#dyn_courts").html('');
	//$("#div_fee_section").html(''); 
}
else if(($('#tour_format').val() == 'Teams') && ($('#Sport').val() != '10' && $('#Sport').val() != '13' && $('#Sport').val() != '14' && $('#Sport').val() != '15' && $('#Sport').val() != '16' && $('#Sport').val() != '18')) {
			//alert('2');

	$("#event_fee_section").hide();
	$("#fee_type").show(); 
	$("#dyn_courts").show();
}
else {
			//alert('3');

	$("#tour_format1").val('Team Sport');
	var tf1 = $("#tour_format1").val();
		if(tf1 == 'Team Sport') {
			$("#div_fee_section").show();
			$("#fee_type").show(); 
			$("#dyn_courts").show();
			$("#event_fee_section").hide();
		}
}
}
else{
$("#dvPassport").hide();
$("#div_fee_section").hide();
$("#event_fee_section").hide();
$("#fee_type").hide();
$("#dyn_courts").show();
$("#couponCode_section").hide();
$("#ccNo").prop("checked",true);
$("#couponCode_details").hide();
}
});

	$("input[name='pp']").click(function (){
		if($("#ppYes").is(":checked")) {
			$('#paypal_ids').show();
			$("#ppYesNo").hide();
			$('#addppids').show();		
		}
		else{
			$('#paypal_ids').hide();
			$('#addppids').hide();
			$("#ppYesNo").hide();
			$('#paypal_ids').val('');
		}
	}); 

	$("input[name='petm']").click(function (){
		if($("#ptmYes").is(":checked")) {
			$('#paytm_ids').show();
			$("#peTmYesNo").hide();
			$('#addptmids').show();		
		}
		else{
			$('#paytm_ids').hide();
			$('#addptmids').hide();
			$("#peTmYesNo").hide();
			$('#ptmids').val('');
		}
	}); 

$("#addppids").click(function (){
$('#paypal_ids').hide();
$('#ppYesNo').show();
});

/* *************************** JQuery Code For CouponCode Starts Here ********************************* */
$("input[name='cc']").click(function (){
if($("#ccYes").is(":checked")) {
$('#couponCode_details').show();
}
else{
$('#couponCode_details').hide();
}
});
/* *************************** JQuery Code For CouponCode Ends Here ********************************* */


 	$("#addppids").click(function (){
		$('#paypal_ids').hide();
		$('#ppYesNo').show();
	});

	$("#addptmids").click(function (){
		$('#paytm_ids').hide();
		$('#peTmYesNo').show();
	});

});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('input[type="checkbox"]').click(function(){
var checked  =  $('#singles:checkbox:checked').length > 0;
var checked1 =  $('#doubles:checkbox:checked').length > 0;
var checked2 =  $('#mixed:checkbox:checked').length > 0;		

if ((checked == true && checked1 == true) || (checked1 == true && checked2 == true) || (checked2 == true && checked == true)) {
if ($("#chkYes").is(":checked")) {
$("#add_event").show();
}
}
else {
$("#add_event").hide();
}
});


$("#visible1").click(function () {
$("#academy_text").show();
});

$("#visible").click(function () {
$("#academy_text").hide();
});

if($("#visible1").is(":checked")) {
$("#academy_text").show();
}
});
</script>

<script>
$(document).ready(function(){

$(function () {
yourFunction(); //this calls it on load
$("select#country").change(yourFunction);
});

$(function (){

$("input[name='sponser']").click(function () {
if ($("#SpnsrYes").is(":checked")) {
$("#div_sponser_section").show();
}else{
$("#div_sponser_section").hide();
}
});

});


var i=1;  
$('#add').click(function(){  
i++;  
$('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td style="border-top: 0px solid #ddd;"><input style="font-size:14px;" type="file" name="spnsr_file_name[]" /></td><td style="border-top: 0px solid #ddd;"><input class="form-control" type="text" name="spnsr_addr_link[]" placeholder="Enter Sponsor Link" /></td><td style="border-top: 0px solid #ddd;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
});

$(document).on('click', '.btn_remove', function(){  
var button_id = $(this).attr("id");   
$('#row'+button_id+'').remove();  
});

/* *********************JQuery Code To Add Coupons Dynamically ************************************ */

var i=1;  
$('#addCoupons').click(function(){  
i++;  
$('#coupons').append('<tr id="row'+i+'" class="dynamic-added"><td style="border-top: 0px solid #ddd;"><input class="form-control" id="coupon_code" name="coupon_code[]" type="text" style="width:95%" placeholder="Coupon Code" pattern="[0-9A-Za-z\\-]+" onkeydown="upperCase(this);" /></td><td style="border-top: 0px solid #ddd;"><select class="form-control" name="coupon_method[]" id="coupon_method" style="width:100%"> <option value="fixedprice">Fixed Price</option><option value="percentage">Percentage</option></select></td><td>&nbsp;&nbsp;&nbsp;</td><td style="border-top: 0px solid #ddd;"><input class="form-control" id="coupon_value" name="coupon_value[]" type="text" style="width:50%" placeholder="Value" /></td><td style="border-top: 0px solid #ddd;"><input type="text" class="form-control expiry_date" placeholder="Expiry Date" name="expiry_date[]" style="width:70%" /> </td><td style="border-top: 0px solid #ddd;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
});

$(document).on('click', '.btn_remove', function(){  
var button_id = $(this).attr("id");   
$('#row'+button_id+'').remove();  
});  


/* *********************JQuery Code To Add Coupons Dynamically Ends Here. ************************************ */

$(function (){

$("input[name='event']").click(function () {
if ($("#EvntYes").is(":checked")) {

var formats = [];
var ages = [];
var levels = [];
var gender = [];
$("input[name='level[]']:checked").each(function(){
var level=$(this).val();
var leveltext=$("span[for='"+level+"']").text();
//levels.push(leveltext);
levels.push({id:level,name:leveltext});
});
$("input[name='singles[]']:checked").each(function(){
var format=$(this).val();
formats.push(format);
});
$("input[name='age[]']:checked").each(function(){
var age=$(this).val();
ages.push(age);
});
//alert(ages);
var gend =$("input[name='gender_type']:checked").val();
if(gend != 'All'){
gender.push(gend);
}else{
gender.push(1,0);
}

var events = [];
var events1 = [];
var events2 = [];
jQuery.each( formats, function( i, fr ) {
jQuery.each( ages, function( j, ag ) {
jQuery.each( levels, function( k, lv ) {
jQuery.each( gender, function( l, gen ) {
events.push(gen+'-'+fr+'-'+ag+'-'+lv.name);
events1.push(gen+'_'+fr+'_'+ag+'_'+lv.id);   
events2.push(gen+'-'+fr+'-'+ag+'-'+lv.id); 

});
});
});
});
var eventtext="";
jQuery.each( events, function( i, evnt ) {
var get_stat = get_checkbox_checked_status(events2[i]);
var checked  = '';
var disabled1 = 'readonly';
var disabled2 = 'readonly';
if(get_stat){ 
checked  = 'checked'; 
disabled2 = ''; 
}

eventtext+='<div class="col-md-1 form-group internal"><input type=checkbox class='+events2[i]+' name=Limits[] value='+events1[i]+' '+checked+' readonly /></div><label class="control-label col-md-3" for="id_accomodation">'+evnt+'</label><div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control" name="limit['+events1[i]+']" placeholder="Enter Limit" '+disabled2+'></div>';
});

$("#div_event_section").show();   
}
else{
$("#div_event_section").hide();
}
});

$("input[name='event_fee']").click(function () {
if ($("#EvntFeesYes").is(":checked")) {

$("#div_event_fee_section").show();
$("#div_fee_section").hide();
$("#dyn_courts").hide();
}
else{
$("#div_fee_section").show();
$("#div_event_fee_section").hide();
$("#dyn_courts").show();
//$("#event_fee_section").hide();
}
});

$("input[name='event_time']").click(function () {
if ($("#EvntTimeYes").is(":checked")) {

var formats = [];
var ages = [];
var levels = [];
var gender = [];
$("input[name='level[]']:checked").each(function(){
var level=$(this).val();
var leveltext=$("span[for='"+level+"']").text();
levels.push({id:level,name:leveltext});

});
$("input[name='singles[]']:checked").each(function(){
var format=$(this).val();
formats.push(format);
});
$("input[name='age[]']:checked").each(function(){
var age=$(this).val();
ages.push(age);
});
//alert(ages);

var gend =$("input[name='gender_type']:checked").val();
if(gend != 'All'){
gender.push(gend);
}else{
gender.push(1,0);
}

var events = [];
var events1 = [];
var events2 = [];
jQuery.each( formats, function( i, fr ) {
jQuery.each( ages, function( j, ag ) {
jQuery.each( levels, function( k, lv ) {
jQuery.each( gender, function( l, gen ) {
events.push(gen+'-'+fr+'-'+ag+'-'+lv.name);
events1.push(gen+'_'+fr+'_'+ag+'_'+lv.id);
events2.push(gen+'-'+fr+'-'+ag+'-'+lv.id);
});
});
});
});

var eventtext="";
jQuery.each( events, function( i, evnt ) {
var get_stat = get_checkbox_checked_status(events2[i]);
var checked  = '';
var disabled1 = 'readonly';
var disabled2 = 'readonly';
if(get_stat){ 
checked  = 'checked'; 
disabled2 = ''; 
}
eventtext+='<div class="col-md-1 form-group internal"><input type=checkbox class='+events2[i]+' name=EventWiseTime[] '+checked+'  value='+events1[i]+' readonly /></div><label class="control-label col-md-3" for="id_accomodation">'+evnt+'</label> <div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventTime" name="time['+events1[i]+']" placeholder="Enter DateTime" '+disabled2+' /></div>';
});

//$("#div_event_time_section").html(eventtext);
$('.eventTime').fdatepicker({
format: 'mm/dd/yyyy hh:ii',
disableDblClickSelection: true,
language: 'en',
pickTime: true
});  
$("#div_event_time_section").show();
$("#time_section").hide();
}else{
$("#div_event_time_section").hide();
$("#time_section").show();
//$("#div_event_time_section").html('');
}
});

});


function yourFunction() {
$('#country').on('change', function() {
if ( this.value == 'United States of America'){
$("#state_drop").show();
$("#state_box").hide();
}
else{
$("#state_drop").hide();
$("#state_box").show();
}
});
}

});
</script>

<script type="text/javascript">
/*$(document).ready(function(){
$('#open_gender').click(function(){
//$("#mixed").removeAttr("disabled"); 
});

$('#male, #female').click(function(){
if ($("#mixed").is(":checked")){
$('#mixed').attr('checked', false);
}
//	$("#mixed").attr("disabled", true); 
});
});*/
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

</script>
<!-- -----------------end of Terms and conditions--------------------- -->

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
$("#shrt_cde").blur(function(){
var short_code = $(this).val();
if(short_code!=""){
$.ajax({
type:'POST',
url:baseurl+'league/CheckTorn_ShortCode/',
data:'short_code='+short_code,
success:function(res){
if(res>0){
$('#short_code_div').html(short_code+" is already exists!");
$("#shrt_cde").val('');
}else{
$('#short_code_div').empty();

}

}
}); 
}
});

});
</script>

<script>
$(document).ready(function(){
$('#myform').submit(function() {
if ( $("input[name='age[]']:checked").length == 0 ){ 
//alert("Select at least one Age group"); 
//return false;
return true;
}
else{ return true; }
});
});
</script>

<script>
$(document).ready(function(){
$('#myform').submit(function() {
if ($("input[name='singles[]']:checked").length == 0 && !$("#singles").is(':disabled')) { 
alert("Select at least one Match type"); 
return false;
}
else { return true; }
});
});
</script>

<script>
$(document).ready(function(){
$('#myform').submit(function() {
if ( $("input[name='level[]']:checked").length == 0 ) { 
alert("Select at least one Sport Level"); 
return false;
}
else { return true; }
});
});
</script>

<script>
$(document).ready(function(){
var baseurl = "<?php echo base_url();?>";
$('#Sport').on('change',function(){

var SportID = $(this).val();

$('#sport_levels_div').show();
$('#sport_levels_div_team').show();

if(SportID!=""){
//alert(SportID);
$.ajax({
type:'POST',
url:baseurl+'league/Sport_levels/',
data:'sport_id='+SportID,
success:function(html){
$('#sport_levels_div').html(html);
$('#sport_levels_div_team').html(html);
}
}); 
}
else{
$('#sport_levels_div').hide();
$('#sport_levels_div_team').hide();
}

$('#tourn_type').val();

if(SportID == 4){
$('#tourn_type').html("<option value=''>Select</option><option value='conventional'>Conventional</option><option value='drive_chip_putt'>Drive, Chip & Putt</option>");
$('#mtype').hide();
$(".x1").attr("disabled", true);
$('#eligibility_date_div').hide();
$("#eligibility_date").prop('required',false);
//$('#mtype_check:checkbox:enabled').attr('checked', false);
}
else if(SportID == 2){
$('#eligibility_date_div').show();
$("#eligibility_date").prop('required',true);
}
else{
$('#eligibility_date_div').hide();
$("#eligibility_date").prop('required',false);
$('#tourn_type').html("<option value=''>Select</option><option value='Single Elimination'>Single Elimination</option><option value='Consolation'>Consolation</option><option value='Round Robin'>Round Robin</option><option value='Flexible League'>Flexible League</option>");
if($("#tour_format").val() != "Teams"){
$('#mtype').show();
$(".x1").attr("disabled", false);
}	
}	
});	

}); 
</script>

<script>
$(document).ready(function(){
$('#Sport').on('change',function(){
var id = $(this).val();

if(id == '10' || id == '13' || id == '14' || id == '15' || id == '16' || id == '18'){
//if($.inArray($(this).val(), ['-1','10', '13', '14', '15', '16'])){
$('#tourn_format').hide();
$('#mtype').hide();
$('#addl_fee_div').hide();
$('#event_section').hide();
$('#generate_events').hide();
$('#event_fee_section').hide();
$('#event_time_section').hide();
$("#fee_type").show();
$(".x1").attr("disabled", true);
$("#second_section").show();
$("#confirm_proceed").hide();
$('#tourn_format1').show();
$('#tour_format1').val('Team Sport');
//alert($('#tour_format1').val());
}
else{
$('#tourn_format').show();
$('#tourn_format1').hide();
$('#second_section').hide();
$('#generate_events').show();
}
});
}); 
</script>

<!-- ************************ JQuery Code To Show / Hide USATT Block Starts Here. *********************** -->
<script>
	$(document).ready(function() {
		$('#Sport').change(function() {
			var sportid = $(this).val();
			if(sportid == 2){
				$('#USAAT_Info').show();
			}else{
				$('#USAAT_Info').hide();
			}
		});
	});
</script>
<!-- ************************ JQuery Code To Show / Hide USATT Block Ends Here. ***********************  -->
<!-- ************* JQuery Code To allow .gif,.png,.jpg,.jpeg,.pdf extensions only Starts Here. ***************  -->
<script>
	$(document).ready(function(){
		$('#myform').submit(function() {
			if($('#playinglevel').val() != ''){
				var ext = $('#playinglevel').val().split('.').pop().toLowerCase();
				if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
					alert("Invalid extension! Only 'gif, png, jpg, jpeg' extensions allowed.");
					return false;
				}
			}
			
			if($('#details_rules_pdf').val() != '' ) { 
				var ext1 = $('#details_rules_pdf').val().split('.').pop().toLowerCase();
			
				if(ext1 != 'pdf' ) { 
					alert("Invalid extension! Only 'pdf' files are allowed to upload for Details & Rules.");
					return false;
				}
			}

			if($('#medical_form_pdf').val() != '') {
				var ext2 = $('#medical_form_pdf').val().split('.').pop().toLowerCase();
			
				if(ext2 != 'pdf') {
					alert("Invalid extension! Only 'pdf' files are allowed to upload for Medical Release Form.");
					return false;
				}
			}
		});
	});
</script>
<!-- ************* JQuery Code To allow .gif,.png,.jpg,.jpeg,.pdf extensions only Ends Here. ***************  -->

<section id="single_player" class="container secondary-page"/>  
<div class="top-score-title right-score col-md-9">
<!-- Google AdSense -->
<div id='google' align='left'>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
style="display:block"
data-ad-client="ca-pub-9772177305981687"
data-ad-slot="1273487212"
data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<!-- Google AdSense -->
<div class="col-md-12 league-form-bg" style="margin-top:40px;">
<div class="fromtitle">Create a Tournament</div>
<p style="line-height:20px; font-size:13px">If you are an organization, business entity or just an active member of community and would like to organize sporting events, you can do that here. Start entering the details below. If you are simply looking to find a player to play one quick match, please click <b><a href="<?php echo base_url()."opponent"; ?>">Friendly Match</a></b>.</p><br /> 
<?php if($this->session->userdata('user')=="") { ?>

<p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to create tournament</p>
<?php } ?>
</div>

<?php if($this->session->userdata('user')!="") { ?>		           
<form class="form-horizontal" id='myform' method='post' role="form" enctype="multipart/form-data" action="<?php echo base_url(); ?>league/create_trnmt">  

<div class="col-md-12 league-form-bg" style="margin-top:30px;"> 
<div class="fromtitle">Tournament Details</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Sport Type</label>
<div class='col-md-8 form-group internal'>
<select name="sport_type" id="Sport" class='form-control' style="width:45%" required />
<option value="">Select</option>
<?php
foreach($intrests as $row) {
	if($row->SportFormat == 'TeamSport')
		$sp_format[] = $row->SportsType_ID;
?> 
<option value="<?php echo $row->SportsType_ID;?>"><?php echo $row->Sportname;?></option>
<?php } ?>
</select>
</div>
</div>
<?php

?>

<div class='form-group' id="tourn_format">
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Tournament Format</label>
<div class='col-md-8 form-group internal'>
<select name="tour_format" id="tour_format" class='form-control' style="width:45%" required />
<option value="Individual">Individual</option>
<option value="Teams">Team League</option>
</select>
</div>
</div>

<div class='form-group' style='display:none;' id="tourn_format1">
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Tournament Format</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' name="tour_format1" id="tour_format1" type="text" style="width:45%" readonly>
<!-- <b>Team League</b> -->
</div>
</div> 

<div class='form-group' id='num_lines_div' style='display:none;'>
<label class='control-label col-md-3' for='id_accomodation'>Select Lines# (Men's Singles)</label>
<div class='col-md-8 form-group internal'>
<select name="mens_singles_lines" id="mens_singles_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>
<label class='control-label col-md-3' for='id_accomodation'>Women's Singles </label>
<div class='col-md-8 form-group internal'>
<select name="womens_singles_lines" id="womens_singles_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>

<label class='control-label col-md-3' for='id_accomodation'>Men's Doubles</label>
<div class='col-md-8 form-group internal'>
<select name="mens_doubles_lines" id="mens_doubles_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>

<label class='control-label col-md-3' for='id_accomodation'>Women's Doubles</label>
<div class='col-md-8 form-group internal'>
<select name="womens_doubles_lines" id="womens_doubles_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>

<label class='control-label col-md-3' for='id_accomodation'>Mixed Doubles</label>
<div class='col-md-8 form-group internal'>
<select name="mixed_lines" id="mixed_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>

<label class='control-label col-md-3' for='id_accomodation'>Open Singles</label>
<div class='col-md-8 form-group internal'>
<select name="os_lines" id="os_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>

<label class='control-label col-md-3' for='id_accomodation'>Open Doubles</label>
<div class='col-md-8 form-group internal'>
<select name="od_lines" id="od_lines" class='form-control' style="width:45%" />
<?php for($i=0; $i<11; $i++){ ?>
<option value="<?=$i;?>"><?=$i;?></option>
<?php } ?>
</select>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Bracket Type</label>
<div class='col-md-8 form-group internal'>
<select id="tourn_type" name="tourn_type" class='form-control' style="width:45%" required />
<option value="">Select</option>
<option value="Single Elimination">Single Elimination</option>
<option value="Consolation">Consolation</option>
<option value="Round Robin">Round Robin</option>
<option value="Flexible League">Flexible League</option>
</select>
</div>
</div>

	<!-- Level Of The Tournament Starts Here. -->	
		<div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'> Level of the tournament</label>
            <div class='col-md-8 form-group internal'>
			<select id="star_level" name="star_level" class='form-control' style="width:45%"  />
				<option value="0">No Star</option>
				<option value="1">One Star (*)</option>
				<option value="2">Two Star (**)</option>
				<option value="3">Three Star (***)</option>
				<option value="4">Four Star (****)</option>
				<option value="5">Five Star (*****)</option>
			</select>
            </div>
        </div>
	<!-- Level Of The Tournament Ends Here. -->

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Tournament Title </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='title' name='title' type='text' required />
</div>
</div>

<!-- <div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Short URL </label>

<div class='col-md-6 form-group internal'>
<label class='control-label col-md-5' for='id_accomodation'>https://a2msports.com/</label>
<input class='form-control' id='shrt_cde' name='shrt_cde' type='text' style="width:50%;" placeholder='abcopen' />
<div id="short_code_div"></div>
</div>
</div> -->

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Organizer Name<br />(Company / Individual) </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='tourn_dir' name='organizer' type='text' autocomplete='off' required />
<input class='form-control' id='tourn_dir_id' name='organizer_id' type='hidden' />
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Contact Number </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='org_contact' name='org_contact' maxlength="15" type='text' style="width:64%;" required />
</div>
</div>


<div class="form-group">  
<label class='control-label col-md-3' for='id_accomodation'>Tournament Image </label>
<div class='col-md-6 form-group internal'>
<input id="playinglevel" name="TournamentImage" style="margin-bottom:28px" type="file"/>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>Start Date</label>
<div class='col-md-3 form-group internal'>
<div class='input-group date'>
<input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_start_date"
name="sdate" maxlength="10" required /> 
<span class="input-group-addon custom_datepicker" id='start_date' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>
</div>
<label class='control-label col-md-3' for='id_title'> Start Time</label>
<div class='col-md-3 form-group internal input-group bootstrap-timepicker timepicker'>
<input type="text" class='form-control' placeholder="hh:ii" id="start_time" name="stime" /> 
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>End Date</label>
<div class='col-md-3 form-group internal'>
<div class='input-group date'>
<input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_end_date"  name="edate" maxlength="10" required /> 
<span class="input-group-addon custom_datepicker" id='end_date' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>                 
</div>
<label class='control-label col-md-3' for='id_title'> End Time</label>
<div class='col-md-3 input-group bootstrap-timepicker timepicker'>
<input type="text" class='form-control' placeholder="hh:ii" id="end_time" name="etime"  /> 

</div>
</div>  

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>Registration opens on</label>
<div class='col-md-3 form-group internal'> 
<div class='input-group date'>
<input  type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_reg_opens_on" name="reg_openson" maxlength="10" required />
<span class="input-group-addon custom_datepicker" id='reg_opens_on' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>
</div>
<label class='control-label col-md-3' for='id_title'> Start Time</label>
<div class='col-md-3 form-group internal input-group bootstrap-timepicker timepicker'>
<input type="text" class='form-control' placeholder="hh:ii" id="regs_open_time" name="regopentime" /> 
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>Registration closes on</label>
<div class='col-md-3 form-group internal'> 
<div class='input-group date'>
<input type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_reg_closed_on" name="reg_closedon" maxlength="10" required />
<span class="input-group-addon custom_datepicker" id='reg_closed_on' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>
</div>
<label class='control-label col-md-3' for='id_title'> End Time</label>
<div class='col-md-3 input-group bootstrap-timepicker timepicker'>
<input type="text" class='form-control' placeholder="hh:ii" id="regs_close_time" name="regclosetime"  /> 

</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'> <font color='red'>* </font>WithDraw or Refund Date</label>
<div class='col-md-3 form-group internal'> 
<div class='input-group date'>
<input  type="text" class='form-control custom_date' placeholder="MM/DD/YYYY" id="custom_refund_date" name="refund_date" maxlength="10" required />
<span class="input-group-addon custom_datepicker" id='refund_date' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>
</div>
</div>

<div class='form-group' id="eligibility_date_div" style="display:none;">
<label class='control-label col-md-3' for='id_title'> Rating Eligibility Date</label>
<div class='col-md-3 form-group internal'>
<div class='input-group date'>
<input  type='text' class='form-control custom_date' placeholder='MM/DD/YYYY' id='custom_eligibility_date' maxlength="10" name='eligibility_date'/>
<span class="input-group-addon custom_datepicker" id='eligibility_date' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div>
</div>
</div>

<!-- <div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Maximum players for this tournament </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='max_players' name='max_players' type='text' style="width:25%">
</div>
</div> -->
<input class='form-control' id='max_players' name='max_players' type='hidden' style="width:25%"> <!-- to be removed -->


<div id = 'addr_group'>
<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Venue </label>
<div class='col-md-6 form-group internal'>
<input class='form-control' id='venue' name='venue' type='text' style="width:80%" required>
</div>
<div class='col-md-3 form-group internal' style="margin-top:6px; margin-left:1px">&nbsp;</div> 
</div> 

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Address Line1 </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='addr1' name='addr1' type='text' style="width:80%" required>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Address Line2 </label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='addr2' name='addr2' type='text' style="width:80%">
</div>
</div>
</div> 

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Country</label>
<div class='col-md-4 form-group internal'>
<select class='form-control' id='country' name='country' required>
<option value="">Select</option>
<?php
$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

foreach($countries as $country){
$selected = "";
if($user_details['Country'] == $country){
$selected = " selected";
}
echo "<option value='$country'{$selected}>$country</option>";
}
?>
</select>
</div>
</div>

<div class='form-group' style='display:none;' id='state_box'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> State</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='state1' name='state1' type='text' style="width:45%">
</div>
</div>

<div class='form-group' id="state_drop">
<label class='control-label col-md-3' for='id_title'><font color='red'>* </font> State</label>
<div class='col-md-4 form-group internal'>
<select name="state" id="state" class='form-control'">
<option value="">Select</option>
<?php
$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','District of Columbia','Florida','Georgia',
'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma', 'Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia',
'Wisconsin','Wyoming'); 
foreach($states as $state){
$selected = "";
if($user_details['State'] == $state){
$selected = " selected";
}
echo "<option value='$state'{$selected}>$state</option>";
}
?>
</select>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> City</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='city' name='city' type='text' style="width:45%" required>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Postal Code</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='zipcode' name="zipcode" type='text' style="width:45%" required>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Details and Rules</label>
<div class='col-md-7 form-group internal'>
<textarea name="desc" class="txt-area" id="desc" cols="20" rows="2"></textarea>
</div>
</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Details and Rules (PDF)</label>
	<div class='col-md-7 form-group internal'>
		<input id="details_rules_pdf" name="details_rules_pdf" style="margin-bottom:28px" type="file"/>
	</div>
	</div>

	<div class='form-group'>
	<label class='control-label col-md-3' for='id_accomodation'>Medical Release (PDF)</label>
	<div class='col-md-7 form-group internal'>
	  <input id="medical_form_pdf" name="medical_form_pdf" style="margin-bottom:28px" type="file"/>
	</div>
	</div>

</div>  

<!--<div class="col-md-12 league-form-bg" style="margin-top:30px; display:none;" id="team_event_section"> 
<div class="fromtitle">Game Formats</div>

<div id='sport_levels_div_team' class='form-group' style="display:none">
<label class='control-label col-md-3' for='id_accomodation'> Levels </label>
<?php
$sp_level = array();
if($this->input->post('level'))	{
$sp_level = $this->input->post('level');
}
?>
<div  class='col-md-8 form-group internal'>
<?php foreach($sport_levels as $row){ ?>
<input type="checkbox" class="ajax_click" name="level[]" <?php if(in_array($row->SportsLevel_ID, $sp_level)){echo "checked = checked"; } ?> value="<?php echo $row->SportsLevel_ID;?>" /><label><?php echo $row->SportsLevel;?></label>
<?php } ?>
</div>
</div>

<div class='form-group' id='mtype'>
<label class='control-label col-md-3' for='id_accomodation'><font color="red">* </font> Match Type</label>
<div class='col-md-5 form-group internal' id='mtype_check'>
<input type="checkbox" class='x1' name="singles[]" id="singles" value="Singles"><label class='control-label' for='singles'>Singles&nbsp;</label>
<input type="checkbox" class='x1' name="singles[]" id="doubles" value="Doubles"> <label class='control-label' for='doubles'>Doubles&nbsp;</label>
<input type="checkbox" class='x1' name="singles[]" id="mixed" value="Mixed"> <label class='control-label' for='mixed'>Mixed Doubles</label>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'><font color="red">* </font> Age Group</label>
<div class='col-md-7 form-group internal'>
<input type="checkbox" class='age' id='age_u9' name="age[]" value="U9"><label class='control-label' for='age_u9'>Under 9 &nbsp;</label>
<input type="checkbox" class='age' id='age_u10' name="age[]" value="U10"><label class='control-label' for='age_u10'>Under 10 &nbsp;</label>
<input type="checkbox" class='age' id='age_u11' name="age[]" value="U11"><label class='control-label' for='age_u11'>Under 11 &nbsp;</label>
<input type="checkbox" class='age' id='age_u12' name="age[]" value="U12"><label class='control-label' for='age_u12'>Under 12 &nbsp;</label>
<input type="checkbox" class='age' id='age_u13' name="age[]" value="U13"><label class='control-label' for='age_u13'>Under 13 &nbsp;</label><br/>
<input type="checkbox" class='age' id='age_u14' name="age[]" value="U14"> <label class='control-label' for='age_u14'>Under 14 &nbsp;</label>
<input type="checkbox" class='age' id='age_u15' name="age[]" value="U15"><label class='control-label' for='age_u15'>Under 15 &nbsp;</label>
<input type="checkbox" class='age' id='age_u16' name="age[]" value="U16"> <label class='control-label' for='age_u16'>Under 16 &nbsp;</label>
<input type="checkbox" class='age' id='age_u17' name="age[]" value="U17"><label class='control-label' for='age_u17'>Under 17 &nbsp;</label><br/>
<input type="checkbox" class='age' id='age_u18' name="age[]" value="U18"> <label class='control-label' for='age_u18'>Under 18 &nbsp;</label><br />
<input type="checkbox" class='age' id='age_u19' name="age[]" value="U19"><label class='control-label' for='age_u19'>Under 19 &nbsp;</label>
<input type="checkbox" class='age' id='age_adults' name="age[]" value="Adults"> <label class='control-label' for='age_adults'>Adults&nbsp;</label>
<input type="checkbox" class='age' id='age_30p' name="age[]" value="Adults_30p"> <label class='control-label' for='age_30p'>30s&nbsp;&nbsp;</label>
<input type="checkbox" class='age' id='age_40p' name="age[]" value="Adults_40p"> <label class='control-label' for='age_40p'>40s&nbsp;&nbsp;</label>
<input type="checkbox" class='age' id='age_50p' name="age[]" value="Adults_50p"> <label class='control-label' for='age_50p'>50s&nbsp;&nbsp;</label>
<input type="checkbox" class='age' id='veteran' name="age[]" value="Adults_veteran"> <label class='control-label' for='veteran'>Veteran</label>
</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'> <font color="red">* </font> Gender</label>
<div class='col-md-8 form-group internal'>
<input type="radio" name="gender_type" id="male" value="1" /> <label class='control-label' for='male'> Male Only&nbsp;&nbsp;</label>
<input type="radio" name="gender_type" id="female" value="0" /><label class='control-label' for='female'> Female Only</label>
<input type="radio" name="gender_type" id="open_gender" value="All" /> <label class='control-label' for='open_gender'>  Open to All&nbsp;&nbsp; </label>
</div>
</div>

</div> -->

<!-------------------------- New Functionality Starts Here & Added By Me------------------------------------------->
<div class="col-md-12 league-form-bg" style="margin-top:30px;" > 
<div class="fromtitle">Events</div>   

<div id='sport_levels_div' class='form-group' style="display:none">
<label class='control-label col-md-3' for='id_accomodation'> Levels </label>
<?php
$sp_level = array();
if($this->input->post('level'))	{
$sp_level = $this->input->post('level');
}
?>
<div  class='col-md-8 form-group internal'>
<?php foreach($sport_levels as $row) { ?>
<input type="checkbox" class="ajax_click" name="level[]" <?php if(in_array($row->SportsLevel_ID, $sp_level)){echo "checked = checked"; } ?> value="<?php echo $row->SportsLevel_ID;?>" />
<label for="<?php echo $row->SportsLevel_ID;?>">
<?php echo $row->SportsLevel;?>
</label>
<?php } ?>
</div>
</div>

<div class='form-group' id='mtype' style='padding-bottom: 10px;'>
<label class='control-label col-md-3' for='id_accomodation'>
<font color='red'>* </font> <b>Match Type:</b>
</label>
	<div class='col-md-5 form-group internal' id='mtype_check'>
	<input type="checkbox" class='x1' name="singles[]" id="singles" value="Singles"><label class='control-label' for='singles'>&nbsp;Singles&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="checkbox" class='x1' name="singles[]" id="doubles" value="Doubles"><label class='control-label' for='doubles'>&nbsp;Doubles&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	<input type="checkbox" class='x1' name="singles[]" id="mixed" value="Mixed"><label class='control-label' for='mixed'>&nbsp;Mixed Doubles&nbsp;&nbsp;&nbsp;&nbsp;</label>
	</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_title'><font color="red">* </font> <b>Age Group:</b></label>
<div class='col-md-9 form-group internal' style='padding-bottom: 10px;'>

<div class='row'>

	<div class='col-md-2 col-xs-4'>
		<input type="checkbox" class='age' id='age_u9' name="age[]" value="U9"><label class='control-label' for='age_u9'>&nbsp;Under 9</label>
		<br>
		<input type="checkbox" class='age' id='age_u10' name="age[]" value="U10"><label class='control-label' for='age_u10'>&nbsp;Under 10</label>
		<br>
		<input type="checkbox" class='age' id='age_u11' name="age[]" value="U11"><label class='control-label' for='age_u11'>&nbsp;Under 11</label>
		<br>
		<input type="checkbox" class='age' id='age_u12' name="age[]" value="U12"><label class='control-label' for='age_u12'>&nbsp;Under 12</label>
		<br>
		<input type="checkbox" class='age' id='age_u13' name="age[]" value="U13"><label class='control-label' for='age_u13'>&nbsp;Under 13</label>		

	</div>

	<div class='col-md-2 col-xs-4'>
		<input type="checkbox" class='age' id='age_u14' name="age[]" value="U14"><label class='control-label' for='age_u14'>&nbsp;Under 14</label>
		<br>
		<input type="checkbox" class='age' id='age_u15' name="age[]" value="U15"><label class='control-label' for='age_u15'>&nbsp;Under 15</label>
		<br>
		<input type="checkbox" class='age' id='age_u16' name="age[]" value="U16"><label class='control-label' for='age_u16'>&nbsp;Under 16</label>
		<br>
	</div>

	<div class='col-md-2 col-xs-4'>
		<input type="checkbox" class='age' id='age_u17' name="age[]" value="U17"><label class='control-label' for='age_u17'>&nbsp;Under 17</label>
		<br>
		<input type="checkbox" class='age' id='age_u18' name="age[]" value="U18"><label class='control-label' for='age_u18'>&nbsp;Under 18</label>
		<br>
		<input type="checkbox" class='age' id='age_u19' name="age[]" value="U19"><label class='control-label' for='age_u19'>&nbsp;Under 19</label>
	</div>

	<div class='col-md-2 col-xs-4'>
		<input type="checkbox" class='age' id='age_30p' name="age[]" value="Adults_30p"><label class='control-label' for='age_30p'>&nbsp;30s</label>
		<br>
		<input type="checkbox" class='age' id='age_40p' name="age[]" value="Adults_40p"><label class='control-label' for='age_40p'>&nbsp;40s</label>
		<br>
		<input type="checkbox" class='age' id='age_50p' name="age[]" value="Adults_50p"><label class='control-label' for='age_50p'>&nbsp;50s&nbsp;</label>
	</div>

	<div class='col-md-3 col-xs-4'>			
		<input type="checkbox" class='age' id='age_adults' name="age[]" value="Adults"><label class='control-label' for='age_adults'>&nbsp;Adults/Open</label>
		<br>
		<input type="checkbox" class='age' id='Junior' name="age[]" value="Junior"><label class='control-label' for='Junior'>&nbsp;Junior</label>
		<br>
		<input type="checkbox" class='age' id='veteran' name="age[]" value="Adults_veteran"><label class='control-label' for='veteran'>&nbsp;Veteran</label>

	</div>

</div>

</div>
</div>

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'> <font color="red">* </font><b>Events for:</b></label>
<div class='col-md-8 form-group internal'>
	<div class='row'>
		<div class='col-md-4 col-xs-12'>
		<input type="checkbox" class="gender" name="gender_type[]" id="male" value="1" /><label class='control-label' for='male'>&nbsp;Men's/Boy's Only</label>
		</div>
		<div class='col-md-4 col-xs-12'>
		<input type="checkbox" class="gender" name="gender_type[]" id="female" value="0" /><label class='control-label' for='female'>&nbsp;Women's/Girl's Only</label>
		</div>
		<div class='col-md-4 col-xs-12'>
		<input type="checkbox" class="gender" name="gender_type[]" id="open_gender" value="Open" /><label class='control-label' for='open_gender'>&nbsp;Open to All</label>
		</div>
	</div>
</div>
</div>
<div id="generate_events" >
<div align='center'>
<input type="button" value="Generate Events" name='create_tourn' id="Combinations" style="margin-top:20px" class="league-form-submit" onclick="genEventsCombi();"/>
</div>

<font color='red'><br /><b><span id='EventsID'></span></b></font>
<div class='form-group' id="combinationsResult"></div>
<br />
<font color='blue'><b><span id='ListCount'></span></b></font>
<div class='form-group' id="selectedEventsList"></div>
<div class='form-group' id="customCombined">
Do you want to add custom combined age events? 
<input type='radio' name='custom_com_age' id='custom_com_age_yes' value='1' /> Yes
<input type='radio' name='custom_com_age' id='custom_com_age_no' value='0' checked /> No
	<div class='form-group' id="customCombined_opts" >
		<select id='customCombined_select' name='customCombined_select'>
		<option value='A70'>Combined 70+</option>
		<option value='A80'>Combined 80+</option>
		<option value='A90'>Combined 90+</option>
		</select>&nbsp;
		<input type='number' name='custom_combi_min_age' id='custom_combi_min_age' value='' placeholder='Min. Age' />&nbsp;
		<select id='customCombined_gender' name='customCombined_gender'>
		<option value='2'>Open</option>
		<option value='1'>Men's</option>
		<option value='0'>Women's</option>
		</select>&nbsp;

		<a id='add_custom_combi' style='cursor:pointer;'><b>ADD</b></a>
		<br /><br /><br />
	</div>
</div>
<div id='comb_select_div'></div>
</div>

<div align="center">
<input style='display:none' type="button" class='league-form-submit' name="confirm_proceed" id="confirm_proceed" value="Confirm & Proceed" />
</div>
</div>  


<!--</div> -->
<!-------------------------- New Functionality Ends Here ---------------------------------------------------------->	

<div id='second_section' style='display:none;'>

<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="event_section">
<div class="fromtitle">Limits</div>
Do you want to add limit to Events&nbsp;
<label for="EvntYes"><input type="radio" id="EvntYes" name="event" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="EvntNo"><input type="radio" id="EvntNo" name="event" value="0" checked="checked" /> No<br /></label>

<div class='form-group' id="div_event_section" style="display:none;" >
<div id='Events' style="display:block;">
Events:
</div>
</div> 												<!-- Events Section end -->
</div>

<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Sponsors</div>
Do you want to add sponsors&nbsp;
<label for="SpnsrYes"><input type="radio" id="SpnsrYes" name="sponser" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="SpnsrNo"><input type="radio" id="SpnsrNo" name="sponser" value="0" checked="checked" /> No<br /></label>

<div id="div_sponser_section" style="display:none;">	<!-- Sponsor Section -->

<div id='Sponsers' style="display:block;">

<table id="dynamic_field">  
<tr>  
<td style="border-top: 0px solid #ddd;"><input style="font-size:14px;" type="file"  name="spnsr_file_name[]" /></td>  
<td style="border-top: 0px solid #ddd;"><input class='form-control' type="text"  name="spnsr_addr_link[]" placeholder="Enter Sponsor Link" /></td>  
<td style="border-top: 0px solid #ddd;"><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
</tr>  
</table>  

</div>
</div>												<!-- Sponsor Section end -->
</div>

<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="event_time_section">
<div class="fromtitle">Event Times</div>
Do you want to add start time for different events?&nbsp;
<label for="EvntTimeYes"><input type="radio" id="EvntTimeYes" name="event_time" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="EvntTimeNo"><input type="radio" id="EvntTimeNo" name="event_time" value="0" checked="checked" /> No<br />
</label>

<div class='form-group' id="div_event_time_section" style="display:none;" >
<div id='Event_time' style="display:block;">
Events:		
</div>	
</div> 												<!-- Events wise Time Section end -->
</div>

<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="fee_section">
<div class="fromtitle">Fees</div>
Do you want to collect the fees for the tournament?&nbsp;
<label for="chkYes"><input type="radio" id="chkYes" name="fee" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="chkNo"><input type="radio" id="chkNo" name="fee" value="0" checked="checked" /> No<br /></label>

<div id="div_fee_section" style="display:none;">	<!-- Fee Section -->

<div id='fee_type' style="display:block;">
Fee to be paid per Team or Player?&nbsp;
<label for="perTeam"><input type="radio" id="perTeam" name="fee_collect_method" value="Team" checked="checked" /> Per Team</label>&nbsp;&nbsp;
<label for="perPlayer"><input type="radio" id="perPlayer" name="fee_collect_method" value="Player" /> Per Player<br /></label>
</div>

<div class='col-md-12' style='padding-bottom:4px;'>
<div class='col-md-2' style='padding-top:5px;'>&nbsp;</div>
<div class='col-md-2'>First Event</div>
<div class='col-md-2' id='addl_fee_div'>Additional Events</div>
</div>

<div id='dyn_courts'><!-- Dynamic Add New Courts Area --></div> 
</div>												<!-- Fee Section end -->

<div id="event_fee_section"  style="display:none;" >
Do you want to collect different amounts for different events?&nbsp;
<label for="EvntFeesYes"><input type="radio" id="EvntFeesYes" name="event_fee" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="EvntFeesNo"><input type="radio" id="EvntFeesNo" name="event_fee" value="0" checked="checked" /> No<br /></label>

<div class='form-group' id="div_event_fee_section" style="display:none;" >
<div id='Event_fees' style="display:block;">
Events:
</div>
</div> 	
</div>											<!-- Events wise Fees Section end -->
</div>

<!-- ********************** CouponCode Section Starts Here. ******************************* -->
<div id="couponCode_section" class="col-md-12 league-form-bg" style="margin-top:30px; display:none;">
<div class="fromtitle">CouponCode Details </div>
Do you want to provide coupon codes?&nbsp;
<label for="ccYes"><input type="radio" id="ccYes" name="cc" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="ccNo"><input type="radio" id="ccNo" name="cc" value="0" checked="checked" /> No<br /></label>


<div id="couponCode_details" name="couponCode_details" style="display:none">

<div id='CouponCodes' style="display:block;">

<table id="coupons">  
<tr>  
<td style="border-top: 0px solid #ddd;">
<input class='form-control' id="coupon_code" name="coupon_code[]" type="text" style="width:95%" placeholder="Coupon Code" pattern="[0-9A-Za-z\\-]+" onkeydown="upperCase(this)" />
</td>  
<td style="border-top: 0px solid #ddd;">
<select class="form-control" name="coupon_method[]" id="coupon_method" style="width:100%"> 
<option value="fixedprice">Fixed Price</option>
<option value="percentage">Percentage</option>
</select>
</td>
<td>&nbsp;&nbsp;&nbsp;</td>
<td style="border-top: 0px solid #ddd;">
<input class='form-control' id="coupon_value" name="coupon_value[]" type="text" style="width:50%" placeholder="Value" /> 
</td>
<td style="border-top: 0px solid #ddd;">
<div class='input-group date'>
<input type="text" class='form-control custom_date' placeholder="Expires On(MM/DD/YYYY)" name="expiry_date[]" id="custom_expiry_date" style="width:100%" maxlength="10"  /> 
<span class="input-group-addon custom_datepicker" id='expiry_date' style="cursor:pointer;">
<span class="fa fa-calendar"></span> 
</span>
</div> 
</td>

<td style="border-top: 0px solid #ddd;"><button type="button" name="addCoupons" id="addCoupons" class="btn btn-success">Add More</button></td>  
</tr>  
</table>  

</div>  

</div>
</div>
<!-- ************************* CouponCode Section Ends Here.	   *********************** -->

	<!-- ********************** Payment Details starts here. ****************************** -->
		<div id="payment_details" class="col-md-12 league-form-bg" style="margin-top:30px; display:none;">
		<div class="fromtitle">Payment Options </div>
		 <div class="col-md-5" style="padding-left: 0px;">Please select payment option ?</div>&nbsp;&nbsp;&nbsp;
		 <div class='form-group internal col-md-12' style="margin-left:220px; margin-top:-25px;"> 
			<select name="pay_options" id="pay_options" class='form-control' style="width:25%; text-align:center; vertical-align: middle;">
				<option value="">--Select--</option>
				<option value="paypal">Paypal</option>
				<option value="paytm">Paytm</option>
			</select>
		</div> 
		</div>
		
	<!-- ********************** Payment Details ends here. ******************************* -->

<!-- ************************* Paypal Details Section Starts Here. *********************** -->
<div id="paypal_details" class="col-md-12 league-form-bg" style="margin-top:30px; display:none;">
<div class="fromtitle">PayPal Details </div>
Do you have PayPal Account to receive the fund (Registration charges)?&nbsp;
<label for="ppYes"><input type="radio" id="ppYes" name="pp" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="ppNo"><input type="radio" id="ppNo" name="pp" value="0" checked="checked" /> No<br /></label>


<div id="paypal_ids" style="display:none;">
Paypal EmailID (Merchant):   
<select name="ppids" id="ppids">
<option value="">--Select--</option>
<?php foreach($paypal_ids as $ppids) { ?>
<option value="<?=$ppids->pp_busi_id;?>"><?=$ppids->paypal_merch_id;?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" name="addppids" id="addppids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
</div>

<div id="ppYesNo" style="display:none;">
<div class='form-group' style="margin-bottom:0px !important;">
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
<div class='col-md-4 form-group internal'>
<input class='form-control' id='merchantid' name='merchantid' type='text' />&nbsp; 
</div>
<div class="col-md-5">
<img src="<?=base_url();?>icons/info_ico.png" title="Paypal Business Account EmailID " width="25px" height="25px" />
</div>
</div>

<!-- <div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>* Secret Key</label>
<div class='col-md-8 form-group internal'>
<input class='form-control' id='secretcode' name='secretcode' type='text' style="width:50%">
</div>
</div> -->

<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Currency Type</label>
<div class='col-md-8 form-group internal'>
<select name="currency_code" id="currency_code" class='form-control' style='width:30%'>
<option value="">--Select--</option>
<?php foreach($currency_codes as $ccodes)	{ ?>
<option value="<?=$ccodes->code;?>" <?php if($ccodes->code == 'USD'){ echo "selected"; } ?>><?=$ccodes->code;?></option>
<?php } ?>
</select>
</div>
</div>
</div> 
</div>  
<!--************************* Paypal Details Section Ends Here. *********************** -->

	<!-- ************************* Paytm Details Section Starts Here. *********************** -->

	<div id="paytm_details" class="col-md-12 league-form-bg" style="margin-top:30px; display:none;">
	<div class="fromtitle">Paytm Details </div>
		Do you have Paytm Account to receive the fund (Registration charges)?&nbsp;
			<label for="ptmYes"><input type="radio" id="ptmYes" name="petm" value="1" /> Yes</label>&nbsp;&nbsp;
			<label for="ptmNo"><input type="radio" id="ptmNo" name="petm" value="0" checked="checked" /> No<br /></label>
			 
 
			<div id="paytm_ids" style="display:none;">
			Paytm ID (Merchant):   
				<select name="ptmids" id="ptmids">
					<option value="">--Select--</option>
					<?php foreach($paytm_ids as $petmids) { ?>
							<option value="<?=$petmids->paytm_merch_id;?>"><?=$petmids->paytm_merch_id;?></option>
					<?php } ?>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" name="addptmids" id="addptmids" class="btn btn-success" style="border-top: 0px solid #ddd; display:none;">Add New ID</button>  
			</div>

   	<div id="peTmYesNo" style="display:none;">
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant ID </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='paytm_merchantid' name='paytm_merchantid' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
				<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business AccountID " width="25px" height="25px" />
				</div>
			</div>

		   <!-- <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>* Secret Key</label>
            <div class='col-md-8 form-group internal'>
              <input class='form-control' id='secretcode' name='secretcode' type='text' style="width:50%">
            </div>
          </div>

			<div class='form-group'>
			<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Currency Type</label>
				<div class='col-md-8 form-group internal'>
					<select name="currency_code" id="currency_code" class='form-control' style='width:30%'>
					<option value="">--Select--</option>
					<?php foreach($currency_codes as $ccodes)	{ ?>
					<option value="<?=$ccodes->code;?>" <?php if($ccodes->code == 'USD'){ echo "selected"; } ?>><?=$ccodes->code;?></option>
					<?php } ?>
					</select>
				</div>
			</div>  -->
			<div class='form-group' style="margin-bottom:0px !important;">
				<label class='control-label col-md-3' for='id_accomodation'><font color='red'>* </font> Merchant Key </label>
				<div class='col-md-4 form-group internal'>
				<input class='form-control' id='merchantKey' name='merchantKey' type='text' />&nbsp; 
				</div>
				<div class="col-md-5">
			<!--<img src="<?=base_url();?>icons/info_ico.png" title="Paytm Business Account EmailID " width="25px" height="25px" />-->
				</div>
			</div>

 		</div> 
 	</div>
	<!-- ************************* Paytm Details Section Ends Here. ************************* -->
<!-- T-Shirt Section Start -->
<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="TShirt_Info">
<div class="fromtitle">T-Shirts</div>
Do you want to collect T-Shirt Information&nbsp;
<label for="T-ShirtYes"><input type="radio" id="T-ShirtYes" name="T-Shirt" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="T-ShirtNo"><input type="radio" id="T-ShirtNo" name="T-Shirt" value="0" checked="checked" /> No<br /></label>
<!-- <div id='is_tshirt_fee' style='display:none;'>
Do you want to charge for the T-Shirt?&nbsp;
<label for="T-ShirtYesFee"><input type="radio" id="T-ShirtYesFee" name="is_shirt_fee" value="1" /> Yes</label>&nbsp;&nbsp;
<label for="T-ShirtNoFee"><input  type="radio" id="T-ShirtNoFee" name="is_shirt_fee" value="0" checked="checked" /> 
No
<br /></label>
</div>
<div id='tshirt_fee_div' style='display:none;'>
Amount: &nbsp;
<input class='form-control' id="tshirt_fee" name="tshirt_fee" type="text" style="width:15%" placeholder="" /> 
<br /></label>
</div> -->
</div>
<script>
/*$(document).ready(function(){
	$('input[name="T-Shirt"]').click(function(){
		//console.log($(this).val());
		if($(this).val() == 1){
			$('#is_tshirt_fee').show();
		}
		else{
			$('#is_tshirt_fee').hide();
		}
	});
	
	$('input[name="is_shirt_fee"]').click(function(){
		//console.log($(this).val());
		if($(this).val() == 1){
			$('#tshirt_fee_div').show();
		}
		else{
			$('#tshirt_fee').val('');
			$('#tshirt_fee_div').hide();
		}
	});

});*/
</script>
<!-- T-Shirt Section end -->


	<!-- USAAT Section Start -->
	<div class="col-md-12 league-form-bg" style="margin-top:30px;" id="USAAT_Info" style="display:none">
	<div class="fromtitle">USATT</div>
	Is this USATT sanctioned tournament? &nbsp;
	<label for="USATTYes"><input type="radio" id="USATTYes" name="USATTInfo" value="1" /> Yes</label>&nbsp;&nbsp;
	<label for="USATTNo"><input type="radio" id="USATTNo" name="USATTInfo" value="0" checked="checked" /> No<br /></label>
	</div> 
    <!-- USAAT Section end -->
	

<script>
$(document).ready(function(){
$('#myform').submit(function() {
if (!($('#recommend').is(':checked'))) {
alert("Please accept the Terms & Conditions");
return false;
}
else { return true; }
});

});
</script>


<div class="col-md-12 league-form-bg" style="margin-top:30px;">
<div class="fromtitle">Publish </div>
Do you want to publish the tournament?&nbsp;
<label for="is_publish_yes">
<input type="radio" id="is_publish_yes" name="is_publish" value="1" checked="checked"  /> Yes
</label>&nbsp;&nbsp;
<label for="is_publish_no">
<input type="radio" id="is_publish_no" name="is_publish" value="0" /> No
</label>

<div id="academy_text" style="display: none">
<div class='form-group'>
<label class='control-label col-md-3' for='id_accomodation'>Academy Name: </label>
<div class='col-md-6 form-group internal'>
<input id='academy' name="club_name" class='ui-autocomplete-input col-md-3 form-control ajax_blur' type="text" placeholder="Type your Club Name" />
<input class='form-control' id='org_id' name='org_id' type='hidden' placeholder="Org_id" value=""  />
</div>
</div> 
</div>

</div>


<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px;">
<div class="fromtitle">Review & Submit</div>

<div class='form-group'>
<div class='col-md-12 form-group internal input-group' style="font-size:13px; margin-left:25px">

<br>
<input type="checkbox" name="recommend" id="recommend" value="1" />
I accept the <a style='cursor:pointer;' onclick='terms_conditions()'><b>Terms & Conditions</b></a> of A2M Sports. I'm responsible for conducting the tournament and accept full responsibility that for any personnel, financial and legal issues that may arise.<br />

<input type="submit" value="Submit" name='create_tourn' style="margin-top:20px" class="league-form-submit" />
</div>
</div>
</div> 

</div>   <!-- End of second section div -->

</form>
<?php } ?>
<br />
<div style="clear:both"></div>
</div><!--Close Top Match -->

<script src="<?=base_url();?>js/custom/gen_multi_events.js"></script>
<script>

$(document).ready(function(){

$('#combinationsResult').on('click', '#SelectAll', function(){		// Select All functionality
if($(this).prop('checked')){
//alert($(this).prop('checked'));
$(".CombiChecked").each(function () {
$(this).prop('checked', true);
selectedEventsList.push({
item : $(this).next('span').html(),
value : $(this).val()
});
});
}
else{
$(".CombiChecked").each(function () {
$(this).prop('checked', false);
var removeItem = $(this).val();
selectedEventsList = jQuery.grep(selectedEventsList, function(data){
return data.value != removeItem;
});
});
}

$('#selectedEventsList').html('');

//if(count(selectedEventsList) > 0){
$('#ListCount').html('Selected List of Events are: ('+selectedEventsList.length+')');
//}


$.each(selectedEventsList, function(index, values){
$('#selectedEventsList').append(values.item);
$('#selectedEventsList').append("<br />");
});


if(selectedEventsList.length > 0){
//$('#confirm_proceed').attr('disabled',false);
$('#confirm_proceed').show();
$('#customCombined').show();
}
else{
//$('#confirm_proceed').attr('disabled',true);
$('#confirm_proceed').hide();
$("#second_section").hide();
}
});		// End of Select All functionality

$('#combinationsResult').on('click', '.CombiChecked', function(){

$("#second_section").hide();

if($(this).prop('checked') === true){
selectedEventsList.push({
item : $(this).next('span').html(),
value : $(this).val()
});
}
else{
var removeItem = $(this).val();
selectedEventsList = jQuery.grep(selectedEventsList, function(data) {
return data.value != removeItem;
});
}

$('#selectedEventsList').html('');

//if(count(selectedEventsList) > 0){
$('#ListCount').html('Selected List of Events are: ('+selectedEventsList.length+')');
//}


$.each(selectedEventsList, function(index, values){
$('#selectedEventsList').append(values.item);
$('#selectedEventsList').append("<br />");
});


if(selectedEventsList.length > 0){
//$('#confirm_proceed').attr('disabled',false);
$('#confirm_proceed').show();
$('#customCombined').show();
}
else{
//$('#confirm_proceed').attr('disabled',true);
$('#confirm_proceed').hide();
$("#second_section").hide();
}

});

$("#confirm_proceed").click(function(){
$('#div_event_section').empty();
$('#div_event_time_section').empty();
$('#div_event_fee_section').empty();
$("#second_section").show();

$.each(selectedEventsList, function(index, values1){
// Event Limits Section
$('#div_event_section').append('<div class="col-md-1 form-group internal"></div><label class="control-label col-md-3" for="id_accomodation">'+values1.item+'</label><div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control txt_'+values1.value+'" name="limit['+values1.value+']" placeholder="Enter Limit" ></div>');
// Event Time Section
$('#div_event_time_section').append('<div class="col-md-1 form-group internal"></div><label class="control-label col-md-3" for="'+values1.value+'">'+values1.item+'</label> <div class="col-md-8 form-group internal"><input type="text" style="width:40%;" class="form-control eventTime txt_'+values1.value+'" name="time['+values1.value+']" placeholder="Enter DateTime" /></div>');

// Event Multi Fee Section
$('#div_event_fee_section').append("<div class='col-md-1 form-group internal'></div><label class='control-label col-md-3' for='"+values1.value+"'>"+values1.item+"</label> <div class='col-md-8 form-group internal'><input type='text' style='width:40%;' class='form-control txt_"+values1.value+"' name='fees["+values1.value+"]' placeholder='Enter Fee' /></div>");
});
});

});
</script>

<script>
	$(document).ready(function() {
		$("input[name='fee']").click(function (){
			var country_val = $('#country').val();
			if ($("#chkYes").is(":checked")) {
				if(country_val == 'India'){
					$('#payment_details').show();
					$('#paypal_details').hide();
				}else{
					$('#payment_details').hide();
					$('#paypal_details').show();
				}
			}else{
				$('#paypal_details').hide();
				$('#payment_details').hide();
			}
		});

		$('#custom_com_age_yes').click(function(){
			$('#customCombined_opts').show();
		});

		$('#custom_com_age_no').click(function(){
			$('#customCombined_opts').hide();
		});

		$('#add_custom_combi').click(function(){
			var x			= $('#customCombined_select').val();
			var x_text	= $('#customCombined_select option:selected').text();
			var y			= $('#customCombined_gender').val();
			var y_text	= $('#customCombined_gender option:selected').text();
			var z			= $('#custom_combi_min_age').val();
			var z_text	= $('#custom_combi_min_age').val();

			selectedEventsList.push({
			item : x_text+' (min. age: '+z_text+')',
			value : x+'-'+y+'-'+z
			});

			$('#selectedEventsList').html('');

			$.each(selectedEventsList, function(index, values){
			$('#selectedEventsList').append(values.item);
			$('#selectedEventsList').append("<br />");
			});

			$('#comb_select_div').append("<input type='checkbox' id='"+x+'-'+y+'-Doubles-'+z+"' class='CombiChecked' name='mul_events[]' value='"+x+'-'+y+'-Doubles-'+z+"' checked style='display:none;' />");

		});


		$('#pay_options').change(function(){
			var pay_option_val = $(this).val();
			if(pay_option_val == 'paypal'){
				$('#paypal_details').show();
				$("input[name='pp']").trigger('click');
				$('#ppYes').prop('checked', true);

				$('#paytm_details').hide();
			}
			if(pay_option_val == 'paytm'){
				$('#paytm_details').show();
				$("input[name='petm']").trigger('click');
				$('#ptmYes').prop('checked', true);
				$('#paypal_details').hide();
			}
			if(pay_option_val == ''){
				$('#paytm_details').hide();
				$('#paypal_details').hide();
			}
		});
// Default Hide Fields
$('#customCombined').hide();
$('#customCombined_opts').hide();

});
</script>