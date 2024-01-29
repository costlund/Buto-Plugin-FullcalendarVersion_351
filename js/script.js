$(document).ready(function(){  setTimeout(function() {  
  /**
   * 
   */
  $("#'_data_id_'").fullCalendar('_json_');  
  /**
   * 
   */
  var div = document.getElementsByClassName('fc-button-group')[0];
  var button = document.createElement('a');
  button.innerHTML = 'Reload';
  button.className = 'fc-button';
  button.href = '#';
  button.style = 'margin-left:10px;padding-top:5px';
  button.onclick = function(){$('#calendar_hours').fullCalendar('refetchEvents');}
  div.appendChild(button);
  /**
   * 
   */
}, 50); });