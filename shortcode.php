<?php

function itre_news_shortcode($atts) {
  extract(shortcode_atts(array(
      'title'   => 'New Title',
      'layout'   => 'layoutA',
      'category' => '',
   ), $atts));


   $number = 1;
   if ($layout == 'layoutA') {
     $number = 3;
   } elseif ($layout == 'layoutB') {
     $number = 2;
   } elseif ($layout == 'layoutC') {
     $number = 4;
   } elseif ($layout == 'layoutD') {
     $number = 4;
   }
   $output = '';

   $the_query = new WP_Query( array(
    'post_type'       => 'post',
    'category_name'   => $category,
    'posts_per_page'  => $number,
    'no_found_rows'		=> true,
));


   $output .= ' <section class="itre_news"> ';
   $output .= '<h3>' . $title . '</h3>';

   if ( $the_query->have_posts() ) {
     while ( $the_query->have_posts() ) {
       $the_query->the_post();
        $output .= ' <article class="newsFront ' . $layout . '"> ';

         if ( has_post_thumbnail() ) {
           $output .= ' <div class="newsImage"> ';
           if ($layout == 'layoutA' || $layout == 'layoutD' ){
             if( $the_query->current_post == 0 && !is_paged() && $layout == 'layoutA' ) {
              $output .= get_the_post_thumbnail(get_the_ID(), 'single-post-thumbnail');
             } else {
               $output .= get_the_post_thumbnail(get_the_ID(), 'news-post-thumbnail');
             }
           } elseif ($layout == 'layoutC') {
             $output .= get_the_post_thumbnail(get_the_ID(), 'author-post-thumbnail');
           } else {
             $output .= get_the_post_thumbnail(get_the_ID(), 'news-wide-post-thumbnail');
           }
           $output .= ' </div> ';
         }

         if ($layout == 'layoutC') {
           $output .= ' <div class="floatD"> ';
           $output .= ' <h4><a href="' . get_the_permalink() . '"> ' . get_the_title() . ' </a></h4> ';
           $output .= get_the_excerpt();
           $output .= ' </div> ';
         } else {
           $output .= ' <h4><a href="' . get_the_permalink() . '"> ' . get_the_title() . '</a></h4> ';
           $output .= get_the_excerpt();
         }

       $output .= ' </article> ';
     }
   }

wp_reset_postdata();
   $output .= ' </section> ';

   return $output;
}

add_shortcode( 'itre_news',  'itre_news_shortcode' );
 ?>
