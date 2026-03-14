<?php
/**
 * AI-Übersetzung via DeepL API
 *
 * Übersetzt Seiteninhalte automatisch in die gewählte Sprache.
 * Ergebnisse werden als WordPress-Transients gecacht.
 *
 * Quelle der Inhalte: Niederländisch (nl)
 * Zielsprachen:       Französisch (fr), Deutsch (de), Englisch (en)
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────
// Admin-Einstellungsseite
// ─────────────────────────────────────────────────────────────

function brokar_translate_admin_menu(): void {
	add_options_page(
		__( 'Brokar AI-Übersetzung', 'brokar' ),
		__( 'Brokar Vertaling', 'brokar' ),
		'manage_options',
		'brokar-translate',
		'brokar_translate_settings_page'
	);
}
add_action( 'admin_menu', 'brokar_translate_admin_menu' );

function brokar_translate_settings_page(): void {
	// Cache leeren
	if (
		isset( $_POST['brokar_clear_cache'] ) &&
		check_admin_referer( 'brokar_clear_cache' )
	) {
		brokar_translate_clear_all_cache();
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Alle vertalingen gewist!', 'brokar' ) . '</p></div>';
	}

	// API-Key speichern
	if (
		isset( $_POST['brokar_deepl_key'] ) &&
		check_admin_referer( 'brokar_translate_save' )
	) {
		update_option( 'brokar_deepl_key', sanitize_text_field( wp_unslash( $_POST['brokar_deepl_key'] ) ) );
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Opgeslagen!', 'brokar' ) . '</p></div>';
	}

	$key = get_option( 'brokar_deepl_key', '' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Brokar AI-Übersetzung (DeepL)', 'brokar' ); ?></h1>
		<p><?php esc_html_e( 'Alle pagina-inhoud wordt automatisch vertaald via de DeepL API. Vertalingen worden gecached zodat de API zo min mogelijk wordt aangeroepen.', 'brokar' ); ?></p>

		<form method="post">
			<?php wp_nonce_field( 'brokar_translate_save' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="brokar_deepl_key"><?php esc_html_e( 'DeepL API Key', 'brokar' ); ?></label>
					</th>
					<td>
						<input
							type="text"
							id="brokar_deepl_key"
							name="brokar_deepl_key"
							value="<?php echo esc_attr( $key ); ?>"
							class="regular-text"
							autocomplete="off"
						/>
						<p class="description"><?php esc_html_e( 'Free API-sleutel eindigt op :fx — te vinden op deepl.com/de/your-account', 'brokar' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Opslaan', 'brokar' ) ); ?>
		</form>

		<hr>

		<h2><?php esc_html_e( 'Cache wissen', 'brokar' ); ?></h2>
		<p><?php esc_html_e( 'Wis de cache als je inhoud hebt gewijzigd en nieuwe vertalingen wilt genereren.', 'brokar' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'brokar_clear_cache' ); ?>
			<input type="hidden" name="brokar_clear_cache" value="1">
			<?php submit_button( __( 'Alle vertalingen wissen', 'brokar' ), 'secondary' ); ?>
		</form>
	</div>
	<?php
}

// ─────────────────────────────────────────────────────────────
// Cache-Hilfsfunktionen
// ─────────────────────────────────────────────────────────────

function brokar_translate_cache_key( string $text, string $lang ): string {
	return 'brokar_tr_' . md5( $text . $lang );
}

function brokar_translate_clear_all_cache(): void {
	global $wpdb;
	$wpdb->query(
		"DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_brokar_tr_%' OR option_name LIKE '_transient_timeout_brokar_tr_%'"
	);
}

// Cache leeren wenn ein Post gespeichert wird
function brokar_translate_clear_post_cache( int $post_id ): void {
	// Nur echte Posts (kein Autosave/Revision)
	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	// Wir können keinen gezielten Cache per Post-ID leeren (weil wir nach Text-Hash cachen),
	// daher leeren wir den gesamten Übersetzungs-Cache beim Speichern.
	brokar_translate_clear_all_cache();
}
add_action( 'save_post', 'brokar_translate_clear_post_cache' );

// ─────────────────────────────────────────────────────────────
// DeepL API-Aufruf
// ─────────────────────────────────────────────────────────────

/**
 * Sprachcode des Themes → DeepL-Ziel-Sprachcode
 */
function brokar_deepl_target_lang( string $lang ): string {
	$map = [
		'fr' => 'FR',
		'de' => 'DE',
		'en' => 'EN-GB',
	];
	return $map[ $lang ] ?? strtoupper( $lang );
}

/**
 * Text via DeepL übersetzen.
 * Gibt den übersetzten Text zurück, oder den Original-Text bei Fehler.
 */
function brokar_deepl_translate( string $text, string $target_lang ): string {
	$api_key = get_option( 'brokar_deepl_key', '' );

	if ( empty( $api_key ) || empty( trim( $text ) ) ) {
		return $text;
	}

	// Free-Tier-Keys enden auf :fx → anderer Endpunkt
	$is_free = str_ends_with( $api_key, ':fx' );
	$api_url  = $is_free
		? 'https://api-free.deepl.com/v2/translate'
		: 'https://api.deepl.com/v2/translate';

	$response = wp_remote_post(
		$api_url,
		[
			'timeout' => 10,
			'headers' => [
				'Authorization' => 'DeepL-Auth-Key ' . $api_key,
				'Content-Type'  => 'application/json',
			],
			'body' => wp_json_encode( [
				'text'        => [ $text ],
				'source_lang' => 'NL',
				'target_lang' => brokar_deepl_target_lang( $target_lang ),
				'tag_handling' => 'html',
			] ),
		]
	);

	if ( is_wp_error( $response ) ) {
		return $text;
	}

	$status = wp_remote_retrieve_response_code( $response );
	if ( 200 !== (int) $status ) {
		return $text;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	return $data['translations'][0]['text'] ?? $text;
}

// ─────────────────────────────────────────────────────────────
// Haupt-Übersetzungsfunktion (mit Cache)
// ─────────────────────────────────────────────────────────────

function brokar_translate_text( string $text, string $lang ): string {
	if ( empty( trim( $text ) ) ) {
		return $text;
	}

	$cache_key = brokar_translate_cache_key( $text, $lang );
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		return $cached;
	}

	$translated = brokar_deepl_translate( $text, $lang );

	// 30 Tage cachen
	set_transient( $cache_key, $translated, 30 * DAY_IN_SECONDS );

	return $translated;
}

// ─────────────────────────────────────────────────────────────
// WordPress-Filter einhängen
// ─────────────────────────────────────────────────────────────

function brokar_should_translate(): bool {
	// Nicht im Admin-Bereich
	if ( is_admin() ) {
		return false;
	}

	// Kein API-Key eingetragen
	if ( empty( get_option( 'brokar_deepl_key', '' ) ) ) {
		return false;
	}

	// Quellsprache NL braucht keine Übersetzung
	$lang = brokar_get_current_lang();
	if ( 'nl' === $lang ) {
		return false;
	}

	// Polylang / WPML übernehmen selbst die Übersetzung
	if ( function_exists( 'pll_current_language' ) || defined( 'ICL_LANGUAGE_CODE' ) ) {
		return false;
	}

	return true;
}

/**
 * Inhalt (Gutenberg-Blöcke, klassischer Editor) übersetzen.
 * Priorität 20 → läuft nach wpautop etc.
 */
function brokar_filter_content( string $content ): string {
	if ( ! brokar_should_translate() ) {
		return $content;
	}
	return brokar_translate_text( $content, brokar_get_current_lang() );
}
add_filter( 'the_content', 'brokar_filter_content', 20 );

/**
 * Seitentitel übersetzen.
 */
function brokar_filter_title( string $title, int $id = 0 ): string {
	if ( ! brokar_should_translate() || empty( $title ) ) {
		return $title;
	}
	return brokar_translate_text( $title, brokar_get_current_lang() );
}
add_filter( 'the_title', 'brokar_filter_title', 20, 2 );

/**
 * Auszug (Excerpt) übersetzen.
 */
function brokar_filter_excerpt( string $excerpt ): string {
	if ( ! brokar_should_translate() ) {
		return $excerpt;
	}
	return brokar_translate_text( $excerpt, brokar_get_current_lang() );
}
add_filter( 'the_excerpt', 'brokar_filter_excerpt', 20 );

/**
 * ACF-Felder übersetzen (falls Advanced Custom Fields aktiv).
 */
function brokar_filter_acf_value( mixed $value, int $post_id, array $field ): mixed {
	if ( ! brokar_should_translate() ) {
		return $value;
	}
	if ( ! in_array( $field['type'] ?? '', [ 'text', 'textarea', 'wysiwyg' ], true ) ) {
		return $value;
	}
	if ( ! is_string( $value ) || empty( trim( $value ) ) ) {
		return $value;
	}
	return brokar_translate_text( $value, brokar_get_current_lang() );
}
add_filter( 'acf/format_value', 'brokar_filter_acf_value', 20, 3 );
