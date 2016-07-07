<?php
$include = [
  '/lib/titles.php',       // Change Page Titles
  '/lib/breadcrumbs.php',  // Add NCSU Styled Breadcrumbs
  '/lib/shortcode.php',    // Shortcode
  '/lib/shortcake.php',    // Shortcake UI
  '/lib/search.php',       // Search Function 
];

foreach ($include as $file) {
  if (!$filepath = (dirname( __FILE__ ) .$file)) {
    trigger_error(sprintf('Error locating %s for inclusion', $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

?>
