<?php

namespace AddOn\News;

class ItreNews extends \WP_Widget {
	public function __construct() {
		$widget_details = array(
			'classname' => 'itre-news',
			'description' => 'ITRE Recent Posts Widget'
		);
		parent::__construct('ItreNews', 'ITRE Recent Posts', $widget_details);
	}

	public function form($instance) {
		// Widget admin form
		$title = (isset($instance['title'])) ? $instance['title'] : 'New Title';
    $link  = isset($instance['link']) ? esc_attr($instance['link']) : '';
    $gory = (isset($instance['gory'])) ? $instance['gory'] : 'All';
    $type = (isset($instance['type'])) ? $instance['type'] : 'post';
    $layout = (isset($instance['layout'])) ? $instance['layout'] : 'A';
    $feature = (isset($instance['feature'])) ? $instance['feature'] : 'false';
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
		<p>
	  	<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
    </p>

    <!-- Category -->
    <?php $category = get_categories();?>
    <p>
        <label for="cat" class=""><?php _e('Select a Category: ', 'textdomain'); ?></label><br>
        <select id="cat" name="<?php echo $this->get_field_name('gory'); ?>" class="widefat">
            <option <?php selected($gory, 'All'); ?> value="All">All Categories</option>
            <?php foreach ($category as $cats) {
                $value = $cats->slug;
                $name = $cats->name; ?>
        <option <?php selected($gory, $value); ?> value="<?php echo $value; ?>"><?php echo $name; ?></option>
            <?php }; ?>
        </select>
    </p>
    <!-- /Category -->

    <!-- Post Types -->
    <?php $post_types = get_post_types('', 'names');?>
    <p>
        <label for="type" class=""><?php _e('Select a Post Type: ', 'textdomain'); ?></label><br>
        <select id="type" name="<?php echo $this->get_field_name('type'); ?>" class="widefat">
            <?php foreach ($post_types as $posts) {
                if ($posts == 'attachment' || $posts == 'acf-field' || $posts == 'acf-field-group' || $posts == 'guest-author' || $posts == 'page') {
                    continue;
                }
                ?>
                <option <?php selected($type, $posts); ?> value="<?php echo $posts; ?>">
                    <?php echo ucfirst($posts);
                    ?>
                </option>
            <?php }; ?>
        </select>
    </p>
    <!-- /Post Types -->

    <div class="layout">
			<div class="radio">
				<label for="A"><span class="icon-trio-layout"></span></label>
        <?php echo '<input type="radio" id="A" name="' . $this->get_field_name('layout') . '" value="A" ' . checked($layout == 'A', true, false) . '>'; ?>
      </div>

      <div class="radio">
          <div class="radio">
                    <label for="B"><span class="icon-double-layout"></span></label>
            <?php echo '<input type="radio" id="B" name="' . $this->get_field_name('layout') . '" value="B" ' . checked($layout == 'B', true, false) . '>'; ?>
          </div>
      </div>

      <div class="radio">
                <label for="C"><span class="icon-stacked-layout"></span></label>
        <?php echo '<input type="radio" id="C" name="' . $this->get_field_name('layout') . '" value="C" ' . checked($layout == 'C', true, false) . '>'; ?>
      </div>

      <div class="radio">
                <label for="D"><span class="icon-four-layout"></span></label>
        <?php echo '<input type="radio" id="D" name="' . $this->get_field_name('layout') . '" value="D" ' . checked($layout == 'D', true, false) . '>'; ?>
      </div>

        <div class="radio">
            <label for="E"><span class="icon-three-layout"></span></label>
            <?php echo '<input type="radio" id="E" name="' . $this->get_field_name('layout') . '" value="E" ' . checked($layout == 'E', true, false) . '>'; ?>
        </div>
    </div>

    <p><?php
        echo '<input type="checkbox" id="feature" name="' . $this->get_field_name('feature') . '" value="true" ' . checked($feature == 'true', true, false) . '>';
        echo '<label for="feature" class="">' .  _e('  Show Featured Image?  ', 'textdomain') . '</label>'; ?>
    </p>

    <?php
  } //End Form


    // widget update
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['link']  = (! empty($new_instance['link'])) ? sanitize_text_field($new_instance['link']) : '';
    $instance['gory'] = (isset($new_instance['gory'])) ? $new_instance['gory'] : 'All';
    $instance['type'] = (isset($new_instance['type'])) ? $new_instance['type'] : 'post';
    $instance['layout'] = (isset($new_instance['layout'])) ? $new_instance['layout'] : 'A';
    $instance['feature'] =  (isset($new_instance['feature'])) ? $new_instance['feature'] : 'false';
    return $instance;
  } //End Update

  // widget display
  public function widget($args, $instance) {
    $title = apply_filters('widget_title', $instance['title']);
    $link = (! empty($instance['link'])) ? $instance['link'] : '';
    $gory = $instance['gory'];
    $type = $instance['type'];
    $layout = $instance['layout'];
    $feature = (isset($instance['feature'])) ? $instance['feature'] : 'false';
// before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if (! empty($title)) {
        echo $args['before_title'];
        if ($link) {
            echo '<a href="'.$link.'">';
        }
        echo $title;
        if ($link) {
            echo '</a>';
        }
        echo $args['after_title'];
    }
    $number = 0;
    $class = '';
    if (! empty($layout)) {
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
    if ($gory == 'All') {
        $gory = '';
    }
// This is where you run the code and display the output
    $stuff = array(
        'post_type'         => $type,
        'category_name'     => $gory,
        'posts_per_page'    => $number,
        'no_found_rows'     => true,
    );
    $the_query = new \WP_Query($stuff);

    if ($the_query->have_posts()) {
			echo '<div class="flex flex-' . $class . '">';
			while ($the_query->have_posts()) {
				$the_query->the_post();
        echo '<article class="news-front ' . $class . '">';
        echo '<a class="more" href="' . get_the_permalink() . '">';
        if ((has_post_thumbnail()) && ($feature === 'true')) {
					echo '<span class="news-image">';
					switch ($class) {
						case 'layout-a':
						case 'layout-d':
							the_post_thumbnail('itre-news-lg');
							break;
						case 'layout-c':
						case 'layout-e':
							the_post_thumbnail('itre-news-sm');
							break;
						default:
							the_post_thumbnail('itre-news-md');
							break;
					}
					echo '</span>';
				}
				if ($class == 'layout-c') {
					echo '<span class="flex-text">';
					echo '<h6>' . get_the_title() . '</h6>';
					echo '<p>' . get_the_excerpt();
					echo '</p>';
					echo '</span>';
				} else {
					echo '<span class="news-text">';
					echo '<h5>' . get_the_title() . '</h5>';
					echo '<p>' . get_the_excerpt();
					echo '</p>';
					echo '</span>';
				}
        echo '</a></article>';
			}
			wp_reset_postdata();
			echo '</div>';
		}
		echo $args['after_widget'];
	} //widget end
} //class end


// register widget
add_action('widgets_init', function () {
    register_widget(__NAMESPACE__ . '\\ItreNews');
});
