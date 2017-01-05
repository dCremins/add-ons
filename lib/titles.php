<?php
/*  Title Filter  */

function searchTitle() {
  $title = "Search Results";
  if ( function_exists( 'coauthors_posts_links' ) ){$termslug = $_POST['author'];};
  $search = $_POST['s'];
  $start = $_POST['Sdate'];
  $end = $_POST['Edate'];
  $cat = $_POST['cat'];
  if ( isset($_POST['fileType']) ){
    $fileType = $_POST['fileType'];
  };

  if (isset($fileType) && $search){
    $title .= " for <span class='search-term'>" . $fileType . 's</span>';
    $title .= " with <span class='search-term'>" . $search . '</span>';
  } elseif ($search){
    $title .= " for <span class='search-term'>" . $search . '</span>';
  } elseif (isset($fileType)){
    $title .= " for <span class='search-term'>" . $fileType . 's</span>';
  }

  if ($termslug){
    $x = array(
      'post_type' => 'guest-author',
      'name' => $termslug,
    );
    $author = get_posts($x);
    $title .= " by <span class='search-term'>" . $author[0]->post_title . '</span>';
  }
  if ($start || $end){
    if ($start && $end){
      $start = date("M jS Y", strtotime($start));
      $end = date("M jS Y", strtotime($end));
      $title .= " between <span class='search-term'>" . $start . '</span>';
      $title .= " and <span class='search-term'>" . $end . '</span>';
    }elseif ($start){
      $start = date("M jS Y", strtotime($start));
      $title .= " after <span class='search-term'>" . $start . '</span>';
    }elseif ($end){
      $end = date("M jS Y", strtotime($end));
      $title .= " before <span class='search-term'>" . $end . '</span>';
    }
  }
  if ($cat){
    $title .= " in <span class='search-term'>" . get_category_by_slug($cat)->name . '</span>';
  }
  return $title;
}
/* End Title */
?>
