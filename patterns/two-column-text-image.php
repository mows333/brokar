<?php
/**
 * Block Pattern: Two Column Text + Image
 *
 * @package Brokar
 */

register_block_pattern(
	'brokar/two-column-text-image',
	[
		'title'      => __( 'Tekst + Afbeelding', 'brokar' ),
		'categories' => [ 'brokar', 'columns' ],
		'content'    => '<!-- wp:group {"style":{"color":{"background":"#0A1628"},"spacing":{"padding":{"top":"5rem","bottom":"5rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="background-color:#0A1628;padding-top:5rem;padding-bottom:5rem">
<!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.7rem","letterSpacing":"0.2em","textTransform":"uppercase","fontWeight":"500"},"color":{"text":"#C9A84C"}}} -->
<p class="has-text-color" style="color:#C9A84C;font-size:0.7rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:500">Ons Verhaal</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"style":{"typography":{"fontFamily":"\'Cormorant Garamond\', serif","fontSize":"clamp(1.8rem,4vw,3rem)","fontWeight":"400","lineHeight":"1.12"},"color":{"text":"#F5F0E8"}}} -->
<h2 class="has-text-color" style="color:#F5F0E8;font-family:\'Cormorant Garamond\',serif;font-size:clamp(1.8rem,4vw,3rem);font-weight:400;line-height:1.12">Brokar — de naam van een <em style="color:#C9A84C">geweven stof</em></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"style":{"color":{"text":"rgba(245,240,232,0.75)"},"typography":{"fontSize":"1.0625rem","lineHeight":"1.8"}}} -->
<p class="has-text-color" style="color:rgba(245,240,232,0.75);font-size:1.0625rem;line-height:1.8">Net zoals brokaatweefsel zijde, goud en zilver vervlecht tot één prachtig geheel, brengt Brokar Cultureel Huis de diverse stemmen van Antwerpen samen. Elk mens is een draad; samen vormen we een rijke stof van verhalen, tradities en dromen.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-brokar-outline","style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button is-style-brokar-outline"><a class="wp-block-button__link" style="border-radius:999px">Meer over ons →</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"sizeSlug":"large","className":"is-style-brokar-frame"} -->
<figure class="wp-block-image size-large is-style-brokar-frame"><img src="" alt="Brokar Cultureel Huis"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->',
	]
);
