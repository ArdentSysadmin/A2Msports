<section id="single_player" class="container secondary-page">

          
			 <!-- start main body -->
           <div class="top-score-title right-score col-md-9">
               
				<h3 style="text-align:left">Event Registration</h3>

				<div class="col-md-12 login-page">

				<?php
				if(isset($stat)) { ?>
                       <div class="name" align='left'>
                            <label for="name_login" style="color:red"><?php echo $stat; ?></label>
						</div>
				<?php } ?>
				
				<?php if(isset($child_accounts)){ 
					echo "<h4>We found the given profiles that are linked to your account.<br />
					Please select the user to whom you want to register for this Event.</h4><br />"; ?>
					
				  <form method="post" class="login-form" method="post" action='<?php echo base_url(); ?>events/activate_users'> 
					
					<input type="radio" name="child_user_id" checked value="<?php echo $this->session->userdata('users_id');?>" /> 
					<?php echo "Self";?><br /><br />

					<?php foreach($child_accounts as $child){ ?>
						
					<div class="name">
						<input type="radio" name="child_user_id" value="<?php echo $child->Users_ID; ?>" /> 
						<?php $name = events::get_user_details($child->Users_ID);
						echo  ucfirst($name['Firstname']) . " ". ucfirst($name['Lastname']) . "<br /><br />";?>
					</div>

					<?php } ?>
					
					<input type="hidden" name="ev_id" value="<?php echo $ev_id; ?>"/>
					<input type="hidden" name="act_code" value="<?php echo $act_code; ?>"/>
					<input type="submit" name="child_account" value="Continue"/>

					</form>
				
				<?php } ?>

              
                
           </div><!--Close Login-->
			 <!-- end main body -->
             
           </div><!--Close Top Match-->