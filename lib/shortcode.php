<?php
/*  ITRE NEWS  */

function itre_news_shortcode($atts) {
  extract(shortcode_atts(array(
      'title'			=> 'New Title',
      'layout'		=> 'layoutA',
      'category'	=> '',
      'type'			=> '',
      'link'			=> '',
      'feature'		=> false,
   ), $atts));


   $number = 1;
   if ($layout == 'layoutA') {
     $number = 3;
		 $class = 'layout-a';
   } elseif ($layout == 'layoutB') {
     $number = 2;
		 $class = 'layout-a';
   } elseif ($layout == 'layoutC') {
     $number = 4;
		 $class = 'layout-a';
   } elseif ($layout == 'layoutD') {
     $number = 4;
		 $class = 'layout-a';
   } elseif ($layout == 'layoutE') {
     $number = 4;
		 $class = 'layout-e';
   }
   $output = '';

   $the_query = new WP_Query( array(
    'post_type'       => $type,
    'category_name'   => $category,
    'posts_per_page'  => $number,
    'no_found_rows'		=> true,
));


   $output .= ' <section class="itre-news"> ';
	 if (! empty($title)) {
			 $output .='<h3>';
			 if ($link) {
					 $output .='<a href="'.$link.'">';
			 }
			 $output .=$title;
			 if ($link) {
					 $output .='</a>';
			 }
			 $output .='</h3>';
	 }

	 if ($the_query->have_posts()) {
		 $output .='<div class="flex">';
		 while ($the_query->have_posts()) {
			 $the_query->the_post();
			 $output .='<article class="news-front ' . $class . '">';
			 $output .='<a class="more" href="' . get_the_permalink() . '">';
			 if ((has_post_thumbnail()) && ($feature === 'true')) {
				 $id = get_the_ID();
				 $output .='<div class="news-image">';
				 if ($layout == 'layoutA' || $layout == 'layoutD') {
					 if ($the_query->current_post == 0 && !is_paged() && $layout == 'layoutA') {
						 $output .= get_the_post_thumbnail($id, 'single-post-thumbnail');
					 } else {
						 $output .= get_the_post_thumbnail($id, 'news-post-thumbnail');
					 }
				 } elseif ($layout == 'layoutC') {
					 $output .= get_the_post_thumbnail($id, 'author-post-thumbnail');
				 } else {
					 $output .= get_the_post_thumbnail($id, 'news-wide-post-thumbnail');
				 }
				 $output .='</div>';
			 }
			 if ($layout == 'layoutC') {
				 $output .='<div class="flex-text">';
				 $output .='<h6>' . get_the_title() . '</h6>';
				 $output .='<p>' . get_the_excerpt();
				 $output .='</p>';
				 $output .='</div>';
			 } else {
				 $output .='<h5>' . get_the_title() . '</h5>';
				 $output .='<p>' . get_the_excerpt();
				 $output .='</p>';
			 }
			 $output .='</a></article>';
		 }
		 wp_reset_postdata();
		 $output .='</div>';
	 }

wp_reset_postdata();
   $output .= ' </section> ';

   return $output;
}

add_shortcode( 'itre_news',  'itre_news_shortcode' );
 ?>
