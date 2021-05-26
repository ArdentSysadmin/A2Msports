<section id="single_player" class="container secondary-page">

<div class="col-md-12 league-form-bg" style="margin-top:30px; margin-bottom:20px"">
<div class="fromtitle">Join in Team</div>

<?php //if($this->session->userdata('user')=="") { ?>
<!-- <p style="line-height:5px; font-size:13px">Please <a href='<?php echo base_url()."login"; ?>'><b>Login</b> </a>to register for a tournament</p>
 -->
 <?php // } ?>
<?php if($this->session->userdata('user')!="" or $this->session->userdata('user')=="") { ?>

<form class="form-horizontal" id='myform' method='post' role="form" action="<?php echo base_url(); ?>teams/approve">
<div class='col-md-8'>
<input type="hidden" name="sec_code" value="<?php echo $this->uri->segment(3); ?>" />
<?php
$get_user = teams::get_username($req_user);
$get_team = teams::get_team_info($req_team);
?>
<p>
<label>Requested Player:</label>
<a href='<?=base_url();?>player/<?=$req_user;?>' target='_blan'><?=ucfirst($get_user['Firstname'])." ".ucfirst($get_user['Lastname']);?></a>
<input type="hidden" name="req_player" value="<?=$req_user;?>" />
<input type="hidden" name="req_team" value="<?=$req_team;?>" />
</p>
<p>
<label>Desire to Join in:</label>
<?=$get_team['Team_name'];?>
</p>
<?php 
if($prev_status){ ?>
<p><label>Request Status:</label> <?=$prev_status;?> </p>
<?php
} ?>
<p>
<label>Action to be taken? </label>
<select name="act_type" id="act_type" class='form-control' style="width:45%" required>
<option value="">Select</option>
<option value="Accept">Accept</option>
<option value="Declined">Declined</option>
<option value="Hold">On Hold</option>
</select>
</p>

<p>
<label>Comments </label>
<textarea name='comments' rows=3 cols=40 class='form-control' style="width:55%"></textarea>
</p>

<div class='col-md-9 form-group internal reg_players' style="margin-top:10px">
<input name="act_join" type="submit" value="Submit" class="league-form-submit1"/>
</div>
</form>

<?php } ?>
</div>
</div>
</div>

<!-- end main body -->
</div>
</div><!--Close Top Match-->
</section>