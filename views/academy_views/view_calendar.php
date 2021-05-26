<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>

<link href='<?php echo base_url(); ?>assets/css/fullcalendar.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='<?php echo base_url(); ?>assets/js/moment.min.js'></script>
<!-- <script src='<?php echo base_url(); ?>assets/js/jquery.min.js'></script>
 --><script src='<?php echo base_url(); ?>assets/js/jquery-ui.min.js'></script>
<script src='<?php echo base_url(); ?>assets/js/fullcalendar.min.js'></script>
<style>

	/*body{
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	}*/
		
	#wrap {
		width: 850px;
		margin: 10px 30px 0 0;
	}
		
	#external-events {
		float: left;
		width: 50px;
		padding: 0 10px;
		border: 1px solid #f59123; 
		background: #f59123;
		text-align: left;
	}
		
	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}
		
	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
	}
		
	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #111;
	}
		
	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	/*#calendar { 
		float: right;
		width: 900px;
	}*/

	#calendar{
		float: left;
		margin: 40px 20px 0 0;
		width: 850px;
	}
	
	@media only screen and (max-width: 762px) {
		#calendar{
			float: none;
			margin: 40px 20px 0 0;
			width: auto;
		}
	}

</style>

<script>

$(document).ready(function(){

var baseurl = "<?php echo base_url(); ?>";

		var zone = "05:30";  //Change this to your timezone

	$.ajax({
		url: baseurl+'calendar/process',
        type: 'POST', // Send post data
        data: 'type=fetch',
        async: false,
        success: function(s){
			console.log(s)
        	json_events = s;
        }
	});


	var currentMousePos = {
	    x: -1,
	    y: -1
	};
		jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

		/* initialize the external events
		-----------------------------------------------------------------*/

		$('#external-events .fc-event').each(function(){

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});


		/* initialize the calendar
		-----------------------------------------------------------------*/

		$('#calendar').fullCalendar({
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			utc: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: true,
			droppable: true, 
			slotDuration: '00:30:00',
			eventReceive: function(event){
				var title = event.title;
				var start = event.start.format("YYYY-MM-DD");
				$.ajax({
		    		//url: 'process.php',
					url: baseurl+'calendar/process',
		    		data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
		    		type: 'POST',
		    		dataType: 'json',
		    		success: function(response){
		    			event.id = response.eventid;
		    			$('#calendar').fullCalendar('updateEvent',event);
		    		},
		    		error: function(e){
		    			console.log(e.responseText);

		    		}
		    	});
				$('#calendar').fullCalendar('updateEvent',event);
				console.log(event);
			},


			eventClick: function(event, jsEvent, view){
				if (event.type == "tournament"){
				  window.location.href = baseurl+"league/view/"+event.id;
				}
				else
				{
				   window.location.href = baseurl+"events/view/"+event.id;
				}
			   }

		});

	function getFreshEvents(){
		$.ajax({
			//url: 'process.php',
			url: baseurl+'calendar/process',
	        type: 'POST', // Send post data
	        data: 'type=fetch',
	        async: false,
	        success: function(s){
	        	freshevents = s;
	        }
		});
		$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
	}


	function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }

});

</script>

<section id="single_player" class="container secondary-page">


<div class="top-score-title right-score col-md-9">
<!-- start main body -->

<div id='wrap'>
<div id='calendar'></div>
</div>

</div>