<?php

class itre_callout extends WP_Widget {

	// constructor
	public function __construct(){
		$widget_details = array(
            'classname' => 'itre_callout',
            'description' => 'ITRE Callout Widget'
        );

        parent::__construct( 'itre_callout', 'ITRE Callout', $widget_details );
	}

	// widget form creation
	public function form($instance) {
		// Backend Form

  } //End Form


	// widget update
	public function update($new_instance, $old_instance) {
    $instance = array();

    return $instance;
	} //End Update

	// widget display
	public function widget($args, $instance) {

	} //widget end

} //class end


// register widget
add_action( 'widgets_init', function () {
    register_widget( 'itre_callout' );
} );
 ?>
