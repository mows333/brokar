<?php
/**
 * Brokar Theme Functions
 *
 * @package Brokar
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

define( 'BROKAR_VERSION', '1.0.0' );
define( 'BROKAR_DIR', get_template_directory() );
define( 'BROKAR_URI', get_template_directory_uri() );

// ─── Autoload includes ────────────────────────────────────────────────────────
require_once BROKAR_DIR . '/inc/setup.php';
require_once BROKAR_DIR . '/inc/enqueue.php';
require_once BROKAR_DIR . '/inc/menus.php';
require_once BROKAR_DIR . '/inc/language.php';
require_once BROKAR_DIR . '/inc/gutenberg.php';
require_once BROKAR_DIR . '/inc/customizer.php';
require_once BROKAR_DIR . '/inc/template-tags.php';
require_once BROKAR_DIR . '/inc/walker-nav.php';
require_once BROKAR_DIR . '/inc/events.php';
require_once BROKAR_DIR . '/inc/page-builder.php';
require_once BROKAR_DIR . '/inc/ai-translate.php';
