<link rel="stylesheet" href="https://codepen.io/yangg/pen/vONKyd" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/fullcalendar.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/fullcalendar.min.js"></script> 
<script src="https://fullcalendar.io/js/fullcalendar-2.3.1/lang-all.js"></script> 
<script>
$(function() { // document ready

  var calendar = $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'agendaWeek,agendaDay'
    },
    defaultView: 'agendaWeek',
    defaultTimedEventDuration: '01:00',
    allDaySlot: false,
    scrollTime: '08:00',
    businessHours: {
      start: '9:00',
      end: '18:00',
    },
    lang: /^en-/.test(navigator.language) ? 'en' : 'zh-cn',
    eventOverlap: function(stillEvent, movingEvent) {
      return true;
    },
    events: [{
      title: 'Test123',
      start: '2015-05-22T15:00+08:00'
    }, {
      title: 'Test',
      start: '2015-05-22T12:00+08:00'
    }],
    editable: true,
    selectable: true,
    selectHelper: true,
    select: function(start, end) {
      var duration = (end - start) /1000;
      if(duration == 1800) {
        // set default duration to 1 hr.
      	end = start.add(30, 'mins');
        return calendar.fullCalendar('select', start, end);
      }
      var title = prompt('Event Title:');
      var eventData;
      if (title && title.trim()) {
        eventData = {
          title: title,
          start: start,
          end: end
        };
        calendar.fullCalendar('renderEvent', eventData);
      }
      calendar.fullCalendar('unselect');
    },
    eventRender: function(event, element) {
      var start = moment(event.start).fromNow();
      element.attr('title', start);
    },
    loading: function() {
      
    }
  });

});
</script>
<style>

#page {
  max-width: 960px; padding: 0 15px; margin: 40px auto;
  @media (max-height: 790px) {
    margin-top: 0;
  }
}
.page-header h1 { .text-center; font-weight: 100; }

.input, select {
  padding: 2px 5px;
}
.btn {
  padding: .2em .8em;
  border-radius: 4px;
  border: 1px solid #bcbcbc;
	box-shadow: 0 1px 3px rgba(0,0,0,0.12);
	background-image: linear-gradient(180deg, rgba(255,255,255,1) 0%,rgba(239,239,239,1) 60%,rgba(225,223,226,1) 100%);
  background-repeat: no-repeat; // fix for firefox
}

.bubble {
  box-shadow: 0 2px 4px rgba(0,0,0,.2); border-radius: 2px;
  background: #fff; padding: 15px;
  width: 420px;
  z-index: 99;
  position: absolute;

  .close {
    position: absolute; font-size: 24px; line-height: 1;
    padding: 0 5px;
    right: 5px; top: 5px;
  }
}

.bubble {
  @border-color: #ccc;
  border: 1px solid @border-color;
  .arrow, .arrow:after {
    position: absolute; height: 0; width: 0; font-size: 0; .horizontal-border(transparent, 10px);
  }
  &-top, &-bottom {
    .arrow {
      left: 50%; margin-left: -10px;
    }
    .arrow:after {
      content: ''; left: -10px;
    }
  }
  &-top {
    .arrow {
      border-top: @border-color 10px solid; top: 100%;
    }
    .arrow:after {
      border-top: #FFF  10px solid; bottom: 1px;
    }
  }
  &-bottom {
    .arrow {
      border-bottom: @border-color 10px solid; bottom: 100%;
    }
    .arrow:after {
      border-bottom: #FFF  10px solid; top: 1px;
    }
  }
}


.form-group {
  .clearfix; padding-bottom: 8px;
  &>label {
    float: left; width: 4em; text-align: right; padding-right: 5px;
  }
  &>input, &>.input-wrapper {
    margin-left: 4em;
    display: block;
  }
}


.btn-delete {
  margin-top: 5px;
  display: none;
  .text-danger;
  &:hover {
    text-decoration: underline;
  }
}

.usage { margin-top: 10px; }

</style>
<div id="page">
  <div class="page-header">
    <h1>Reservation System (<a class="text-primary" href="http://preview.uedsky.com/demo/reserving" target="_blank">interactive demo</a>)</h1>
  </div>
  <div id="calendar"></div>
</div>

<div class="bubble">
  <div class="arrow"></div>
</div>