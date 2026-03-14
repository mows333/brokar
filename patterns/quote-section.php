<?php
/**
 * Block Pattern: Quote Section
 *
 * @package Brokar
 */

register_block_pattern(
	'brokar/quote-section',
	[
		'title'      => __( 'Citaat Sectie', 'brokar' ),
		'categories' => [ 'brokar', 'text' ],
		'content'    => '<!-- wp:group {"style":{"color":{"background":"#C9A84C"},"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="background-color:#C9A84C;padding-top:4rem;padding-bottom:4rem">
<!-- wp:quote {"className":"is-style-brokar-pullquote","style":{"typography":{"fontFamily":"\'Cormorant Garamond\', serif","fontSize":"clamp(1.5rem,3.5vw,2.5rem)","fontStyle":"italic","fontWeight":"300"},"color":{"text":"#0A1628"}}} -->
<blockquote class="wp-block-quote is-style-brokar-pullquote has-text-color" style="color:#0A1628;font-family:\'Cormorant Garamond\',serif;font-size:clamp(1.5rem,3.5vw,2.5rem);font-style:italic;font-weight:300">
<p>"Brokar is geen gebouw. Het is een weefgetouw waarop wij samen onze stad maken."</p>
<cite style="font-size:0.875rem;font-style:normal;letter-spacing:0.06em;color:rgba(10,22,40,0.65)">— Fatima El Moubaraki, Artistiek Directeur</cite>
</blockquote>
<!-- /wp:quote -->
</div>
<!-- /wp:group -->',
	]
);
