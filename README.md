# Buto-Plugin-FullcalendarVersion_351
Javascript calendar.
FullCalendar v3.5.1
Docs & License: https://fullcalendar.io/

## Include library
````
type: widget
data:
  plugin: fullcalendar/version_351
  method: include
  data:
````
Set language (optional). 
Default is en.
Set param lang for a specific language.
Check in folder /public/locale for availible languages.
````
    lang: es
````

## Create calendar widget
````
type: widget
data:
  plugin: fullcalendar/version_351
  method: render
  data:
    id: my_calendar
    json:
      allDaySlot: false
      #startTime: '08:00'
      height: 600
      #firstHour: 8
      scrollTime:  "07:00:00"
      # contentHeight: 'auto'
      editable: true
      businessHours:
        start: '08:00'
        end: '16:00'
      header:
        left: 'prev,next,today'
        center: 'title'
        right: 'month,agendaWeek,agendaDay,list'
      events: '/url_to_json'
      eventClick: calendar_click
      defaultView: agendaWeek
      #eventColor: '#378006'
      nowIndicator: true
      weekNumbers: true
````

### calendar_click
If using param json/eventClick.
````
function calendar_click(calEvent, jsEvent, view){
  console.log(calEvent);
  return false;
}
````

## Reload button
Example how to add reload button.
````
$( document ).ready(function() {
    var div = document.getElementsByClassName('fc-button-group')[0];
    var button = document.createElement('button');
    button.innerHTML = 'Reload';
    button.className = 'fc-button';
    button.href = '#';
    button.onclick = function(){$('#my_calendar').fullCalendar('refetchEvents');}
    div.appendChild(button);
});
````

## Json data
Along with required params one could add custom params to be used on eventClick.
````
-
  allDay: false
  start: '2021-01-01 08:00:00'
  end: '2021-01-01 08:30:00'
  title: "Test"
  backgroundColor: '#808080'
  textColor: gray
-
  allDay: false
  start: '2021-01-01 10:00:00'
  end: '2021-01-01 12:00:00'
  title: "Test"
  backgroundColor: '#808080'
  textColor: black
  my_custom_param: 'Hello calendar'
````
Output data.
````
exit(json_encode($json));
````
