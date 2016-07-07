<?php
/*  Title Filter  */

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
/* End Title */
?>
