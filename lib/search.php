<?php
function filter($query)
{
    if ($query->is_search && !is_admin() && $query->is_main_query()) {
        if (isset($_REQUEST['search']) && $_REQUEST['search'] == 'advanced') {
/* Limit to Posts */
            $query->set('post_type', 'post');
            $query->set('post_per_page', 20);

/* Keyword */
            if (isset($_POST['s'])) {
                $query->set('s', $_POST['s']);
            }

/* Author Name */
						if (isset($_POST['authors']) && $_POST['authors'] != '') {
							$query->set('tax_query', [
								[
									'taxonomy' 	=> 'byline',
									'field' 		=> 'slug',
									'terms' 		=> $_POST['authors']
								]
							]);
						}

/* Category */
            if (isset($_POST['cat'])) {
                $query->set('category_name', $_POST['cat']);
            }

/* Date */
            if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $date_query = array(
                    array(
                        'after'         => $_POST['startDate'],
                        'before'        => $_POST['endDate'],
                        'inclusive' => true,
                    ),
                );
                $query->set('date_query', $date_query);
            } else {
                if (isset($_POST['endDate'])) {
                    $date_query = array(
                        array(
                            'after'         => $_POST['endDate'],
                            'inclusive' => true,
                        ),
                    );
                    $query->set('date_query', $date_query);
                }
                if (isset($_POST['startDate'])) {
                    $date_query = array(
                        array(
                            'after'         => $_POST['startDate'],
                            'inclusive' => true,
                        ),
                    );
                    $query->set('date_query', $date_query);
                }
            }

/* File Type */
            if (isset($_POST['fileType'])) {
                add_filter('posts_where', 'my_posts_where');
                $query->set(
                    'meta_query',
                    array(
                        array(
                            'key'      => 'files_%_type',
                            'compare'  => '==',
                            'value'    => $_POST['fileType'],
                        )
                    )
                );
            }
        } // End If Advanced Search
    } // End If Search

    return $query;
}; // End Function

add_action('pre_get_posts', 'filter');

// Replace SQL Query = with LIKE for Repeater Field
function my_posts_where($where)
{
    $where = str_replace("meta_key = 'files_%", "meta_key LIKE 'files_%", $where);
    return $where;
}
