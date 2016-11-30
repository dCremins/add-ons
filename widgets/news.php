<?php

class itre_news extends WP_Widget {

	// constructor
	public function __construct(){
		$widget_details = array(
            'classname' => 'itre-news',
            'description' => 'ITRE Recent Posts Widget'
        );

        parent::__construct( 'itre_news', 'ITRE Recent Posts', $widget_details );
	}

	// widget form creation
	public function form($instance) {
		// Backend Form
    // Widget admin form
		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : 'New Title';
		$gory = ( isset( $instance['gory'] ) ) ? $instance['gory'] : 'All';
		$layout = ( isset( $instance['layout'] ) ) ? $instance['layout'] : 'A';
		$feature = ( isset( $instance['feature'] ) ) ? $instance['feature'] : 'false';
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

		<!-- Category -->
		<?php $category = get_categories();?>
		<p>
			<label for="cat" class=""><?php _e( 'Select a Category: ', 'textdomain' ); ?></label><br>
			<select id="cat" name="<?php echo $this->get_field_name('gory'); ?>" class="widefat">
				<option <?php selected( $gory, 'All'); ?> value="All">All Categories</option>
				<?php foreach( $category as $cats ){
					$value = $cats->slug;
					$name = $cats->name; ?>
	        <option <?php selected( $gory, $value); ?> value="<?php echo $value; ?>"><?php echo $name; ?></option>
				<?php }; ?>
			</select>
		</p>
		<!-- /Category -->

		<div class="layout">
      <div class="radio">
        <label for="A"><span class="icon-trio-layout"></span></label>
        <?php echo '<input type="radio" id="A" name="' . $this->get_field_name( 'layout' ) . '" value="A" ' . checked( $layout == 'A', true, false ) . '>'; ?>
      </div>

      <div class="radio">
	      <div class="radio">
					<label for="B"><span class="icon-double-layout"></span></label>
	        <?php echo '<input type="radio" id="B" name="' . $this->get_field_name( 'layout' ) . '" value="B" ' . checked( $layout == 'B', true, false ) . '>'; ?>
	      </div>
      </div>

      <div class="radio">
				<label for="C"><span class="icon-stacked-layout"></span></label>
        <?php echo '<input type="radio" id="C" name="' . $this->get_field_name( 'layout' ) . '" value="C" ' . checked( $layout == 'C', true, false ) . '>'; ?>
      </div>

      <div class="radio">
				<label for="D"><span class="icon-four-layout"></span></label>
        <?php echo '<input type="radio" id="D" name="' . $this->get_field_name( 'layout' ) . '" value="D" ' . checked( $layout == 'D', true, false ) . '>'; ?>
      </div>

		<div class="radio">
			<label for="E"><span class="icon-three-layout"></span></label>
			<?php echo '<input type="radio" id="E" name="' . $this->get_field_name( 'layout' ) . '" value="E" ' . checked( $layout == 'E', true, false ) . '>'; ?>
		</div>
	</div>

	<p><?php
		echo '<input type="checkbox" id="feature" name="' . $this->get_field_name( 'feature' ) . '" value="true" ' . checked( $feature == 'true', true, false) . '>';
		echo '<label for="feature" class="">' .  _e( '  Show Featured Image?  ', 'textdomain' ) . '</label>'; ?>
	</p>

	<?php } //End Form


	// widget update
	public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['gory'] = ( isset( $new_instance['gory'] ) ) ? $new_instance['gory'] : 'All';
		$instance['layout'] = ( isset( $new_instance['layout'] ) ) ? $new_instance['layout'] : 'A';
		$instance['feature'] =  ( isset( $new_instance['feature'] ) ) ? $new_instance['feature'] : 'false';
    return $instance;
	} //End Update

	// widget display
	public function widget($args, $instance) {
    $title = apply_filters( 'widget_title', $instance['title'] );
		$gory = $instance['gory'];
		$layout = $instance['layout'];
		$feature = ( isset( $instance['feature'] ) ) ? $instance['feature'] : 'false';
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) ){
    	echo '<h5>' . $title . '</h5>';
		}
		$number = 0;
		$class = '';
		if (! empty($layout)){
			if ($layout == 'A') {
				$number = 3;
				$class = 'layout-a';
			} elseif ($layout == 'B') {
				$number = 2;
				$class = 'layout-b';
			} elseif ($layout == 'C') {
				$number = 4;
				$class = 'layout-c';
			} elseif ($layout == 'D') {
				$number = 4;
				$class = 'layout-d';
			} elseif ($layout == 'E') {
				$number = 3;
				$class = 'layout-e';
			}
		}
		if ($gory == 'All') {$gory = '';}
    // This is where you run the code and display the output
		$stuff = array(
			'post_type' 			=> 'post',
			'category_name' 	=> $gory,
			'posts_per_page' 	=> $number,
			'no_found_rows'		=> true,
		);
		$the_query = new WP_Query( $stuff );

		if ( $the_query->have_posts() ) :
			echo '<div class="flex">';
			while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<article class="news-front <?php echo $class; ?>">
					<a class="more" href="<?php the_permalink() ?>">
					<?php if ( (has_post_thumbnail()) && ($feature === 'true')) {
						echo '<div class="news-image">';
						if ($class == 'layout-a' || $class == 'layout-d' ){
							if( $the_query->current_post == 0 && !is_paged() && $class == 'layout-a' ) {
					      the_post_thumbnail('single-post-thumbnail');
							} else {
								the_post_thumbnail('news-post-thumbnail');
							}
						} elseif ($class == 'layout-c') {
							the_post_thumbnail('author-post-thumbnail');
						} else {
							the_post_thumbnail('news-wide-post-thumbnail');
						}
						echo '</div>';
			    }
					if ($class == 'layout-c') {
						echo '<div class="flex-text">'; ?>
						<h6><?php echo get_the_title(); ?></h6>
						<p><?php echo get_the_excerpt(); echo '</p>';
						echo '</div>';
					} else { ?>
						<h6><?php echo get_the_title(); ?></h6>
						<p><?php echo get_the_excerpt(); echo '</p>';
					} ?>
				</a>
				</article>
			<?php endwhile;
			wp_reset_postdata();
			echo '</div>';
		endif;

    echo $args['after_widget'];
	} //widget end

} //class end


// register widget
add_action( 'widgets_init', function () {
    register_widget( 'itre_news' );
} );
 ?>
