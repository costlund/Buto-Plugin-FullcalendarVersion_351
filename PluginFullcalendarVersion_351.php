<?php
/**
<h1>Javascript calendar</h1>
 */
class PluginFullcalendarVersion_351{
  /**
   * Include in head.
   */
  public static function widget_include($data){
    wfPlugin::includeonce('wf/array');
    $data = new PluginWfArray($data);
    $element = array();
    $element[] = wfDocument::createHtmlElement('link', null, array('href' => '/plugin/fullcalendar/version_351/fullcalendar.css', 'rel' => 'stylesheet'));
    $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/lib/jquery.min.js', 'type' => 'text/javascript'));
    $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/lib/moment.min.js', 'type' => 'text/javascript'));
    $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/fullcalendar.js', 'type' => 'text/javascript'));
    if($data->get('data/lang')){
      $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/locale/'.$data->get('data/lang').'.js', 'type' => 'text/javascript'));
    }
    wfDocument::renderElement($element);
  }
  /**
   * Include on page.
   */
  public static function widget_render($data){
    /**
     * 
     */
    wfPlugin::includeonce('wf/array');
    $data = new PluginWfArray($data);
    /**
     * Data from Google Calendar url.
     */
    if($data->get('data/google_calendar')){
      wfPlugin::includeonce('google/calendar');
      $google = new PluginGoogleCalendar();
      $google->filename = $data->get('data/google_calendar');
      $google->init();
      $calendar = new PluginWfArray($google->calendar);
      $events = array();
      foreach ($calendar->get('event') as $key => $value) {
        $item = new PluginWfArray($value);
        if($item->get('DTSTART;VALUE=DATE')){
          $events[] = array('title' => $item->get('SUMMARY'), 'start' => substr($item->get('DTSTART;VALUE=DATE'), 0, 8), 'end' => substr($item->get('DTEND;VALUE=DATE'), 0, 8), 'allDay' => true);
        }elseif($item->get('DTSTART')){
          $events[] = array('title' => $item->get('SUMMARY'), 'start' => substr($item->get('DTSTART'), 0, 16), 'end' => substr($item->get('DTEND'), 0, 16), 'allDay' => false);
        }
      }
      $data->set('data/json/events', $events);
    }
    /**
     * Json.
     */
    $json = json_encode($data->get('data/json'));
    /**
     * Event click.
     */
    if($data->get('data/json/eventClick')){
      $eventClick = $data->get('data/json/eventClick').'(calEvent, jsEvent, view)';
      $json = str_replace('"eventClick":"'.$data->get('data/json/eventClick').'"', '"eventClick":function(calEvent, jsEvent, view){'.$eventClick.';}', $json);
    }
    /**
     * Element.
     */
    $element = array();
    $element[] = wfDocument::createHtmlElement('div', null, array('id' => $data->get('data/id')));
    $element[] = wfDocument::createHtmlElement('script', '$(document).ready(function(){$("#'.$data->get('data/id').'").fullCalendar('.$json.');});', array('type' => 'text/javascript'));
    wfDocument::renderElement($element);
  }
}
