<?php
/* Add Breadcrumbs */

function breadcrumbs() {
  if(!is_front_page()){
    echo '<ol class="breadcrumb">';
    echo '<li><a href="https://itre.ncsu.edu">Home</a></li>';
    echo '<li><a href="'.esc_url(home_url()).'">Research</a></li>';
    if (is_search()) {
      echo '<li class="active">Search Results</li>';
    } elseif (is_category()) {
      echo '<li><a href="';
      echo get_permalink( get_option( 'page_for_posts' ) );
      echo '">'.get_the_title(get_option( 'page_for_posts' ));
      echo '</a></li>';

      echo '<li class="active">';
      $cat = get_category( get_query_var( 'cat' ) );
    	echo $cat->name;
      echo '</li>';
    }elseif (is_single()) {
      echo '<li><a href="';
      echo get_permalink( get_option( 'page_for_posts' ) );
      echo '">'.get_the_title(get_option( 'page_for_posts' ));
      echo '</a></li>';

      echo '<li class="active">';
    	the_title();
      echo '</li>';
    } elseif (is_author()) {
      echo '<li><a href="';
      echo get_permalink( get_option( 'page_for_posts' ) );
      echo '">'.get_the_title(get_option( 'page_for_posts' ));
      echo '</a></li>';

      echo '<li class="active">';
      $name = get_category(get_query_var( 'term' ));
      echo get_queried_object()->display_name;
      echo '</li>';
    } elseif (is_page()) {
      echo '<li class="active">';
      the_title();
      echo '</li>';
    } elseif (is_home() && get_option('page_for_posts', true)) {
      echo '<li class="active">'.get_the_title(get_option('page_for_posts', true)).'</li>';
    }
    echo '</ol>';
  }
}
/* End Breadcrumbs*/

?>
