<?php
add_action( 'register_shortcode_ui', 'news_ui' );

function news_ui() {
  $args = array(
    "hide_empty" => 0,
    "type"       => "post"
  );
  $category = get_categories();
	$post_types = get_post_types('', 'names');

  $types = array('' => 'Default');
  foreach( $post_types as $type ){
		if ($type == 'attachment'
		|| $type == 'acf-field'
		|| $type == 'acf-field-group'
		|| $type == 'guest-author'
		|| $type == 'page'
		|| $type == 'revision'
		|| $type == 'nav_menu_item'
		|| $type == 'custom_css'
		|| $type == 'customize_changeset'
		|| $type == 'oembed_cache') {
				continue;
		}
    $types[$type] = ucfirst($type);
  }

  $cat = array('' => 'All Categories');
  foreach( $category as $cats ){
    $cat[$cats->slug] = $cats->name;
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
              'placeholder'=> '',
            ),
          ),
          array(
            'label'        => 'Link',
            'attr'         => 'link',
            'type'         => 'text',
            'meta'         => array(
              'placeholder'=> '',
            ),
          ),
          array(
            'label'        => 'Category',
            'attr'         => 'category',
            'type'         => 'select',
            'options'      => $cat,
          ),
          array(
            'label'        => 'Post Type',
            'attr'         => 'type',
            'type'         => 'select',
            'options'      => $types,
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
            'label'        => '<span class="icon-three-layout">',
            'attr'         => 'layout',
            'type'         => 'radio',
            'options'      => array(
                'layoutE'  => '',
            ),
          ),
          array(
            'label'        => 'Show Featured Image?',
            'attr'         => 'feature',
            'type'         => 'checkbox',
          ),
        ),
      )
    );

}
 ?>
