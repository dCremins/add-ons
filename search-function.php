<?php
function filter( $query ) {
  if ( !is_admin() && $query->is_main_query()) {
    if ($query->is_search) {

      // Set Variables
      if ( function_exists( 'coauthors_posts_links' ) ){
        $termslug = $_POST['author'];
      };
      $search = $_POST['s'];
      $start = $_POST['Sdate'];
      $end = $_POST['Edate'];
      $cat = $_POST['cat'];


      if ( function_exists( 'get_field' ) ){
        $fileType = $_POST['fileType'];
      };

      // Limit to Posts
      $query->set('post_type', 'post');
      $query->set('post_per_page', 20);

      // Search by Keyword
      if($search){
        $query->set('s', $search);
      }

      // Search by Author
      if ( function_exists( 'coauthors_posts_links' ) ){ // Co-Author Installed
        if($termslug){
          $query->set(
            'tax_query',
            array(
              array(
                'taxonomy' => 'author',
                'field' => 'slug',
                'terms' => $termslug,
                'operator' => 'AND'
              )
            )
          );

        };
      };

      // Search by Category
      if($cat){
        $query->set( 'category_name', $cat);
      };

      // Search by File Type
      if ( function_exists( 'get_field' ) ){ // ACF Installed
        if( $fileType ){
          // Run SQL Replace Function
          add_filter('posts_where', 'my_posts_where');

          $query->set(
            'meta_query',
            array(
              array(
                'key'		=> 'files_%_type',
			          'compare'	=> '==',
			          'value'		=> $fileType,
              )
            )
          );

        };
      };

      // Search between Dates
      if($start && $end){      // Both dates picked
        $date_query = array(
          array(
            'after'     => $start,
            'before'    => $end,
            'inclusive' => true,
          ),
        );
        $query->set( 'date_query', $date_query );
      } else {      // Only one date picked

      // AFTER this date
        if($start){
          $date_query = array(
            array(
              'after'     => $start,
              'inclusive' => true,
            ),
          );
          $query->set( 'date_query', $date_query );
        };

        // BEFORE this date
        if($end){
          $date_query = array(
            array(
              'before'     => $end,
              'inclusive' => true,
            ),
          );
          $query->set( 'date_query', $date_query );
        };

      };// End Date Search

    };
  };
  return $query;
}; // End Function

add_action( 'pre_get_posts', 'filter' );

// Replace SQL Query = with LIKE for Repeater Field
function my_posts_where( $where ) {
	$where = str_replace("meta_key = 'files_%", "meta_key LIKE 'files_%", $where);
	return $where;
}

 ?>
