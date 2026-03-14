<?php
/**
 * Sidebar Template
 *
 * @package Brokar
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
	return;
}
?>

<aside class="sidebar" aria-label="<?php esc_attr_e( 'Blog zijbalk', 'brokar' ); ?>">
	<?php dynamic_sidebar( 'sidebar-blog' ); ?>
</aside>
