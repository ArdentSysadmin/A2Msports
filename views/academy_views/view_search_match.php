

<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $("input[name='chkPassPort']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#dvPassport").show();
            } else {
                $("#dvPassport").hide();
            }
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function(){

$("#search").click(function(){
    $("#result").show();
});

});
</script>


<section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
             <h3 style="text-align:left">Create a Match</h3>

			 <!-- start main body -->
	  <div class="col-md-12 league-form-bg" style="margin-top:40px;">
           		<div class="fromtitle">Find Opponent</div>
                <p style="line-height:20px; font-size:13px">Here you can find players that are interested in your area. Once you send invitation to other players in the area, a match is automatically created.</p>
            </div>
					 
			 <form class='form-horizontal' role='form'>
           
         <div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:30px">
			
           		<div class="fromtitle">Search for Players</div>

          <div class='form-group'>
            <label class='control-label col-md-4' for='id_accomodation'> Name the match you are creating </label>
            <div class='col-md-5 form-group internal'>
                <input type="text" id="texttitle" class='form-control' />
            </div>
			 
          </div>
		  <div class='form-group'>
		  <label class='control-label col-md-4' for='id_accomodation'> When do you want to play?</label>
			 <div class='col-md-5 form-group internal'>
                <input type="text" id="textdate" class='form-control' style="width:64%" />
            </div>
           </div>
		   
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'> Venue </label>
            <div class='col-md-3 form-group internal'>
               <select class='form-control' name="birth[month]">
					<option value="">Select</option>
					<option value="london">Home Stadium</option>
					<option value="delhi">XYZ Stadium</option>
					<option value="kolkatta">ABC Stadium</option>
				</select>
            </div>
            <div class='col-md-2 form-group internal'>
				<input type="button" value="Add New" class="league-form-submit" style="margin-left:10px"/>
            </div>
          </div>
		  
          
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Sports</label>
            <div class='col-md-6 form-group internal'>
            	<input type="checkbox" name="vehicle" value="Singles"> Tennis &nbsp;
				<input type="checkbox" name="vehicle" id="doubles" value="Doubles"> Table Tennis &nbsp;
				<input type="checkbox" name="vehicle" id="mixed" value="Mixed"> Squash &nbsp;
				<input type="checkbox" name="vehicle" id="mixed" value="Mixed"> Badminton
            </div>
			
          </div>
		  
		  <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Level</label>
            <div class='col-md-6 form-group internal'>
            	<input type="checkbox" name="vehicle" value="Singles"> Beginner &nbsp;
				<input type="checkbox" name="vehicle" id="doubles" value="Doubles"> Intermediate &nbsp;
				<input type="checkbox" name="vehicle" id="mixed" value="Mixed"> Advance
            </div>
			
          </div>
		  
			  
    
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'>Gender</label>
            <div class='col-md-6 form-group internal'>
			  <input type="checkbox" name="sex" id="male" value="male">  Male Only&nbsp;&nbsp;
			  <input type="checkbox" name="sex" id="male" value="male"> Female Only
			  <input type="checkbox" name="sex" id="male" value="male"> Open to All
            </div>
          </div>
         
		  
       
          <div class='form-group'>
            <label class='control-label col-md-3' for='id_accomodation'></label>
            <div class='col-md-7 form-group internal'>
              <input type="button" value="Search Players"  id="search" class="league-form-submit"/>
            </div>
          </div>
        </div>
           	 </form>
			 
			<div style="display:none;" id="result">
					 
					 <table class="tab-score-m">
					 
                                  <tr>
                                  	<th width="4%" class="score-position">Select</th>
                                  	<th width="11%">Name</th>
									<th width="6%">Age</th>
									<th width="6%">Gender</th>
                                    <th width="22%">Sports</th>
                                    <th width="15%">Level</th>
                                    <th width="36%">Location</th>
                                   
                                 </tr>
                                  <tr>
                                    <td><input type="checkbox" name="sel_player" value="" /></td>
                                  	<td><a href="single_player.html">Prasad</a></td>
                                    <td>35</td>
									 <td>Male</td>
									 <td>Badminton, Tennis</td>
                                    <td>Intermediate</td>
									 <td>Gachibowli, Hyderabad</td>
                                 </tr>
                                  <tr>
                                    <td><input type="checkbox" name="sel_player" value="" /></td>
                                  	<td><a href="single_player.html">Pradeep</a></td>
                                    <td>32</td>
									 <td>Male</td>
									 <td>Badminton, Squash</td>
                                     <td>Beginner</td>
									 <td>Lingampally, Hyderabad</td>
                                 </tr>
                                  <tr>
                                    <td><input type="checkbox" name="sel_player" value="" /></td>
                                  	<td><a href="single_player.html">Sridhar</a></td>
                                    <td>30</td>
									 <td>Male</td>
									 <td>Tennis, Squash</td>
                                    <td>Advance</td>
									 <td>Kukatpally, Hyderabad</td>
                                 </tr>
								 
								 
								  <tr>
										<td colspan="7" align="center"><input type="button" value="Send Invite" class="league-form-submit" style="margin-bottom:0px"/><!--&nbsp;&nbsp;&nbsp;
										<input type="button" value="Invite Friends" class="league-form-submit" style="margin-bottom:0px"/> -->
										</td>
					              </tr>
					 </table>
				
				</div>
			 
				
			 
			 
			  
				 
			 

			 <!-- end main body -->
             
           </div><!--Close Top Match-->