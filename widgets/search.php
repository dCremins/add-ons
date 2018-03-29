<?php

namespace AddOn\Search;

class ItreSearch extends \WP_Widget {
	public function __construct() {
		$widget_details = array(
			'classname' => 'ItreSearch',
	  	'description' => 'Custom Research Search Widget'
	  );
		parent::__construct('ItreSearch', 'Search Research', $widget_details);
	}

  public function form($instance) { }

  public function update($new_instance, $old_instance) { }

  public function widget($args, $instance) {
		global $post, $post_ID, $wpdb;
    $category = get_categories();
    if (class_exists('acf')) {
			$sql = $wpdb->prepare("select post_id from "
				. $wpdb->prefix
				. "postmeta where meta_key = %s limit 0,1 ", 'files');
      $post = $wpdb->get_results($sql);
			if ($post) {
				if (get_field('files', $post[0]->post_id)) {
					while (has_sub_field('files', $post[0]->post_id)) {
						$fileType = get_sub_field_object('type', $post[0]->post_id);
					}
				}
			}
		} ?>

		<form method="post" class="search-form form-horizontal" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url('/')); ?>">
			<h3><?php _e('Advanced Search', 'textdomain'); ?></h3>
			<input type="hidden" name="search" value="advanced">
			<div class="input-group">
				<label class="hidden" for="s"><?php _e('Keyword:'); ?></label>
        <input type="search" placeholder="Keyword" class="form-control" name="s" id="s">
      </div>

			<?php if (class_exists( 'Bylines\Objects\Byline' )) {
				$terms = get_terms('byline');?>
				<div class="input-group">
					<label for="authors" class=""><?php _e('Select an Author: ', 'textdomain'); ?></label><br>
					<select name="authors" id="authors" class="form-control">
						<optgroup label="Authors">
							<option selected value="">All Authors</option>
							<?php foreach ($terms as $byline) {
								if ((get_user_by('ID', $byline->ID)) || get_user_by('slug', $byline->slug)) {
										 //
								} else { ?>
									<option value="<?php echo $byline->slug; ?>"><?php echo $byline->name; ?></option>
								<?php  }
							}; ?>
						</optgroup>
					</select>
				</div>
			<?php }?>

			<div class="input-group">
				<label for="cat" class=""><?php _e('Select a Category: ', 'textdomain'); ?></label><br>
				<select name="cat" id="cat" class="form-control">
					<optgroup label="Categories">
						<option selected value="">All Categories</option>
						<?php foreach ($category as $cats) { ?>
							<option value="<?php echo $cats->slug?>"><?php echo $cats->name; ?></option>
						<?php }; ?>
					</optgroup>
				</select>
			</div>

			<?php if (class_exists('acf') && get_field('files')) { ?>
				<div class="input-group">
					<label for="fileType" class=""><?php _e('Select a Document Type: ', 'textdomain'); ?></label><br>
					<select name="fileType" id="fileType" class="form-control">
						<option value="">All Types</option>
            <?php foreach ($fileType['choices'] as $k => $v) {?>
							<option value="<?php echo $k?>"><?php echo $v; ?></option>
						<?php }; ?>
					</select>
				</div>
			<?php }; ?>

			<div class="input-group date-search">
				<div class="dateSearch">
					<label for="startDate" class="sr-only">Range Start Date</label><?php _e('Search Between ', 'textdomain'); ?><br>
					<input type="date" value="" name="startDate" id="startDate" placeholder="Start">
				</div>
				<div class="divider"> to </div>
				<div class="dateSearch">
					<label for="endDate" class="sr-only">Range End Date</label><br>
					<input type="date" value="" name="endDate" id="endDate">
				</div>
				<div style="clear:both;"></div>
			</div>

			<div class="input-group">
				<span class="input-group-btn">
					<button class="btn" type="submit" value="Search" alt="Search">Search</button>
				</span>
			</div>
	</form> <?php
	} //widget end
} //class end

// register widget
add_action('widgets_init', function () {
    register_widget(__NAMESPACE__ . '\\ItreSearch');
});
