<?php
/**
 * Brokar Page Builder
 *
 * Eigener Editor für Startseite und Über-uns-Seite.
 * Ersetzt den Gutenberg-Block-Editor durch komfortable Meta-Boxen
 * mit Bildauswahl (WordPress-Mediathek), Textfeldern und URL-Feldern.
 *
 * Bearbeitbare Abschnitte der Startseite:
 *   Hero · Intro · Expositie · Citaat
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────
// Gutenberg deaktivieren (Startseite + About-Template)
// ─────────────────────────────────────────────────────────────

add_filter( 'use_block_editor_for_post', 'brokar_pb_disable_gutenberg', 10, 2 );

function brokar_pb_disable_gutenberg( bool $use, WP_Post $post ): bool {
	if ( 'page' !== $post->post_type ) {
		return $use;
	}
	$front_id = (int) get_option( 'page_on_front' );
	$template = get_post_meta( $post->ID, '_wp_page_template', true );

	if (
		$post->ID === $front_id ||
		'page-about.php' === $template
	) {
		return false;
	}
	return $use;
}

// ─────────────────────────────────────────────────────────────
// Admin-Skripte: Mediathek einbinden
// ─────────────────────────────────────────────────────────────

add_action( 'admin_enqueue_scripts', 'brokar_pb_enqueue' );

function brokar_pb_enqueue( string $hook ): void {
	if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
		return;
	}
	global $post;
	if ( ! $post || 'page' !== $post->post_type ) {
		return;
	}
	$front_id = (int) get_option( 'page_on_front' );
	$template = get_post_meta( $post->ID, '_wp_page_template', true );

	if ( $post->ID === $front_id || 'page-about.php' === $template ) {
		wp_enqueue_media();
	}
}

// ─────────────────────────────────────────────────────────────
// Meta-Boxen registrieren
// ─────────────────────────────────────────────────────────────

add_action( 'add_meta_boxes', 'brokar_pb_register_meta_boxes' );

function brokar_pb_register_meta_boxes(): void {
	$front_id = (int) get_option( 'page_on_front' );
	$screen   = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	// Alle Seiten: Afbeelding-Box
	add_meta_box(
		'brokar_pb_page_image',
		'🖼 Paginaafbeelding (Hero)',
		'brokar_pb_render_page_image',
		'page',
		'side',
		'high'
	);

	// Nur Startseite: vollständiger Seiteneditor
	global $post;
	if ( $post && $post->ID === $front_id ) {
		add_meta_box(
			'brokar_pb_hero',
			'✏️ Hero-Abschnitt',
			'brokar_pb_render_hero',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'brokar_pb_intro',
			'✏️ Intro / Over ons',
			'brokar_pb_render_intro',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'brokar_pb_expo',
			'✏️ Uitgelichte expositie',
			'brokar_pb_render_expo',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'brokar_pb_quote',
			'✏️ Citaat',
			'brokar_pb_render_quote',
			'page',
			'normal',
			'default'
		);
	}

	// About-template
	if ( $post ) {
		$tmpl = get_post_meta( $post->ID, '_wp_page_template', true );
		if ( 'page-about.php' === $tmpl ) {
			add_meta_box(
				'brokar_pb_about_images',
				'🖼 Over ons — afbeeldingen',
				'brokar_pb_render_about_images',
				'page',
				'normal',
				'high'
			);
		}
	}
}

// ─────────────────────────────────────────────────────────────
// Render-Hilfsfunktionen
// ─────────────────────────────────────────────────────────────

function brokar_pb_nonce( int $post_id ): void {
	wp_nonce_field( 'brokar_pb_save_' . $post_id, 'brokar_pb_nonce' );
}

function brokar_pb_text( int $id, string $key, string $label, string $fallback = '' ): void {
	$val = get_post_meta( $id, $key, true );
	echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $label ) . '</label>';
	echo '<input type="text" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ?: $fallback ) . '" style="width:100%"></p>';
}

function brokar_pb_textarea( int $id, string $key, string $label, string $fallback = '' ): void {
	$val = get_post_meta( $id, $key, true );
	echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $label ) . '</label>';
	echo '<textarea name="' . esc_attr( $key ) . '" rows="4" style="width:100%">' . esc_textarea( $val ?: $fallback ) . '</textarea></p>';
}

function brokar_pb_url( int $id, string $key, string $label, string $fallback = '' ): void {
	$val = get_post_meta( $id, $key, true );
	echo '<p><label style="font-weight:600;display:block;margin-bottom:4px">' . esc_html( $label ) . '</label>';
	echo '<input type="url" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ?: $fallback ) . '" placeholder="https://…" style="width:100%"></p>';
}

function brokar_pb_image( int $id, string $key, string $label ): void {
	$img_id  = (int) get_post_meta( $id, $key, true );
	$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : '';
	$display = $img_url ? '' : ' style="display:none"';
	?>
	<p class="brokar-pb-img-wrap" data-key="<?php echo esc_attr( $key ); ?>">
		<label style="font-weight:600;display:block;margin-bottom:6px"><?php echo esc_html( $label ); ?></label>
		<input type="hidden" name="<?php echo esc_attr( $key ); ?>" data-img-id value="<?php echo esc_attr( $img_id ?: '' ); ?>">
		<span style="display:block;margin-bottom:6px">
			<img src="<?php echo esc_url( $img_url ); ?>" alt=""
				 style="max-width:200px;max-height:120px;border-radius:4px;display:block;margin-bottom:6px<?php echo $img_url ? '' : ';display:none'; ?>">
		</span>
		<button type="button" class="button brokar-pb-choose-img">📁 Afbeelding kiezen</button>
		<button type="button" class="button brokar-pb-remove-img"<?php echo $img_url ? '' : ' style="display:none"'; ?>>✕ Verwijderen</button>
	</p>
	<?php
}

function brokar_pb_section_hr( string $title ): void {
	echo '<hr style="margin:1.5rem 0 0.5rem"><h3 style="margin:0 0 1rem;color:#1d2327">' . esc_html( $title ) . '</h3>';
}

// ─────────────────────────────────────────────────────────────
// Render: Paginaafbeelding (alle Seiten)
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_page_image( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	echo '<p style="color:#666;font-size:0.85em;margin-bottom:8px">' . esc_html__( 'Wordt gebruikt als hero-achtergrond op deze pagina.', 'brokar' ) . '</p>';
	brokar_pb_image( $post->ID, '_brokar_page_hero_image', 'Hero-Hintergrundbild' );
	brokar_pb_js();
}

// ─────────────────────────────────────────────────────────────
// Render: Hero-Abschnitt (Startseite)
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_hero( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	brokar_pb_image( $post->ID, '_brokar_hero_bg', 'Hero-achtergrondafbeelding' );
	brokar_pb_section_hr( 'Tekst' );
	brokar_pb_text( $post->ID, '_brokar_hero_tagline', 'Tagline', 'Kunst. Cultuur. Gemeenschap.' );
	brokar_pb_textarea( $post->ID, '_brokar_hero_desc', 'Beschrijving',
		'Een ontmoetingsplek voor alle generaties, waar de draden van de gemeenschap worden samengeweven tot een kleurrijk tapijt van beleving.' );
	brokar_pb_section_hr( 'Knop 1' );
	brokar_pb_text( $post->ID, '_brokar_hero_cta1_text', 'Knoptekst', 'Ontdek het programma' );
	brokar_pb_url( $post->ID, '_brokar_hero_cta1_url', 'Knop-URL', home_url( '/programma/' ) );
	brokar_pb_section_hr( 'Knop 2' );
	brokar_pb_text( $post->ID, '_brokar_hero_cta2_text', 'Knoptekst', 'Over Brokar' );
	brokar_pb_url( $post->ID, '_brokar_hero_cta2_url', 'Knop-URL', home_url( '/over-brokar/' ) );
	brokar_pb_js();
}

// ─────────────────────────────────────────────────────────────
// Render: Intro-Abschnitt
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_intro( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	brokar_pb_image( $post->ID, '_brokar_intro_image', 'Afbeelding (rechts)' );
	brokar_pb_section_hr( 'Tekst' );
	brokar_pb_text( $post->ID, '_brokar_intro_heading', 'Koptekst', 'Brokar — de naam van een' );
	brokar_pb_text( $post->ID, '_brokar_intro_heading_em', 'Goud benadrukt woord', 'geweven stof' );
	brokar_pb_textarea( $post->ID, '_brokar_intro_p1', 'Alinea 1',
		'Net zoals brokaatweefsel zijde, goud en zilver vervlecht tot één prachtig geheel, brengt Brokar Cultureel Huis de diverse stemmen van Antwerpen samen. Elk mens is een draad; samen vormen we een rijke stof van verhalen, tradities en dromen.' );
	brokar_pb_textarea( $post->ID, '_brokar_intro_p2', 'Alinea 2',
		'Gelegen in het hart van Antwerpen bieden wij een warme thuishaven voor iedereen: jong en oud, kunstenaar en bezoeker, local en vreemdeling.' );
	brokar_pb_section_hr( 'Statistieken' );
	brokar_pb_text( $post->ID, '_brokar_stat1_num', 'Stat 1 — nummer', '2019' );
	brokar_pb_text( $post->ID, '_brokar_stat1_label', 'Stat 1 — label', 'Opgericht' );
	brokar_pb_text( $post->ID, '_brokar_stat2_num', 'Stat 2 — nummer', '120+' );
	brokar_pb_text( $post->ID, '_brokar_stat2_label', 'Stat 2 — label', 'Evenementen / jaar' );
	brokar_pb_text( $post->ID, '_brokar_stat3_num', 'Stat 3 — nummer', '8.000+' );
	brokar_pb_text( $post->ID, '_brokar_stat3_label', 'Stat 3 — label', 'Bezoekers / jaar' );
	brokar_pb_js();
}

// ─────────────────────────────────────────────────────────────
// Render: Expositie-Abschnitt
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_expo( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	brokar_pb_image( $post->ID, '_brokar_expo_image', 'Achtergrondafbeelding expositie' );
	brokar_pb_section_hr( 'Inhoud' );
	brokar_pb_text( $post->ID, '_brokar_expo_title', 'Titel', 'Weven & Worden' );
	brokar_pb_text( $post->ID, '_brokar_expo_artist', 'Kunstenaar / Collectief', 'Leila Benali & Collective Draad' );
	brokar_pb_text( $post->ID, '_brokar_expo_dates', 'Datumrange', '15 april — 15 juni 2025' );
	brokar_pb_textarea( $post->ID, '_brokar_expo_desc', 'Beschrijving',
		'Een meeslepende installatie over migratie, identiteit en de kracht van gemeenschap, geweven uit duizenden verhalen van Antwerpenaren.' );
	brokar_pb_js();
}

// ─────────────────────────────────────────────────────────────
// Render: Citaat
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_quote( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	brokar_pb_textarea( $post->ID, '_brokar_quote_text', 'Citaattekst',
		'"Brokar is geen gebouw. Het is een weefgetouw waarop wij samen onze stad maken."' );
	brokar_pb_text( $post->ID, '_brokar_quote_author', 'Auteur',
		'— Fatima El Moubaraki, Artistiek Directeur' );
}

// ─────────────────────────────────────────────────────────────
// Render: About-afbeeldingen
// ─────────────────────────────────────────────────────────────

function brokar_pb_render_about_images( WP_Post $post ): void {
	brokar_pb_nonce( $post->ID );
	brokar_pb_image( $post->ID, '_brokar_about_img1', 'Afbeelding 1 (team / sfeer)' );
	brokar_pb_image( $post->ID, '_brokar_about_img2', 'Afbeelding 2 (gebouw / detail)' );
	brokar_pb_image( $post->ID, '_brokar_about_img3', 'Afbeelding 3 (evenement / publiek)' );
	brokar_pb_js();
}

// ─────────────────────────────────────────────────────────────
// JavaScript für Mediathek-Picker (einmal pro Seite)
// ─────────────────────────────────────────────────────────────

$brokar_pb_js_printed = false;

function brokar_pb_js(): void {
	global $brokar_pb_js_printed;
	if ( $brokar_pb_js_printed ) {
		return;
	}
	$brokar_pb_js_printed = true;
	?>
	<script>
	jQuery(function($){
		$(document).on('click','.brokar-pb-choose-img',function(e){
			e.preventDefault();
			var $wrap=$(this).closest('.brokar-pb-img-wrap');
			var frame=wp.media({title:'Afbeelding kiezen',button:{text:'Gebruik afbeelding'},multiple:false});
			frame.on('select',function(){
				var att=frame.state().get('selection').first().toJSON();
				$wrap.find('[data-img-id]').val(att.id);
				var src=att.sizes&&att.sizes.medium?att.sizes.medium.url:att.url;
				var $img=$wrap.find('img');
				if($img.length){$img.attr('src',src).show();}
				else{$wrap.prepend('<img src="'+src+'" alt="" style="max-width:200px;max-height:120px;border-radius:4px;display:block;margin-bottom:6px">');}
				$wrap.find('.brokar-pb-remove-img').show();
			});
			frame.open();
		});
		$(document).on('click','.brokar-pb-remove-img',function(e){
			e.preventDefault();
			var $wrap=$(this).closest('.brokar-pb-img-wrap');
			$wrap.find('[data-img-id]').val('');
			$wrap.find('img').hide();
			$(this).hide();
		});
	});
	</script>
	<?php
}

// ─────────────────────────────────────────────────────────────
// Speichern der Meta-Werte
// ─────────────────────────────────────────────────────────────

add_action( 'save_post_page', 'brokar_pb_save', 10, 2 );

function brokar_pb_save( int $post_id, WP_Post $post ): void {
	// Sicherheitschecks
	if (
		! isset( $_POST['brokar_pb_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['brokar_pb_nonce'] ) ), 'brokar_pb_save_' . $post_id ) ||
		defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ||
		! current_user_can( 'edit_page', $post_id )
	) {
		return;
	}

	// Alle bekannten Felder speichern
	$text_fields = [
		'_brokar_hero_tagline', '_brokar_hero_desc',
		'_brokar_hero_cta1_text', '_brokar_hero_cta2_text',
		'_brokar_intro_heading', '_brokar_intro_heading_em',
		'_brokar_intro_p1', '_brokar_intro_p2',
		'_brokar_stat1_num', '_brokar_stat1_label',
		'_brokar_stat2_num', '_brokar_stat2_label',
		'_brokar_stat3_num', '_brokar_stat3_label',
		'_brokar_expo_title', '_brokar_expo_artist',
		'_brokar_expo_dates', '_brokar_expo_desc',
		'_brokar_quote_text', '_brokar_quote_author',
	];

	$url_fields = [
		'_brokar_hero_cta1_url', '_brokar_hero_cta2_url',
	];

	$image_fields = [
		'_brokar_page_hero_image',
		'_brokar_hero_bg', '_brokar_intro_image',
		'_brokar_expo_image',
		'_brokar_about_img1', '_brokar_about_img2', '_brokar_about_img3',
	];

	foreach ( $text_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_textarea_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
	foreach ( $url_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, esc_url_raw( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
	foreach ( $image_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, absint( $_POST[ $key ] ) );
		}
	}
}

// ─────────────────────────────────────────────────────────────
// Hilfsfunktionen für Templates
// ─────────────────────────────────────────────────────────────

/**
 * Meta-Wert lesen mit Fallback.
 * Prefix '_brokar_' wird automatisch ergänzt wenn kein _ am Anfang.
 */
function brokar_pb_get( int $post_id, string $key, string $fallback = '' ): string {
	$meta_key = str_starts_with( $key, '_' ) ? $key : '_brokar_' . $key;
	$val      = get_post_meta( $post_id, $meta_key, true );
	return ( '' !== $val && false !== $val ) ? (string) $val : $fallback;
}

/**
 * Bild-URL aus Mediathek lesen.
 * Gibt leeren String zurück wenn kein Bild gesetzt.
 */
function brokar_pb_get_img_url( int $post_id, string $key, string $size = 'full' ): string {
	$meta_key = str_starts_with( $key, '_' ) ? $key : '_brokar_' . $key;
	$img_id   = (int) get_post_meta( $post_id, $meta_key, true );
	if ( ! $img_id ) {
		return '';
	}
	return (string) wp_get_attachment_image_url( $img_id, $size );
}
