<?php

class itre_search extends WP_Widget {

	// constructor
	public function __construct(){
		$widget_details = array(
        'classname' => 'itre_search',
        'description' => 'Custom Research Search Widget'
    );

    parent::__construct( 'itre_search', 'Search Research', $widget_details );
	}

	// widget form creation
	public function form($instance) {
		// Backend Form
	}

	// widget update
	public function update($new_instance, $old_instance) {

	}

	// widget display
	public function widget($args, $instance) {
		global $post, $post_ID, $wpdb;

    // Get Authors Options
		if ( function_exists( 'coauthors_posts_links' ) ) { // If Co Authors Installed
      global $coauthors_plus;
    	$args = array( 'post_type' => 'guest-author', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' );
    	$guest_authors = get_posts( $args );
			$tax = $coauthors_plus->coauthor_taxonomy;
			$terms = get_terms($tax);
		}
		$category = get_categories();


    // Get File Type Options
    if (class_exists('acf')){ // If ACF Installed

/** Dynamically get the Post ID of the first post **/
      $sql = $wpdb->prepare( "select post_id from " . $wpdb->prefix . "postmeta where meta_key = %s limit 0,1 ", 'files');
      $post = $wpdb->get_results( $sql );

/** Get the File Type sub field from the first post
Then store the field object into our variable **/
      if( get_field('files', $post[0]->post_id) ){
        while( has_sub_field('files', $post[0]->post_id) ){
          $fileType = get_sub_field_object('type', $post[0]->post_id);
        }
      }
    }
		?>

		<form method="post" class="search-form form-horizontal" id="advanced-searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">

		  <h3><?php _e( 'Advanced Search', 'textdomain' ); ?></h3>

			<input type="hidden" name="search" value="advanced">
      <!-- Keyword -->
		  <div class="input-group">
		    <label class="hidden" for="s"><?php _e('Keyword:'); ?></label>
		    <input type="search" value="<?php //the_search_query(); ?>" placeholder="Keyword" class="form-control" id="s">
		  </div>
      <!-- /Keyword -->

      <!-- Author -->
		<?php if ( function_exists( 'coauthors_posts_links' ) ) {?>
		  <div class="input-group">
		    <label for="<?php echo $tax; ?>" class=""><?php _e( 'Select an Author: ', 'textdomain' ); ?></label><br>
		    <select id="<?php echo $tax; ?>" class="form-control">
					<optgroup label="Authors">
			      <option selected value="">All Authors</option>
			      <?php foreach( $guest_authors as $ga ){?>
			        <option value="<?php echo $ga->post_name; ?>"><?php echo $ga->post_title; ?></option>
			      <?php }; ?>
					</optgroup>
		    </select>
		  </div>
			<?php }?>
      <!-- /Author -->

      <!-- Category -->
		  <div class="input-group">
		    <label for="cat" class=""><?php _e( 'Select a Category: ', 'textdomain' ); ?></label><br>
		    <select id="cat" class="form-control">
					<optgroup label="Categories">
			      <option selected value="">All Categories</option>
			      <?php foreach( $category as $cats ){?>
			        <option value="<?php echo $cats->slug?>"><?php echo $cats->name; ?></option>
			      <?php }; ?>
					</optgroup>
		    </select>
		  </div>
      <!-- /Category -->

      <!-- File Type -->
      <?php if (function_exists('the_field') && get_field('files')){ ?>
      <div class="input-group">
        <label for="fileType" class=""><?php _e( 'Select a Document Type: ', 'textdomain' ); ?></label><br>
        <select id="fileType" class="form-control">
          <option value="">All Types</option>
          <?php foreach( $fileType['choices'] as $k => $v ){?>
            <option value="<?php echo $k?>"><?php echo $v; ?></option>
          <?php }; ?>
        </select>
      </div>
      <?php }; ?>
      <!-- /File Type -->

      <!-- Start Date -->
      <div class="input-group date-search">
  		  <div class="dateSearch">
  		    <label for="startDate" class=""><?php _e( 'Search Between ', 'textdomain' ); ?></label><br>
  		    <input type="date" value="" id="startDate" placeholder="Start">
  		  </div>
        <!-- /Start Date -->

  		  <div class="divider"> to </div>

        <!-- End Date -->
  		  <div class="dateSearch">
  		    <label for="endDate" class=""><?php _e( '  ', 'textdomain' ); ?></label><br>
  		    <input type="date" value="" id="endDate">
  		  </div><!-- /input-group -->
  			<div style="clear:both;"></div>
      </div>

		<div class="input-group">
			<span class="input-group-btn">
				<button class="btn" type="submit">Search</button>
			</span>
		</div>
      <!-- /End Date -->
		</form> <?php
	} //widget end

} //class end

// register widget
add_action( 'widgets_init', function () {
    register_widget( 'itre_search' );
} );



 ?>
