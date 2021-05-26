<script>
	$(document).ready(function(){ 
		$("#sel_all").change(function(){
		  $(".checkbox1").prop('checked', $(this).prop("checked"));
		  });

		  $('#myform').on('submit', function (e) {
			if ($("input[type=checkbox]:checked").length === 0) {
			e.preventDefault();
			alert('Select atleast one player to send message');
			return false;
			}
			});
	});
</script>
<script>
	$(document).ready(function(){
    $('#CountryName').on('change', function() {
      if ( this.value == 'United States of America')
      {
        $("#state_drop").show();
      }
      else
      {
        $("#state_drop").hide();
      }
    });
});
</script>

<script>
	$(document).ready(function(){
	var baseurl = "<?php echo base_url();?>";

	$('#sport,#CountryName,#StateName').on('change',function(){
	
		var Sport = $('#sport').val();
		var Country = $('#CountryName').val();
		var State = $('#StateName').val();
		
            $.ajax({
                type:'POST',
                url:baseurl+'admin/ajax_users/',
                data:{spt:Sport,country:Country,state:State},    //{pt:'7',rngstrt:range1, rngfin:range2},
				success:function(html){
                    $('#load-users').html(html);
                }
            }); 
        
     });
	 });
</script>



<table class="tab-score">
		<tr>
		<th width="10%" class="score-position"><input type='checkbox' name="sel_all" id="sel_all" /></th>
		<th width="32%">Name</th>
		<!-- <th width="30%">Match Format</th>
		<th width="15%">Age Group</th> -->
		</tr>

		<?php
		if(count(array_filter($users)) > 0) {
			foreach($users as $name)
			{
			?>
		<tr>
		<td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php echo $name->Users_ID;?>"  style="margin-left:10px" /></td>

		<td><?php
			$player = admin::get_name($name->Users_ID);
			if(isset($player)){ echo "<b>" . $player['Firstname']." ".$player['Lastname'] . "</b>";}
			?>
		</td>

		</tr>
		  <?php }  ?>
		<?php }	else {
		?>
		<tr><td colspan='6'><b>No Users Found. </b></td></tr>
		<?php
		}
		?>
</table>