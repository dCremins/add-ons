<?php
/*  Title Filter  */

function searchTitle() {
  $title = "Search Results";

  if (isset( $_POST['s'] ) && isset( $_POST['fileType'] ) && $_POST['s'] != '' && $_POST['fileType'] != '') {
    $title .= " for <span class='search-term'>" . $_POST['fileType'] . 's</span>';
    $title .= " with <span class='search-term'>" . $_POST['s'] . '</span>';
  } elseif (isset( $_POST['s'] ) && $_POST['s'] != '') {
    $title .= " for <span class='search-term'>" . $_POST['s'] . '</span>';
  } elseif (isset( $_POST['fileType'] ) && $_POST['fileType'] != '') {
    $title .= " for <span class='search-term'>" . $_POST['fileType'] . 's</span>';
  }

  if (isset( $_POST['authors'] ) && $_POST['authors'] != '') {
    $title .= " by <span class='search-term'>" . $_POST['authors'] . '</span>';
  }

  if (isset( $_POST['startDate'] ) && isset( $_POST['endDate'] ) && $_POST['endDate'] != '' && $_POST['startDate'] != ''){
    $start = date("M jS Y", strtotime($_POST['startDate']));
    $end = date("M jS Y", strtotime($_POST['endDate']));
    $title .= " between <span class='search-term'>" . $start . '</span>';
    $title .= " and <span class='search-term'>" . $end . '</span>';
  } elseif (isset( $_POST['startDate'] ) && $_POST['startDate'] != '') {
    $start = date("M jS Y", strtotime($_POST['startDate']));
    $title .= " after <span class='search-term'>" . $start . '</span>';
  } elseif (isset( $_POST['endDate'] ) && $_POST['endDate'] != '' ) {
    $end = date("M jS Y", strtotime($_POST['endDate']));
    $title .= " before <span class='search-term'>" . $end . '</span>';
  }

  if (isset( $_POST['cat'] ) && $_POST['cat'] != '') {
    $title .= " in <span class='search-term'>" . get_category_by_slug($_POST['cat'])->name . '</span>';
  }
  return $title;
}
/* End Title */
?>
