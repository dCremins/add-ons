<?php
/* Add Breadcrumbs */

function breadcrumbs()
{
    if (get_theme_mod('siteURL')) {
        $url = get_theme_mod('siteURL');
    } else {
        $url = esc_url(home_url('/'));
    }
    $post_type = get_post_type();
    $post_type_object = get_post_type_object($post_type);
    $archive_label = $post_type_object->labels->name;
    $post_type_archive = get_post_type_archive_link($post_type);
    if ($post_type == 'research') {
        $archive_label = 'Research';
        $post_type_archive = $url . '/research';
    }


    if (!is_front_page()) {
        echo '<ol class="breadcrumb">';
        echo '<li><a href="' . $url . '">Home</a></li>';
        if (is_search()) {
            echo '<li class="active">Search Results</li>';
        } elseif (is_category()) {
            echo '<li><a href="';
            echo get_permalink(get_option('page_for_posts'));
            echo '">'.get_the_title(get_option('page_for_posts'));
            echo '</a></li>';
            echo '<li class="active">';
            $cat = get_category(get_query_var('cat'));
            echo $cat->name;
            echo '</li>';
        } elseif (is_archive()) {
            echo '<li class="active">';
            echo post_type_archive_title(false);
            echo '</li>';
        } elseif (is_single()) {
            echo '<li><a href="';
            echo $post_type_archive;
            echo '">'.$archive_label;
            echo '</a></li>';
            echo '<li class="active">';
            if (strlen(get_the_title()) > 40) {
                echo substr(get_the_title(), 0, 40).'...';
            } else {
                the_title();
            }
            echo '</li>';
        } elseif (is_author()) {
            echo '<li><a href="';
            echo get_permalink(get_option('page_for_posts'));
            echo '">'.get_the_title(get_option('page_for_posts'));
            echo '</a></li>';
            echo '<li class="active">';
            $name = get_category(get_query_var('term'));
            echo get_queried_object()->display_name;
            echo '</li>';
        } elseif (is_page()) {
            echo '<li class="active">';
            if (strlen(get_the_title()) > 40) {
                echo substr(get_the_title(), 0, 40).'...';
            } else {
                the_title();
            }
            echo '</li>';
        } elseif (is_home() && get_option('page_for_posts', true)) {
            echo '<li class="active">'.get_the_title(get_option('page_for_posts', true)).'</li>';
        }
        echo '</ol>';
    }
}
/* End Breadcrumbs*/
