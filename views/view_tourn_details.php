<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>

 <script type="text/javascript">
$( document ).ready(function() {
$(function() {
    $('#showdiv1').click(function() {
        $('div[id^=div]').hide();
        $('#div1').show();
    });
    $('#showdiv2').click(function() {
        $('div[id^=div]').hide();
        $('#div2').show();
    });

    $('#showdiv3').click(function() {
        $('div[id^=div]').hide();
        $('#div3').show();
    });

    $('#showdiv4').click(function() {
        $('div[id^=div]').hide();
        $('#div4').show();
    });

});
});
</script>

	<section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
           
           
            	<form class='form-horizontal' role='form'>
           
           <div class="col-md-12 league-form-bg" style="margin-top:30px;">
           		<div class="fromtitle">Tournament Details</div>


            <div class='col-md-8'>
              <p><label class='col-md-5'>Tournament Name:</label> Tournament - 1</p>
              <p><label class='col-md-5'>Duration:</label> 01-15-2015 - 01-27-2016</p>
              <p><label class='col-md-5'>Sports:</label> Badminton</p>
              <p><label class='col-md-5'>Categories:</label> Singles, Doubles</p>
              <p><label class='col-md-5'>Gendar Type:</label> Open to All</p>
<!--              <p><label class='col-md-5'>Description:</label> US Open</p>  -->
            </div>
             <div class='col-md-4'>
              	<p class="txt-torn" style="margin-bottom:30px;"><a id="showdiv2" style="cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Team/Players&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></p>
                <p class="txt-torn"><a id="showdiv3" style="cursor:pointer;">Schedules/Fixtures</a></p>
            </div>
          </div>
          
        <div class="col-md-12 league-form-bg" style="margin-top:30px; display:none;" id="div2">
           		<div class="fromtitle">Registered Player</div>
          
          <div class='form-group'>
		     <div class='col-md-3 control-label'>
				<select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Sports--</option>
                	<option value="">Badminton</option>
                </select>
            </div>
            <div class='col-md-3 control-label'>
              <select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Category--</option>
                	<option value="">Singles</option>
                	<option value="">Doubles</option>
                </select>
            </div>
            <div class='col-md-3 control-label'>
              <select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Type--</option>
                	<option value="">Open to All</option>
                </select>
            </div>
            <div id="loader" class='col-md-3 control-label'>
                  <input type="submit" value="Submit" class="league-form-submit"/>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 league-form-bg" style="margin-top:30px; display:none;" id="div3">
           		<div class="fromtitle">Schedules / Fixtures</div>
          
          <div class='form-group'>
		     <div class='col-md-3 control-label'>
				<select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Sports--</option>
                	<option value="">Badminton</option>
                </select>
            </div>
            <div class='col-md-3 control-label'>
              <select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Category--</option>
                	<option value="">Singles</option>
                	<option value="">Doubles</option>
                </select>
            </div>
            <div class='col-md-3 control-label'>
              <select name="state" id="state" class='form-control' onChange="stateChange();">
                	<option value="">--Type--</option>
                	<option value="">Open to All</option>
                </select>
            </div>
            <div id="loader" class='col-md-3 control-label'>
                  <input type="submit" value="Submit" class="league-form-submit"/>
            </div>
          </div>
        </div>
           
        
        </form>
           </div><!--Close Top Match-->