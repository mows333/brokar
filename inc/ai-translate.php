<?php
/**
 * AI-Übersetzung via DeepL API
 *
 * Übersetzt die gesamte Seitenausgabe (Body-HTML) automatisch in die
 * gewählte Sprache mittels PHP Output-Buffering.
 * Ergebnisse werden als WordPress-Transients gecacht.
 *
 * Quelle: Niederländisch (nl) | Ziel: FR / DE / EN
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────
// API-Key-Initialisierung (nur beim ersten Laden)
// ─────────────────────────────────────────────────────────────

add_option( 'brokar_deepl_key', '8acf7c04-9baa-4d57-8e3b-41ef179330c2:fx' );

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
	if ( isset( $_POST['brokar_clear_cache'] ) && check_admin_referer( 'brokar_clear_cache' ) ) {
		brokar_translate_clear_all_cache();
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Alle vertalingen gewist!', 'brokar' ) . '</p></div>';
	}
	if ( isset( $_POST['brokar_deepl_key'] ) && check_admin_referer( 'brokar_translate_save' ) ) {
		update_option( 'brokar_deepl_key', sanitize_text_field( wp_unslash( $_POST['brokar_deepl_key'] ) ) );
		echo '<div class="notice notice-success"><p>' . esc_html__( 'Opgeslagen!', 'brokar' ) . '</p></div>';
	}
	$key = get_option( 'brokar_deepl_key', '' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Brokar AI-Übersetzung (DeepL)', 'brokar' ); ?></h1>
		<p><?php esc_html_e( 'De volledige pagina-inhoud (alle teksten, titels, knoppen) wordt automatisch vertaald via DeepL. Vertalingen worden gecached per URL per taal.', 'brokar' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'brokar_translate_save' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="brokar_deepl_key"><?php esc_html_e( 'DeepL API Key', 'brokar' ); ?></label></th>
					<td>
						<input type="text" id="brokar_deepl_key" name="brokar_deepl_key"
							value="<?php echo esc_attr( $key ); ?>" class="regular-text" autocomplete="off" />
						<p class="description"><?php esc_html_e( 'Free-sleutel eindigt op :fx — deepl.com/de/your-account', 'brokar' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Opslaan', 'brokar' ) ); ?>
		</form>
		<hr>
		<h2><?php esc_html_e( 'Cache wissen', 'brokar' ); ?></h2>
		<p><?php esc_html_e( 'Wis de vertaalcache als je inhoud hebt gewijzigd.', 'brokar' ); ?></p>
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

function brokar_translate_clear_all_cache(): void {
	global $wpdb;
	$wpdb->query(
		"DELETE FROM {$wpdb->options}
		 WHERE option_name LIKE '_transient_brokar_tr_%'
		    OR option_name LIKE '_transient_timeout_brokar_tr_%'"
	);
}

// Cache leeren wenn ein Post/Seite gespeichert wird
function brokar_translate_clear_post_cache( int $post_id ): void {
	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	brokar_translate_clear_all_cache();
}
add_action( 'save_post', 'brokar_translate_clear_post_cache' );

// ─────────────────────────────────────────────────────────────
// DeepL API-Aufruf
// ─────────────────────────────────────────────────────────────

function brokar_deepl_target_lang( string $lang ): string {
	return [ 'fr' => 'FR', 'de' => 'DE', 'en' => 'EN-GB' ][ $lang ] ?? strtoupper( $lang );
}

/**
 * Sendet Text (plain oder HTML) an DeepL und gibt die Übersetzung zurück.
 * Bei Fehler wird der Originaltext zurückgegeben.
 */
function brokar_deepl_translate( string $text, string $target_lang ): string {
	$api_key = get_option( 'brokar_deepl_key', '' );

	if ( empty( $api_key ) || empty( trim( $text ) ) ) {
		return $text;
	}

	$is_free = str_ends_with( $api_key, ':fx' );
	$api_url = $is_free
		? 'https://api-free.deepl.com/v2/translate'
		: 'https://api.deepl.com/v2/translate';

	$response = wp_remote_post( $api_url, [
		'timeout' => 15,
		'headers' => [
			'Authorization' => 'DeepL-Auth-Key ' . $api_key,
			'Content-Type'  => 'application/json',
		],
		'body' => wp_json_encode( [
			'text'         => [ $text ],
			'source_lang'  => 'NL',
			'target_lang'  => brokar_deepl_target_lang( $target_lang ),
			'tag_handling' => 'html',
			'ignore_tags'  => 'script,style,code,pre',
		] ),
	] );

	if ( is_wp_error( $response ) ) {
		return $text;
	}
	if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return $text;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	return $data['translations'][0]['text'] ?? $text;
}

// ─────────────────────────────────────────────────────────────
// Vollseiten-Ausgabe-Puffer (Output Buffer)
// ─────────────────────────────────────────────────────────────

function brokar_should_translate(): bool {
	if ( is_admin() )         return false;  // WP-Admin überspringen
	if ( is_user_logged_in() ) return false;  // Eingeloggte Nutzer überspringen

	if ( empty( get_option( 'brokar_deepl_key', '' ) ) ) return false;

	$lang = brokar_get_current_lang();
	if ( 'nl' === $lang ) return false;  // Quellsprache braucht keine Übersetzung

	// Polylang / WPML übernehmen selbst die Übersetzung
	if ( function_exists( 'pll_current_language' ) || defined( 'ICL_LANGUAGE_CODE' ) ) {
		return false;
	}

	return true;
}

/**
 * Output-Buffering starten — fängt die gesamte HTML-Ausgabe ab.
 * Läuft in template_redirect (vor der Template-Ausgabe).
 */
function brokar_translate_ob_start(): void {
	if ( ! brokar_should_translate() ) {
		return;
	}
	ob_start( 'brokar_translate_ob_callback' );
}
add_action( 'template_redirect', 'brokar_translate_ob_start', 1 );

/**
 * Output-Buffer-Callback: Übersetzt den <body>-Inhalt der Seite.
 * Wird automatisch aufgerufen wenn der Buffer geleert wird.
 *
 * Wir übersetzen nur den <body>-Inhalt (nicht <head>), um:
 * - DeepL-Zeichenlimits zu respektieren
 * - Skripte/Styles im <head> unangetastet zu lassen
 */
function brokar_translate_ob_callback( string $html ): string {
	$lang = brokar_get_current_lang();
	$uri  = isset( $_SERVER['REQUEST_URI'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) )
		: '/';

	$cache_key = 'brokar_tr_' . md5( $uri . '|' . $lang );
	$cached    = get_transient( $cache_key );

	if ( false !== $cached ) {
		return $cached;
	}

	// Nur <body>-Inhalt extrahieren und übersetzen
	if ( ! preg_match( '/(<body[^>]*>)(.*?)(<\/body>)/si', $html, $m ) ) {
		return $html;
	}

	$body_open    = $m[1];
	$body_content = $m[2];
	$body_close   = $m[3];

	// Sicherheitslimit: max. 100 KB Rohtext (DeepL-Limit: ~128 KB)
	if ( strlen( $body_content ) > 102400 ) {
		return $html;
	}

	$translated_body = brokar_deepl_translate( $body_content, $lang );

	$translated_html = str_replace(
		$body_open . $body_content . $body_close,
		$body_open . $translated_body . $body_close,
		$html
	);

	set_transient( $cache_key, $translated_html, 30 * DAY_IN_SECONDS );

	return $translated_html;
}
