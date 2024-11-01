<?php

/*
 * Plugin Name: Prisna YT - Yandex Translator
 * Plugin URI: http://wordpress.org/extend/plugins/wp-yandex-translate/
 * Description: Add the Yandex translate widget to have your website available in 70+ languages isntantly. Installing the translator is fast and simple.
 * Author: Prisna
 * Version: 1.0.8
 * Author URI: http://www.prisna.net/
 * License: GPL2+
 * Text Domain: prisna-ywt
 * Domain Path: /languages/
 */

define('PRISNA_YWT__MINIMUM_WP_VERSION', '3.3');
define('PRISNA_YWT__VERSION', '1.0.8');

define('PRISNA_YWT__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PRISNA_YWT__PLUGIN_URL', plugin_dir_url(__FILE__));

define('PRISNA_YWT__PLUGIN_CLASSES_DIR', PRISNA_YWT__PLUGIN_DIR . '/classes/');
define('PRISNA_YWT__TEMPLATES', PRISNA_YWT__PLUGIN_DIR . '/templates');

define('PRISNA_YWT__JS', PRISNA_YWT__PLUGIN_URL . 'javascript');
define('PRISNA_YWT__CSS', PRISNA_YWT__PLUGIN_URL . 'styles');
define('PRISNA_YWT__IMAGES', PRISNA_YWT__PLUGIN_URL . 'images');

require_once PRISNA_YWT__PLUGIN_CLASSES_DIR . 'common.class.php';
require_once PRISNA_YWT__PLUGIN_CLASSES_DIR . 'base.class.php';
require_once PRISNA_YWT__PLUGIN_CLASSES_DIR . 'config.class.php';

if (is_admin())
	require_once PRISNA_YWT__PLUGIN_CLASSES_DIR . 'admin.class.php';
else
	require_once PRISNA_YWT__PLUGIN_CLASSES_DIR . 'main.class.php';

?>
