<?php

require dirname( __FILE__ ).'../../../vendor/autoload.php';

use Carbon\Carbon;
use Functions\Calendar\itre_list;


class itre_calendar extends WP_Widget {

	// constructor
	public function __construct(){

		$widget_details = array(
            'classname' => 'calendar-widget',
            'description' => 'An ITRE Widget for the Simple Calendar Plugin'
        );

    parent::__construct( 'itre_calendar', 'ITRE Calendar', $widget_details );

	}

	// widget form creation
	public function form($instance) {

		$title          = isset( $instance['title'] )       ? esc_attr( $instance['title'] ) : __( 'Calendar', 'google-calendar-events' );
		$link           = isset( $instance['link'] )       ? esc_attr( $instance['link'] ) : '';
		$calendar_id    = isset( $instance['calendar_id'] ) ? esc_attr( $instance['calendar_id'] ) : '';

		/* Get list of available calendars */

		$calendars = array();
		$this->calendars = get_transient( '_simple-calendar_feed_ids' );

		if ( ! $calendars ) {

			$posts = get_posts( array(
				'post_type' => 'calendar',
				'nopaging'  => true,
			) );

			$calendars = array();
			foreach ( $posts as $post ) {
				$calendars[ $post->ID ] = $post->post_title;
			}
			asort( $calendars );


			set_transient( '_simple-calendar_feed_ids', $calendars, 604800 );

			/********/
		}

			?>
			<div class="simcal-calendar-widget-settings">

				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'google-calendar-events' ); ?></label>
					<br>
					<input type="text"
					       name="<?php echo $this->get_field_name( 'title' ); ?>"
					       id="<?php echo $this->get_field_id( 'title' ); ?>"
								 class="widefat"
					       value="<?php echo $title; ?>">
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'google-calendar-events' ); ?></label>
					<br>
					<input type="text"
					       name="<?php echo $this->get_field_name( 'link' ); ?>"
					       id="<?php echo $this->get_field_id( 'link' ); ?>"
								 class="widefat"
					       value="<?php echo $link; ?>">
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'calendar_id' ); ?>"><?php _e( 'Calendar:', 'google-calendar-events' ); ?></label>
					<br>
					<?php $multiselect = count( $this->calendars ) > 15 ? ' simcal-field-select-enhanced' : ''; ?>
					<select name="<?php echo $this->get_field_name( 'calendar_id' ) ?>"
					        id="<?php echo $this->get_field_id( 'calendar_id' ) ?>"
							class="simcal-field simcal-field-select<?php echo $multiselect; ?>"
							data-noresults="<?php __( 'No calendars found.', 'google-calendar-events' ); ?>">
							<?php foreach ( $this->calendars as $id => $name ) : ?>
								<option value="<?php echo $id; ?>" <?php selected( $id, $calendar_id, true ); ?>><?php echo $name; ?></option>
							<?php endforeach; ?>
					</select>
				</p>

			</div>
			<?php
  } //End Form


	// widget update
	public function update($new_instance, $old_instance) {

		$instance = array();

		$instance['title']          = ( ! empty( $new_instance['title'] ) )        ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['link']          = ( ! empty( $new_instance['link'] ) )        ? sanitize_text_field( $new_instance['link'] ) : '';
		$instance['calendar_id']    = ( ! empty( $new_instance['calendar_id'] ) )  ? absint( $new_instance['calendar_id'] ) : '';

		return $instance;
	} //End Update

	// widget display
	public function widget($args, $instance) {

		$title = $instance['title'];
		$link = ( ! empty( $instance['link'] ) ) ? $instance['link'] : '';
		$cal = $instance['calendar_id'];


		if (class_exists('\SimpleCalendar\Objects')) {
			$objects = \SimpleCalendar\plugin()->objects;

		  $calendar = $objects instanceof \SimpleCalendar\Objects ? $objects->get_calendar( $cal ) : null;
			if ( $calendar instanceof \SimpleCalendar\Abstracts\Calendar ) {

				$view = new itre_list( $calendar );

				echo $args['before_widget'];
					echo $args['before_title'];
						if ($link) {
							echo '<a href="'.$link.'">';
						}
						echo $title;
						if ($link) {
							echo '</a>';
						}
					echo $args['after_title'];
					$test = $view->sort_events($calendar->start);
				echo $args['after_widget'];

			}

		}

	} //widget end

} //class end


// register widget
add_action( 'widgets_init', function () {
    register_widget( 'itre_calendar' );
} );
 ?>
