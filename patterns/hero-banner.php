<?php
/**
 * Block Pattern: Hero Banner
 *
 * @package Brokar
 */

register_block_pattern(
	'brokar/hero-banner',
	[
		'title'      => __( 'Hero Banner', 'brokar' ),
		'categories' => [ 'brokar' ],
		'content'    => '<!-- wp:group {"style":{"color":{"background":"#0A1628"},"spacing":{"padding":{"top":"120px","bottom":"80px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="background-color:#0A1628;padding-top:120px;padding-bottom:80px">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.75rem","letterSpacing":"0.25em","textTransform":"uppercase"},"color":{"text":"#C9A84C"}}} -->
<p class="has-text-color" style="color:#C9A84C;font-size:0.75rem;letter-spacing:0.25em;text-transform:uppercase">Antwerpen</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"style":{"typography":{"fontFamily":"\'Cormorant Garamond\', serif","fontSize":"clamp(3rem,8vw,6rem)","fontWeight":"300","lineHeight":"1.05","letterSpacing":"-0.03em"},"color":{"text":"#F5F0E8"}}} -->
<h1 class="has-text-color" style="color:#F5F0E8;font-family:\'Cormorant Garamond\',serif;font-size:clamp(3rem,8vw,6rem);font-weight:300;letter-spacing:-0.03em;line-height:1.05">Brokar<br>Cultureel Huis</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"typography":{"fontFamily":"\'Cormorant Garamond\', serif","fontSize":"1.375rem","fontStyle":"italic","letterSpacing":"0.04em"},"color":{"text":"#C9A84C"}}} -->
<p class="has-text-color" style="color:#C9A84C;font-family:\'Cormorant Garamond\',serif;font-size:1.375rem;font-style:italic;letter-spacing:0.04em">Kunst. Cultuur. Gemeenschap.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"brokar-gold","textColor":"brokar-navy","style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-brokar-navy-color has-brokar-gold-background-color has-text-color has-background" style="border-radius:999px">Ontdek het programma</a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-brokar-outline","style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button is-style-brokar-outline"><a class="wp-block-button__link" style="border-radius:999px">Over Brokar</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
	]
);
