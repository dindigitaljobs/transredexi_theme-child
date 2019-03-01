<?php  

function change_services($args, $post_type){
  if ($post_type == 'services'){
    $args['rewrite'] = array('slug'=>'servicos');

    $args['labels'] = array(
      'name' => 'Serviços',
      'singular_name' => 'Serviço',
      'add_new_item' => 'Adicionar novo Serviço',
      'view_item' => 'Ver serviço'
    );

    $args['name'] = 'servicos';

    $args['labels'] = array(
      'name' => 'Serviços',
      'singular_name' => 'Serviço',
      'add_new_item' => 'Adicionar novo Serviço',
      'view_item' => 'Ver serviço'
    );
  }
  return $args;
}
add_filter('register_post_type_args', 'change_services', 10, 2);

function modify_Post_services(){
  // var_dump(get_post_types($args, 'objects')); exit; 
}
add_action('init', 'modify_Post_services');