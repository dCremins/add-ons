<?php
$include = [
  //'/lib/titles.php',       // Change Page Titles
  '/lib/breadcrumbs.php',  // Add NCSU Styled Breadcrumbs
  '/lib/shortcode.php',    // Shortcode
  '/lib/shortcake.php',    // Shortcake UI
  //'/lib/search.php',       // Search Function
  '/widgets/callout.php',  // Callout Widget
  '/widgets/news.php',     // Latest news Widget
  //'/widgets/search.php',   // Advanced Research Search Widget
];

if (class_exists('\SimpleCalendar\Widgets\Calendar')) {
  $include[] = '/widgets/calendar/functions.php';
  $include[] = '/widgets/calendar/calendar.php';
}


foreach ($include as $file) {
  if (!$filepath = (dirname( __FILE__ ) .$file)) {
    trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);



?>
