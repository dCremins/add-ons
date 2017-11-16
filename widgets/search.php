<?php

namespace AddOn\Search;

class ItreSearch extends \WP_Widget
{

// constructor
    public function __construct()
    {
        $widget_details = array(
        'classname' => 'ItreSearch',
        'description' => 'Custom Research Search Widget'
        );

        parent::__construct('ItreSearch', 'Search Research', $widget_details);
    }

    // widget form creation
    public function form($instance)
    {
        // Backend Form
    }

    // widget update
    public function update($new_instance, $old_instance)
    {
    }

    // widget display
    public function widget($args, $instance)
    {
        global $post, $post_ID, $wpdb;
        $category = get_categories();
// Get File Type Options
        if (class_exists('acf')) { // If ACF Installed
// Dynamically get the Post ID of the first post
            $sql = $wpdb->prepare("select post_id from " . $wpdb->prefix . "postmeta where meta_key = %s limit 0,1 ", 'files');
            $post = $wpdb->get_results($sql);
// Get the File Type sub field from the first post
// Then store the field object into our variable
            if ($post) {
              if (get_field('files', $post[0]->post_id)) {
                  while (has_sub_field('files', $post[0]->post_id)) {
                      $fileType = get_sub_field_object('type', $post[0]->post_id);
                  }
              }
            }
        }
        ?>

        <form method="post" class="search-form form-horizontal" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url('/')); ?>">
            <h3><?php _e('Advanced Search', 'textdomain'); ?></h3>
            <input type="hidden" name="search" value="advanced">
<!-- Keyword -->
            <div class="input-group">
                <label class="hidden" for="s"><?php _e('Keyword:'); ?></label>
                <input type="search" placeholder="Keyword" class="form-control" name="s">
            </div>
<!-- /Keyword -->

<!-- Author -->
					<?php if (class_exists( 'Bylines\Objects\Byline' )) {
						 $terms = get_terms('byline');?>
             <div class="input-group">
	             <label for="authors" class=""><?php _e('Select an Author: ', 'textdomain'); ?></label><br>
							 <select name="authors"  class="form-control">
								 <optgroup label="Authors">
									 <option selected value="">All Authors</option>
									 <?php foreach ($terms as $byline) {
										 if ((get_user_by('ID', $byline->ID)) || get_user_by('slug', $byline->slug)) {
											 //
											 echo 'nope';
										 } else { ?>
											 <option value="<?php echo $byline->slug; ?>"><?php echo $byline->name; ?></option>
									 <?php  }
									 ?>
									 <?php }; ?>
								 </optgroup>
							 </select>
					 	</div>
					 <?php }?>
<!-- /Author -->

<!-- Category -->
            <div class="input-group">
                <label for="cat" class=""><?php _e('Select a Category: ', 'textdomain'); ?></label><br>
                <select name="cat" class="form-control">
                    <optgroup label="Categories">
                        <option selected value="">All Categories</option>
                        <?php
                        foreach ($category as $cats) { ?>
                        <option value="<?php echo $cats->slug?>"><?php echo $cats->name; ?></option>
                        <?php
                        }; ?>
                    </optgroup>
                </select>
            </div>
<!-- /Category -->

<!-- File Type -->
        <?php
        if (class_exists('acf') && get_field('files')) { ?>
            <div class="input-group">
              <label for="fileType" class=""><?php _e('Select a Document Type: ', 'textdomain'); ?></label><br>
              <select name="fileType" class="form-control">
                  <option value="">All Types</option>
                <?php
                foreach ($fileType['choices'] as $k => $v) {?>
                  <option value="<?php echo $k?>"><?php echo $v; ?></option>
            <?php
                };
            ?>
              </select>
          </div>
        <?php
        };
        ?>
<!-- /File Type -->

<!-- Start Date -->
            <div class="input-group date-search">
                <div class="dateSearch">
                    <label for="startDate" class=""><?php _e('Search Between ', 'textdomain'); ?></label><br>
                    <input type="date" value="" name="startDate" placeholder="Start">
                </div>
<!-- /Start Date -->
                <div class="divider"> to </div>

<!-- End Date -->
                <div class="dateSearch">
                    <label for="endDate" class=""><?php _e('  ', 'textdomain'); ?></label><br>
                    <input type="date" value="" name="endDate">
                </div>
<!-- /input-group -->
                <div style="clear:both;"></div>
            </div>

            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn" type="submit" value="Search" alt="Search">Search</button>
                </span>
            </div>
<!-- /End Date -->
        </form> <?php
    } //widget end
} //class end

// register widget
add_action('widgets_init', function () {
    register_widget(__NAMESPACE__ . '\\ItreSearch');
});
