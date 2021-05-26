<html>
<head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
function onLoad() {
	var tourn_id	 = "<?php echo $tourn_id; ?>";
	var origin		 = "https://a2msports.com";
	var pathname= "/m/league/"+tourn_id;
    var path = window.location.pathname.split("/m")[1];
    window.location.href = "a2msports:/"+ path ;

setTimeout(function(){ window.location.href = window.location.origin+path }, 2000);
}
</script>
</head>
<body onload='onLoad();'>
</body>
</html>