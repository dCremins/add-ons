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
		 $class = 'layout-b';
   } elseif ($layout == 'layoutC') {
     $number = 4;
		 $class = 'layout-c';
   } elseif ($layout == 'layoutD') {
     $number = 4;
		 $class = 'layout-d';
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
		 $output .='<div class="flex flex-' . $class . '">';
		 while ($the_query->have_posts()) {
			 $the_query->the_post();
			 $output .='<article class="news-front ' . $class . '">';
			 $output .='<a class="more" href="' . get_the_permalink() . '">';
			 if ((has_post_thumbnail()) && ($feature === 'true')) {
				 $id = get_the_ID();
				 $output .='<span class="news-image">';
 					switch ($layout) {
 						case 'layoutA':
 						case 'layoutD':
 							$output .= get_the_post_thumbnail($id, 'itre-news-lg');
 							break;
 						case 'layoutC':
						case 'layoutE':
 							$output .= get_the_post_thumbnail($id, 'itre-news-sm');
 							break;
 						default:
 							$output .= get_the_post_thumbnail($id, 'itre-news-md');
 							break;
						}
				 $output .='</span>';
			 }
			 if ($layout == 'layoutC') {
				 $output .='<span class="flex-text">';
				 $output .='<h6>' . get_the_title() . '</h6>';
				 $output .='<p>' . get_the_excerpt();
				 $output .='</p>';
				 $output .='</span>';
			 } else {
				 $output .='<span class="news-text">';
				 $output .='<h5>' . get_the_title() . '</h5>';
				 $output .='<p>' . get_the_excerpt();
				 $output .='</p>';
				 $output .='</span>';
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
