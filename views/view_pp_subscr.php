<!doctype html>
<html lang="en">

 <head>
	  <meta charset="UTF-8">
	  <meta name="Generator" content="EditPlus®">
	  <meta name="Author" content="">
	  <meta name="Keywords" content="">
	  <meta name="Description" content="">
	  <title>Paypal SubScription</title>
 </head>

<body>
<form method='POST' action='/test/pp_subscr' name='frm_pp'>
<br /><br />
<input type='text' name='user_name' value='' placeholder='Enter you name' />
<br /><br />
<select name='pp_t3' id='pp_t3'>
<option value='D'>Daily</option>
<option value='W'>Weekly</option>  
<option value='M'>Monthly</option>
<option value='Y'>Yearly</option>	
</select>
<br /><br />
<input type='number' name='pp_a3' id='pp_a3' value='' min='1' placeholder='Subscription Amount' />
<br /><br />
<input type='submit' name='submit_pp' id='submit_pp' value='Submit' />
</form>
</body>

</html>
