<script>
//var admin_table;
//admin_table.DataTable.clear();
	$(document).ready(function(){ 

	$('#admin_filter_table').DataTable({
	"paging":   false,
	"ordering": true,
	"info":     false,
	"search":   true
	});

		//admin_table = $('#admin_filter_table').DataTable({"pageLength": 25});

		/*$("#myform").on('submit', function(e){
		var $form = $(this);

		// Iterate over all checkboxes in the table
		admin_table.$('input[type="checkbox"]').each(function(){
		// If checkbox doesn't exist in DOM
		if(!$.contains(document, this)){
		// If checkbox is checked
		if(this.checked){
		// Create a hidden element 
		$form.append(
		$('<input>')
		  .attr('type', 'hidden')
		  .attr('name', this.name)
		  .val(this.value)
		);
		}
		} 
		});          
		});*/

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

<div id="admin_ajaxfilter_div" class="tab-content table-responsive">
<table id="admin_filter_table" class="table tab-score">
		<thead>
		<tr class="top-scrore-table">
		<td class="score-position" class="score-position">
		<?php if(count(array_filter($users)) > 0){?>
		<input type='checkbox' name="sel_all" id="sel_all" /></td>
		<?php } ?>
		<td class="score-position">Name</td>
		<td class="score-position">Phone #</td>
		<td class="score-position">A2M Score</td>
		<!-- <th width="30%">Match Format</th>
		<th width="15%">Age Group</th> -->
		</tr>
		</thead>
		<?php
		if(count(array_filter($users)) > 0) {
			/*$prev_users = array ("356","258","477","469","345","325","769","949","418","322","458","672","314","712","371","377","381","326","883","1062","853","380","789","317","741");*/

			foreach($users as $user)
			{
				//if(!in_array($user['Users_ID'], $prev_users)){
				//$arr[] = (string) $user['Users_ID'];
				//}
				$gender = ($player['Gender']) ? '(M)' : '(F)';
			?>
		<tr>
		<td><input class="checkbox1" type="checkbox" name="sel_player[]" value="<?php echo $user['Users_ID'];?>"  style="margin-left:10px" /></td>
		<td><?php echo "<b>".ucfirst(strtolower($user['Firstname']))." ".ucfirst(strtolower($user['Lastname']))." ".$gender."</b>"; ?></td>
		<td><?php 
			$phone = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $user['Mobilephone']);
			echo "<b>".$phone."</b>"; ?></td>
		<td><?php echo $user['A2MScore']; ?></td> 
		</tr>
		<?php }  ?>
		<?php
		//$x = json_encode($arr);
		//echo "<br>".$x;
		}
		else{
		?>
		<tr>
		<td><b>No Users Found. </b></td>
		<td></td>
		<td></td>
		<td></td>
		</tr>
		<?php
		}
		?>
</table>
</div>

<!-- -------------------------- Code To Select All Check Boxes Of The DataTables. ----------------------------- -->
<script>
 	$(document).ready(function (){   
	   $('#sel_all').on('click', function(){
		   var rows = admin_table.rows({ 'search': 'applied' }).nodes();
		  $('input[type="checkbox"]', rows).prop('checked', this.checked);
	   });
 	   
	   $('#admin_filter_table tbody').on('change', 'input[type="checkbox"]', function(){
		   if(!this.checked){
			 var el = $('#sel_all').get(0);
			 if(el && el.checked && ('indeterminate' in el)){
  				el.indeterminate = true;
			 }
		  }
	   });
	}); 
</script>