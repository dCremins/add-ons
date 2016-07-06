<?php
function searchTitle() {
  $title = "Search Results";
  if ( function_exists( 'coauthors_posts_links' ) ){$termslug = $_POST['author'];};
  $search = $_POST['s'];
  $start = $_POST['Sdate'];
  $end = $_POST['Edate'];
  $cat = $_POST['cat'];
  if ( function_exists( 'get_field' ) ){
    $fileType = $_POST['fileType'];
  };

  if ($fileType && $search){
    $title .= " for <span class='searchTerm'>" . $fileType . 's</span>';
    $title .= " with <span class='searchTerm'>" . $search . '</span>';
  } elseif ($search){
    $title .= " for <span class='searchTerm'>" . $search . '</span>';
  } elseif ($fileType){
    $title .= " for <span class='searchTerm'>" . $fileType . 's</span>';
  }

  if ($termslug){
    $x = array(
      'post_type' => 'guest-author',
      'name' => $termslug,
    );
    $author = get_posts($x);
    $title .= " by <span class='searchTerm'>" . $author[0]->post_title . '</span>';
  }
  if ($start || $end){
    if ($start && $end){
      $start = date("M jS Y", strtotime($start));
      $end = date("M jS Y", strtotime($end));
      $title .= " between <span class='searchTerm'>" . $start . '</span>';
      $title .= " and <span class='searchTerm'>" . $end . '</span>';
    }elseif ($start){
      $start = date("M jS Y", strtotime($start));
      $title .= " after <span class='searchTerm'>" . $start . '</span>';
    }elseif ($end){
      $end = date("M jS Y", strtotime($end));
      $title .= " before <span class='searchTerm'>" . $end . '</span>';
    }
  }
  if ($cat){
    $title .= " in <span class='searchTerm'>" . get_category_by_slug($cat)->name . '</span>';
  }
  return $title;
}

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
/* Add above content */
//add_action('loop_start', 'mybreadcrumbs');

/* End Breadcrumbs*/

?>
