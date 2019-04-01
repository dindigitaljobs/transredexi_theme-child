<?php
//Register tag cloud filter callback
add_filter('widget_tag_cloud_args', 'tag_widget_limit');
 
//Limit number of tags inside widget
function tag_widget_limit(){
  $args = array(
    'number' => 10
  );
  return $args;
}
 