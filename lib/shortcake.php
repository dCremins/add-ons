<?php
add_action( 'register_shortcode_ui', 'news_ui' );

function news_ui() {
  $args = array(
    "hide_empty" => 0,
    "type"       => "post"
  );
  $category = get_categories($args);

  $test = array('' => 'All Categories');
    foreach( $category as $cats ){
      $test[$cats->slug] = $cats->name;
    }
  shortcode_ui_register_for_shortcode(
    'itre_news',
    array(
      'label'              => 'Add ITRE Recent News Widget',
      'listItemImage'      => 'dashicons-welcome-widgets-menus',
      'attrs'              => array(
          array(
            'label'        => 'Title',
            'attr'         => 'title',
            'type'         => 'text',
            'meta'         => array(
              'placeholder'=> 'New Title',
            ),
            'description'  => 'Choose a Layout',
          ),
          array(
            'label'        => '<span class="icon-trio-layout">',
            'attr'         => 'layout',
            'type'         => 'radio',
            'options'      => array(
                'layoutA'  => '',
            ),
          ),
          array(
            'label'        => '<span class="icon-double-layout">',
            'attr'         => 'layout',
            'type'         => 'radio',
            'options'      => array(
                'layoutB'  => '',
            ),
          ),
          array(
            'label'        => '<span class="icon-stacked-layout">',
            'attr'         => 'layout',
            'type'         => 'radio',
            'options'      => array(
                'layoutC'  => '',
            ),
          ),
          array(
            'label'        => '<span class="icon-four-layout">',
            'attr'         => 'layout',
            'type'         => 'radio',
            'options'      => array(
                'layoutD'  => '',
            ),
          ),
          array(
            'label'        => 'Category',
            'attr'         => 'category',
            'type'         => 'select',
            'options'      => $test,
          ),
        ),
      )
    );

}
 ?>
