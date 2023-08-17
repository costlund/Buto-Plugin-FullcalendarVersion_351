<?php
/**
<h1>Javascript calendar</h1>
 */
class PluginFullcalendarVersion_351{
  /**
   * Include in head.
   * Set data/lang for a specific language or leave empty to check for globals-sys/settings/i18n/language.
   */
  public static function widget_include($data){
    wfPlugin::includeonce('wf/array');
    $language = wfI18n::getLanguage();
    $data = new PluginWfArray($data);
    $element = array();
    $element[] = wfDocument::createHtmlElement('link', null, array('href' => '/plugin/fullcalendar/version_351/fullcalendar.css', 'rel' => 'stylesheet'));
    //$element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/lib/jquery.min.js', 'type' => 'text/javascript'));
    $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/lib/moment.min.js', 'type' => 'text/javascript'));
    $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/fullcalendar.js?i=1', 'type' => 'text/javascript'));
    if($data->get('data/lang')){
      $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/locale/'.$data->get('data/lang').'.js', 'type' => 'text/javascript'));
    }elseif($language){
      if($language == 'en'){
        $language = 'en-gb';
      }
      $element[] = wfDocument::createHtmlElement('script', null, array('src' => '/plugin/fullcalendar/version_351/locale/'.$language.'.js', 'type' => 'text/javascript'));
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
      $calendar = PluginFullcalendarVersion_351::getGoogleCalendar($data->get('data/google_calendar'));
      
      /**
       * Create events.
       */
      $events = array();
      foreach ($calendar->get('event') as $key => $value) {
        $item = new PluginWfArray($value);
        if($item->get('DTSTART;VALUE=DATE')){
          $events[] = array('title' => $item->get('SUMMARY'), 'start' => wfPhpfunc::substr($item->get('DTSTART;VALUE=DATE'), 0, 8), 'end' => wfPhpfunc::substr($item->get('DTEND;VALUE=DATE'), 0, 8), 'allDay' => true);
        }elseif($item->get('DTSTART')){
          $events[] = array('title' => $item->get('SUMMARY'), 'start' => date('Y-m-d H:i:s', strtotime(wfPhpfunc::substr($item->get('DTSTART'), 0, 16))), 'end' => date('Y-m-d H:i:s', strtotime(wfPhpfunc::substr($item->get('DTEND'), 0, 16))), 'allDay' => false);
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
      $json = wfPhpfunc::str_replace('"eventClick":"'.$data->get('data/json/eventClick').'"', '"eventClick":function(calEvent, jsEvent, view){'.$eventClick.';}', $json);
    }
    /**
     * Element.
     */
    $element = array();
    $element[] = wfDocument::createHtmlElement('div', null, array('id' => $data->get('data/id')));
    $element[] = wfDocument::createHtmlElement('script', '$(document).ready(function(){$("#'.$data->get('data/id').'").fullCalendar('.$json.');});', array('type' => 'text/javascript'));
    wfDocument::renderElement($element);
  }
  /**
   * 
   */
  private static function getGoogleCalendar($google_calendar){
    wfPlugin::includeonce('google/calendar');
    $google = new PluginGoogleCalendar();
    $google->filename = $google_calendar;
    $google->init();
    return new PluginWfArray($google->calendar);
  }
  public function page_json(){
    wfPlugin::includeonce('wf/yml');
    $json = new PluginWfYml(__DIR__.'/default/json.yml');
    $json = json_encode($json->get());
    exit($json);
  }
}
