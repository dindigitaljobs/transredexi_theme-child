function tag_widget_limit($args){ 
  if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
    $args['number'] = 15; //número desejado
  }

  return $args;
}
add_filter('widget_tag_cloud_args', 'tag_widget_limit');