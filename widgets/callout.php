<?php

class itre_callout extends WP_Widget {

	// constructor
	public function __construct(){
		$widget_details = array(
            'classname' => 'itre-callout',
            'description' => 'ITRE Callout Widget',
				    'before_title'  => '<h4>',
				    'after_title'   => '</h4>'
        );

        parent::__construct( 'itre_callout', 'ITRE Callout', $widget_details );
	}

	// widget form creation
	public function form($instance) {
		// Backend Form
		$title = ( isset( $instance['title'] ) ) ? $instance['title'] : 'New Title';
		$text = ( isset( $instance['text'] ) ) ? $instance['text'] : '';
		$link = ( isset( $instance['link'] ) ) ? $instance['link'] : '';
		$linktext = ( isset( $instance['linktext'] ) ) ? $instance['linktext'] : '';
		$icon = ( isset( $instance['icon'] ) ) ? $instance['icon'] : 'none';
		?>

		<p>
			<label for="icon"><?php _e( 'Select an Icon: ', 'textdomain' ); ?></label><br>
			<select name="<?php echo $this->get_field_name('icon'); ?>" class="widefat">
				<option <?php selected( $icon, 'none'); ?> value="none">No Icon</option>
				<option <?php selected( $icon, 'inverse-trio'); ?> value="inverse-trio">Three Item Layout</option>
				<option <?php selected( $icon, 'inverse-double'); ?> value="inverse-double">Two Item Layout</option>
				<option <?php selected( $icon, 'inverse-stacked'); ?> value="inverse-stacked">Stacked Layout</option>
				<option <?php selected( $icon, 'inverse-four'); ?> value="inverse-four">Four Item Layout</option>
				<option <?php selected( $icon, 'papers'); ?> value="papers">Papers</option>
				<option <?php selected( $icon, 'letter'); ?> value="letter">Envelope</option>
				<option <?php selected( $icon, 'bike'); ?> value="bike">Bicycle</option>
			</select>
		</p>

    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
      <input class="widefat" name="<?php echo $this->get_field_name( 'text' ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
      <input class="widefat" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'linktext' ); ?>"><?php _e( 'Link Text:' ); ?></label>
      <input class="widefat" name="<?php echo $this->get_field_name( 'linktext' ); ?>" type="text" value="<?php echo esc_attr( $linktext ); ?>" />
    </p>

		<?php
  } //End Form


	// widget update
	public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['icon'] = ( ! empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
    $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
    $instance['linktext'] = ( ! empty( $new_instance['linktext'] ) ) ? strip_tags( $new_instance['linktext'] ) : '';
    return $instance;
	} //End Update

	// widget display
	public function widget($args, $instance) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$icon = $instance['icon'];
		$text = $instance['text'];
		$link = $instance['link'];
		$linktext = $instance['linktext'];

		// before and after widget arguments are defined by themes
    echo $args['before_widget'];

		if ($icon != 'none') {

			echo '<div class="icon"><span class="icon-'.$icon.'" aria-hidden="true"></span></div>';
		}

    if ( ! empty( $title ) ){
    	echo '<h5>' . $title . '</h5>';
		}

		if ( ! empty( $text ) ){
    	echo '<h6><strong>'.$text.'</strong></h6>';
		}

		if ( ! empty( $link ) && ! empty($linktext) ){
    	echo '<p><a class="more" href="'.$link.'">'.$linktext.'  <span class="glyphicon glyphicon-bold-arrow"></span></a></p>';
		}
		echo $args['after_widget'];
	} //widget end

} //class end


// register widget
add_action( 'widgets_init', function () {
    register_widget( 'itre_callout' );
} );
 ?>
