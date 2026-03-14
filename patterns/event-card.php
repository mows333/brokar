<?php
/**
 * Block Pattern: Event Card
 *
 * @package Brokar
 */

register_block_pattern(
	'brokar/event-card',
	[
		'title'      => __( 'Evenement Kaart', 'brokar' ),
		'categories' => [ 'brokar' ],
		'content'    => '<!-- wp:group {"style":{"color":{"background":"#112036"},"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"12px","color":"rgba(201,168,76,0.2)","width":"1px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-color:rgba(201,168,76,0.2);border-width:1px;border-radius:12px;background-color:#112036;padding:2rem">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.7rem","letterSpacing":"0.12em","textTransform":"uppercase","fontWeight":"500"},"color":{"text":"#C9A84C"}}} -->
<p class="has-text-color" style="color:#C9A84C;font-size:0.7rem;letter-spacing:0.12em;text-transform:uppercase;font-weight:500">Concert</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"style":{"typography":{"fontFamily":"\'Cormorant Garamond\', serif","fontSize":"1.5rem","fontWeight":"400"},"color":{"text":"#F5F0E8"}}} -->
<h3 class="has-text-color" style="color:#F5F0E8;font-family:\'Cormorant Garamond\',serif;font-size:1.5rem;font-weight:400">Nacht van de Nacht</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"rgba(245,240,232,0.65)"},"typography":{"fontSize":"0.9375rem"}}} -->
<p class="has-text-color" style="color:rgba(245,240,232,0.65);font-size:0.9375rem">28 april 2025 · 20:00 · Concertzaal</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"color":{"text":"rgba(245,240,232,0.6)"},"typography":{"fontSize":"0.9rem"}}} -->
<p class="has-text-color" style="color:rgba(245,240,232,0.6);font-size:0.9rem">Een avond vol duisternis en licht, met live jazz en gesproken woord.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"brokar-gold","textColor":"brokar-navy","style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-brokar-navy-color has-brokar-gold-background-color has-text-color has-background" style="border-radius:999px">Meer info &amp; tickets</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
	]
);
