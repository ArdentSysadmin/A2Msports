<div class="clear"></div>

<div class="col-md-12" style="margin-top: 50px; margin-left: 0px;">
<h3 style="color:#0032af;">GPA Clubs</h3>
</div>
<div class="col-md-2">&nbsp;</div>
<div class="col-md-8 table-responsive" style="margin-top: 30px; margin-bottom: 50px !important; text-align: center;">
<table id="gpa_clubs" class="table table-striped">
<thead>
<tr class="top-scrore-table" style="background-color:#dedede">
<th class="score-position">Club Name</th>
<th class="score-position">City</th>
<th class="score-position">State</th>
<th class="score-position">Contact Number</th>
<!-- <th class="score-position">Rating</th> -->
</tr>
</thead>
<tbody>
<?php 
if(count($club_results) == 0)
{
?>
<tr>
<td><h5>No Clubs Found.</h5></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<!-- <td>&nbsp;</td> -->
</tr>
<?php
}
else
{
foreach($club_results as $row){ ?><!-- img-djoko -->
<tr>
<td id="club_"<?=$row->Aca_ID;?>>
<?php
if($row->Aca_URL_ShortCode != "") {
?>
<a href="<?php echo base_url().$row->Aca_URL_ShortCode; ?>"><?php echo trim($row->Aca_name); ?></a>
<?php
}
else if($row->Aca_url != "") {
?>
<a href="<?php echo stripslashes($row->Aca_url);?>"><?php echo stripslashes($row->Aca_name); ?></a>
<?php
}
else {
?>
<?php echo stripslashes($row->Aca_name);
}
?>
</td>

<td>
<?php 
if($row->Aca_city != ""){
echo $row->Aca_city; 
}
?>
</td>
<td>
<?php 
if($row->Aca_state != ""){
echo $row->Aca_state; 
}
?>
</td>
<td><?php echo $row->Aca_contact_phone; ?></td>
</tr>
<?php 
}
}
?>
</tbody>
</table>
</div>
<div class="col-md-2">&nbsp;</div>

<!-- </div> -->

<div class="clear"></div>