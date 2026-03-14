<?php
/**
 * Custom Search Form
 *
 * @package Brokar
 */
?>

<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
	<label class="screen-reader-text" for="search-field-<?php echo esc_attr( uniqid() ); ?>">
		<?php esc_html_e( 'Zoeken', 'brokar' ); ?>
	</label>
	<input
		type="search"
		id="search-field-<?php echo esc_attr( uniqid() ); ?>"
		class="search-form__input"
		placeholder="<?php esc_attr_e( 'Zoek in Brokar…', 'brokar' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
		autocomplete="off"
	>
	<button type="submit" class="search-form__btn" aria-label="<?php esc_attr_e( 'Zoeken', 'brokar' ); ?>">
		<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:1.1em;height:1.1em;vertical-align:middle;" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
	</button>
</form>
