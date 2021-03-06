<?php

/*
 * Define some constants.
 */
define('ROOT_DIR', realpath(dirname(__FILE__)) . '/');
define('CONTENT_DIR', ROOT_DIR . 'content/');
define('POSTS_DIR', ROOT_DIR . CONTENT_DIR . 'posts/');
define('INCLUDES_DIR', ROOT_DIR . 'includes/');
define('THEMES_DIR', ROOT_DIR . 'themes/');

/*
 * Require the shiz.
 */
require('settings.php');
require(INCLUDES_DIR . 'markdown.php');
require(INCLUDES_DIR . 'load.php');

$YaffCMS = new Yaff();

?>