
   
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

function listbox_move(listID, direction) {
 
			var listbox = document.getElementById(listID);
			var selIndex = listbox.selectedIndex;
		 
			//document.write(listbox);
			//document.write(selIndex);
			
			if(-1 == selIndex) {
				alert("Please select an player to move.");
				return;
			}
		 
			var increment = -1;
			if(direction == 'up')
				increment = -1;
			else
				increment = 1;
		 
			if((selIndex + increment) < 0 ||
				(selIndex + increment) > (listbox.options.length-1)) {
				return;
			}
		 
			var selValue = listbox.options[selIndex].value;
			var selText = listbox.options[selIndex].text;
			listbox.options[selIndex].value = listbox.options[selIndex + increment].value
			listbox.options[selIndex].text = listbox.options[selIndex + increment].text
		 
			listbox.options[selIndex + increment].value = selValue;
			listbox.options[selIndex + increment].text = selText;
		 
			listbox.selectedIndex = selIndex + increment;
	}

	function listbox_selectall(listID, isSelect) {
        var listbox = document.getElementById(listID);
        for(var count=0; count < listbox.options.length; count++) {
            listbox.options[count].selected = isSelect;
		}
	}

	</script>


   <section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
             <h3 style="text-align:left"> </h3>

			 <!-- start main body -->

				<?php
				if(isset($success)) { ?>
				<div class="name" align='left'>

				<label for="name_login" style="color:green"><?php echo $success; ?></label>
				</div>
				<?php } ?>
				
			<form class="form-horizontal" id='myform' method='post' role="form"  action="<?php echo base_url();?>play/invite_email"> 

				<input type="hidden" id="tourn_id" name="tourn_id" value=<?php echo $tourn_id;?> /> 
           
				   <div class="col-md-12 league-form-bg" style="margin-top:40px; background:#fff; margin-bottom:20px;">
				    <div class="fromtitle">Invite Players</div>

					<div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'>Invities (Email Addresses) :</label> 
					<div class='col-md-7 form-group internal'>
					<textarea name="emails" class='form-control' id="mes" rows="10" cols="40" required></textarea>
					</div>	
					</div>
					  
					  <div class='form-group'>
					<label class='control-label col-md-3' for='id_accomodation'>Message :</label> 
					<div class='col-md-7 form-group internal'>
					<textarea name="mes" class='form-control' id="mes" rows="10" cols="40">Hi, I am conducting a new tournament.
					</textarea>
					</div>	
					</div>
					 
					 <div class='form-group'>
						<label class='control-label col-md-3' for='id_accomodation'></label>
						 <div class='col-md-7 form-group internal'>
						  <input type="submit" name='generate' value="Send Invitation" class="league-form-submit"/>
						</div>
					 </div>

					</div>
           	 </form>


			 <!-- end main body -->
             
           </div><!--Close Top Match-->