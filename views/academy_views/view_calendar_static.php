

<link href="<?php echo base_url();?>calender/fullcalendar.css" rel="stylesheet">
<link href="<?php echo base_url();?>calender/fullcalendar.print.css" rel="stylesheet" media="print">
<script src="<?php echo base_url();?>calender/lib/jquery.min.js"></script>
<script src="<?php echo base_url();?>calender/lib/moment.min.js"></script>
<script src="<?php echo base_url();?>calender/fullcalendar.min.js"></script>
<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript"></script>
<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			defaultDate: '2015-12-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2015-12-01'
				},
				{
					title: 'Tournament',
					start: '2015-12-07',
					end: '2015-12-10'
				},
				{
					id: 999,
					title: 'Match one',
					start: '2015-12-09T16:00:00'
				},
				{
					id: 999,
					title: 'Match Two',
					start: '2015-12-16T16:00:00'
				},
				{
					title: 'Tournament Two',
					start: '2015-12-11',
					end: '2015-12-15'
				},
				{
					title: 'Match Three',
					start: '2015-12-12',
					end: '2015-12-12'
				},
				{
					title: 'Match',
					start: '2015-12-12T12:00:00'
				},
				{
					title: 'Tournament Three',
					start: '2015-12-12',
					end: '2015-12-19'
				},
				{
					title: 'Match',
					start: '2015-12-12T17:30:00'
				},
				{
					title: 'Match',
					start: '2015-12-12T20:00:00'
				},
				{
					title: 'Match',
					start: '2015-12-13T07:00:00'
				}/*,
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2015-12-28'
				}*/
			]
		});
		
	});

</script>

</head>
<body>


<!--<section class="content-top-login">
           <div class="container">
      <div class="col-md-12">
           <div class="box-support"> 
             <p class="txt-torn"><a href='create-league.html'>Create Tournament</a>&nbsp;&nbsp;<a href='find-opponent.html'>Find Opponent</a></p>
          </div>
           <div class="box-login"> 
             <a href='login.html'>Login</a>
             <a href='register.html'>New User</a>
          </div>
          
        </div>
      </div>
     </section>-->

    <section class="drawer">
    
    
    <section id="single_player" class="container secondary-page">

           <div class="top-score-title right-score col-md-9">
             <h3 style="text-align:left"></h3>
             <div id="calendar" class="fc fc-ltr fc-unthemed"><div class="fc-toolbar"><div class="fc-left"><h2>December 2015</h2></div><div class="fc-right"><button type="button" class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right">today</button><div class="fc-button-group"><button type="button" class="fc-prev-button fc-button fc-state-default fc-corner-left"><span class="fc-icon fc-icon-left-single-arrow"></span></button><button type="button" class="fc-next-button fc-button fc-state-default fc-corner-right"><span class="fc-icon fc-icon-right-single-arrow"></span></button></div></div><div class="fc-center"></div><div class="fc-clear"></div></div><div class="fc-view-container" style=""><div class="fc-view fc-month-view fc-basic-view"><table><thead class="fc-head"><tr><td class="fc-head-container fc-widget-header"><div class="fc-row fc-widget-header"><table><thead><tr><th class="fc-day-header fc-widget-header fc-sun">Sun</th><th class="fc-day-header fc-widget-header fc-mon">Mon</th><th class="fc-day-header fc-widget-header fc-tue">Tue</th><th class="fc-day-header fc-widget-header fc-wed">Wed</th><th class="fc-day-header fc-widget-header fc-thu">Thu</th><th class="fc-day-header fc-widget-header fc-fri">Fri</th><th class="fc-day-header fc-widget-header fc-sat">Sat</th></tr></thead></table></div></td></tr></thead><tbody class="fc-body"><tr><td class="fc-widget-content"><div class="fc-day-grid-container"><div class="fc-day-grid"><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 101px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2015-11-29"></td><td class="fc-day fc-widget-content fc-mon fc-other-month fc-past" data-date="2015-11-30"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2015-12-01"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2015-12-02"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2015-12-03"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2015-12-04"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2015-12-05"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-past" data-date="2015-11-29">29</td><td class="fc-day-number fc-mon fc-other-month fc-past" data-date="2015-11-30">30</td><td class="fc-day-number fc-tue fc-past" data-date="2015-12-01">1</td><td class="fc-day-number fc-wed fc-past" data-date="2015-12-02">2</td><td class="fc-day-number fc-thu fc-past" data-date="2015-12-03">3</td><td class="fc-day-number fc-fri fc-past" data-date="2015-12-04">4</td><td class="fc-day-number fc-sat fc-past" data-date="2015-12-05">5</td></tr></thead><tbody><tr><td></td><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable"><div class="fc-content"> <span class="fc-title">All Day Event</span></div><div class="fc-resizer fc-end-resizer"></div></a></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 101px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2015-12-06"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2015-12-07"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2015-12-08"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2015-12-09"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2015-12-10"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2015-12-11"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2015-12-12"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2015-12-06">6</td><td class="fc-day-number fc-mon fc-past" data-date="2015-12-07">7</td><td class="fc-day-number fc-tue fc-past" data-date="2015-12-08">8</td><td class="fc-day-number fc-wed fc-past" data-date="2015-12-09">9</td><td class="fc-day-number fc-thu fc-past" data-date="2015-12-10">10</td><td class="fc-day-number fc-fri fc-past" data-date="2015-12-11">11</td><td class="fc-day-number fc-sat fc-past" data-date="2015-12-12">12</td></tr></thead><tbody><tr><td rowspan="6"></td><td class="fc-event-container" colspan="3"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable"><div class="fc-content"> <span class="fc-title">Tournament</span></div><div class="fc-resizer fc-end-resizer"></div></a></td><td rowspan="6"></td><td class="fc-event-container" colspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-not-end fc-draggable"><div class="fc-content"> <span class="fc-title">Tournament Two</span></div></a></td></tr><tr><td rowspan="5"></td><td rowspan="5"></td><td class="fc-event-container" rowspan="5"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title">Match one</span></div></a></td><td rowspan="5"></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-not-end fc-draggable"><div class="fc-content"> <span class="fc-title">Tournament Three</span></div></a></td></tr><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable"><div class="fc-content"> <span class="fc-title">Match Three</span></div><div class="fc-resizer fc-end-resizer"></div></a></td></tr><tr><td class="fc-event-container fc-limited"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">12p</span> <span class="fc-title">Match</span></div></a></td><td class="fc-more-cell" rowspan="1"><div><a class="fc-more">+3 more</a></div></td></tr><tr class="fc-limited"><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">5:30p</span> <span class="fc-title">Match</span></div></a></td></tr><tr class="fc-limited"><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">8p</span> <span class="fc-title">Match</span></div></a></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 101px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2015-12-13"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2015-12-14"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2015-12-15"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2015-12-16"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2015-12-17"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2015-12-18"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2015-12-19"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2015-12-13">13</td><td class="fc-day-number fc-mon fc-past" data-date="2015-12-14">14</td><td class="fc-day-number fc-tue fc-past" data-date="2015-12-15">15</td><td class="fc-day-number fc-wed fc-past" data-date="2015-12-16">16</td><td class="fc-day-number fc-thu fc-past" data-date="2015-12-17">17</td><td class="fc-day-number fc-fri fc-past" data-date="2015-12-18">18</td><td class="fc-day-number fc-sat fc-past" data-date="2015-12-19">19</td></tr></thead><tbody><tr><td class="fc-event-container" colspan="2"><a class="fc-day-grid-event fc-h-event fc-event fc-not-start fc-end fc-draggable fc-resizable"><div class="fc-content"> <span class="fc-title">Tournament Two</span></div><div class="fc-resizer fc-end-resizer"></div></a></td><td></td><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">4p</span> <span class="fc-title">Match Two</span></div></a></td><td></td><td></td><td rowspan="3"></td></tr><tr><td class="fc-event-container" colspan="6"><a class="fc-day-grid-event fc-h-event fc-event fc-not-start fc-end fc-draggable fc-resizable"><div class="fc-content"> <span class="fc-title">Tournament Three</span></div><div class="fc-resizer fc-end-resizer"></div></a></td></tr><tr><td class="fc-event-container"><a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"><div class="fc-content"><span class="fc-time">7a</span> <span class="fc-title">Match</span></div></a></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 101px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2015-12-20"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2015-12-21"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2015-12-22"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2015-12-23"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2015-12-24"></td><td class="fc-day fc-widget-content fc-fri fc-past" data-date="2015-12-25"></td><td class="fc-day fc-widget-content fc-sat fc-past" data-date="2015-12-26"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2015-12-20">20</td><td class="fc-day-number fc-mon fc-past" data-date="2015-12-21">21</td><td class="fc-day-number fc-tue fc-past" data-date="2015-12-22">22</td><td class="fc-day-number fc-wed fc-past" data-date="2015-12-23">23</td><td class="fc-day-number fc-thu fc-past" data-date="2015-12-24">24</td><td class="fc-day-number fc-fri fc-past" data-date="2015-12-25">25</td><td class="fc-day-number fc-sat fc-past" data-date="2015-12-26">26</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 101px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-past" data-date="2015-12-27"></td><td class="fc-day fc-widget-content fc-mon fc-past" data-date="2015-12-28"></td><td class="fc-day fc-widget-content fc-tue fc-past" data-date="2015-12-29"></td><td class="fc-day fc-widget-content fc-wed fc-past" data-date="2015-12-30"></td><td class="fc-day fc-widget-content fc-thu fc-past" data-date="2015-12-31"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-past" data-date="2016-01-01"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-past" data-date="2016-01-02"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-past" data-date="2015-12-27">27</td><td class="fc-day-number fc-mon fc-past" data-date="2015-12-28">28</td><td class="fc-day-number fc-tue fc-past" data-date="2015-12-29">29</td><td class="fc-day-number fc-wed fc-past" data-date="2015-12-30">30</td><td class="fc-day-number fc-thu fc-past" data-date="2015-12-31">31</td><td class="fc-day-number fc-fri fc-other-month fc-past" data-date="2016-01-01">1</td><td class="fc-day-number fc-sat fc-other-month fc-past" data-date="2016-01-02">2</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div><div class="fc-row fc-week fc-widget-content fc-rigid" style="height: 104px;"><div class="fc-bg"><table><tbody><tr><td class="fc-day fc-widget-content fc-sun fc-other-month fc-past" data-date="2016-01-03"></td><td class="fc-day fc-widget-content fc-mon fc-other-month fc-past" data-date="2016-01-04"></td><td class="fc-day fc-widget-content fc-tue fc-other-month fc-past" data-date="2016-01-05"></td><td class="fc-day fc-widget-content fc-wed fc-other-month fc-past" data-date="2016-01-06"></td><td class="fc-day fc-widget-content fc-thu fc-other-month fc-past" data-date="2016-01-07"></td><td class="fc-day fc-widget-content fc-fri fc-other-month fc-past" data-date="2016-01-08"></td><td class="fc-day fc-widget-content fc-sat fc-other-month fc-past" data-date="2016-01-09"></td></tr></tbody></table></div><div class="fc-content-skeleton"><table><thead><tr><td class="fc-day-number fc-sun fc-other-month fc-past" data-date="2016-01-03">3</td><td class="fc-day-number fc-mon fc-other-month fc-past" data-date="2016-01-04">4</td><td class="fc-day-number fc-tue fc-other-month fc-past" data-date="2016-01-05">5</td><td class="fc-day-number fc-wed fc-other-month fc-past" data-date="2016-01-06">6</td><td class="fc-day-number fc-thu fc-other-month fc-past" data-date="2016-01-07">7</td><td class="fc-day-number fc-fri fc-other-month fc-past" data-date="2016-01-08">8</td><td class="fc-day-number fc-sat fc-other-month fc-past" data-date="2016-01-09">9</td></tr></thead><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table></div></div></div></div></td></tr></tbody></table></div></div></div>
           </div><!--Close Top Match-->

        
     