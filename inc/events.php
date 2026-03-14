<?php
/**
 * Brokar Events — Custom Post Type, Taxonomies, Meta Boxes
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────
// Custom Post Type: brokar_event
// ─────────────────────────────────────────────────────────────

function brokar_register_event_cpt(): void {
	$labels = [
		'name'               => __( 'Evenementen', 'brokar' ),
		'singular_name'      => __( 'Evenement', 'brokar' ),
		'add_new'            => __( 'Nieuw evenement', 'brokar' ),
		'add_new_item'       => __( 'Nieuw evenement toevoegen', 'brokar' ),
		'edit_item'          => __( 'Evenement bewerken', 'brokar' ),
		'new_item'           => __( 'Nieuw evenement', 'brokar' ),
		'view_item'          => __( 'Evenement bekijken', 'brokar' ),
		'view_items'         => __( 'Evenementen bekijken', 'brokar' ),
		'search_items'       => __( 'Evenementen zoeken', 'brokar' ),
		'not_found'          => __( 'Geen evenementen gevonden', 'brokar' ),
		'not_found_in_trash' => __( 'Geen evenementen in de prullenbak', 'brokar' ),
		'all_items'          => __( 'Alle evenementen', 'brokar' ),
		'archives'           => __( 'Evenementarchief', 'brokar' ),
		'menu_name'          => __( 'Evenementen', 'brokar' ),
	];

	register_post_type( 'brokar_event', [
		'labels'             => $labels,
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,   // Gutenberg support
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
		'rewrite'            => [ 'slug' => 'programma', 'with_front' => false ],
		'has_archive'        => 'programma',
		'capability_type'    => 'post',
		'map_meta_cap'       => true,
		'hierarchical'       => false,
	] );
}
add_action( 'init', 'brokar_register_event_cpt' );

// ─────────────────────────────────────────────────────────────
// Taxonomy: Evenement Categorie
// ─────────────────────────────────────────────────────────────

function brokar_register_event_taxonomy(): void {
	$labels = [
		'name'          => __( 'Categorieën', 'brokar' ),
		'singular_name' => __( 'Categorie', 'brokar' ),
		'search_items'  => __( 'Categorieën zoeken', 'brokar' ),
		'all_items'     => __( 'Alle categorieën', 'brokar' ),
		'edit_item'     => __( 'Categorie bewerken', 'brokar' ),
		'add_new_item'  => __( 'Nieuwe categorie toevoegen', 'brokar' ),
		'menu_name'     => __( 'Categorieën', 'brokar' ),
	];

	register_taxonomy( 'event_category', 'brokar_event', [
		'labels'            => $labels,
		'public'            => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'rewrite'           => [ 'slug' => 'evenement-categorie' ],
	] );
}
add_action( 'init', 'brokar_register_event_taxonomy' );

// ─────────────────────────────────────────────────────────────
// Meta Box: Event Details
// ─────────────────────────────────────────────────────────────

function brokar_add_event_meta_box(): void {
	add_meta_box(
		'brokar_event_details',
		__( 'Evenement Details', 'brokar' ),
		'brokar_render_event_meta_box',
		'brokar_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'brokar_add_event_meta_box' );

function brokar_render_event_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'brokar_event_meta', 'brokar_event_nonce' );

	$date     = get_post_meta( $post->ID, '_event_date',       true );
	$date_end = get_post_meta( $post->ID, '_event_date_end',   true );
	$time     = get_post_meta( $post->ID, '_event_time',       true );
	$time_end = get_post_meta( $post->ID, '_event_time_end',   true );
	$venue    = get_post_meta( $post->ID, '_event_venue',      true );
	$status   = get_post_meta( $post->ID, '_event_status',     true );
	$price    = get_post_meta( $post->ID, '_event_price',      true );
	$tickets  = get_post_meta( $post->ID, '_event_tickets_url', true );
	$featured = get_post_meta( $post->ID, '_event_featured',   true );

	$statuses = [
		''          => __( '— Kies een status —', 'brokar' ),
		'available' => __( 'Vrije plaatsen', 'brokar' ),
		'limited'   => __( 'Beperkte plaatsen', 'brokar' ),
		'soldout'   => __( 'Uitverkocht', 'brokar' ),
		'required'  => __( 'Inschrijven vereist', 'brokar' ),
		'free'      => __( 'Gratis toegang', 'brokar' ),
	];
	?>
	<style>
		.brokar-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 12px 0; }
		.brokar-meta-group { display: flex; flex-direction: column; gap: 4px; }
		.brokar-meta-group.full { grid-column: 1 / -1; }
		.brokar-meta-group label { font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em; color: #1d2327; }
		.brokar-meta-group input,
		.brokar-meta-group select,
		.brokar-meta-group textarea { width: 100%; border: 1px solid #ddd; border-radius: 4px; padding: 8px 10px; font-size: 14px; }
		.brokar-meta-group input:focus,
		.brokar-meta-group select:focus { border-color: #C9A84C; outline: none; box-shadow: 0 0 0 2px rgba(201,168,76,0.2); }
		.brokar-meta-featured { display: flex; align-items: center; gap: 8px; margin-top: 4px; }
		.brokar-meta-tip { font-size: 11px; color: #888; margin-top: 3px; }
	</style>

	<div class="brokar-meta-grid">
		<div class="brokar-meta-group">
			<label for="event_date"><?php esc_html_e( 'Startdatum', 'brokar' ); ?> *</label>
			<input type="date" id="event_date" name="event_date" value="<?php echo esc_attr( $date ); ?>" required>
		</div>
		<div class="brokar-meta-group">
			<label for="event_date_end"><?php esc_html_e( 'Einddatum (optioneel)', 'brokar' ); ?></label>
			<input type="date" id="event_date_end" name="event_date_end" value="<?php echo esc_attr( $date_end ); ?>">
			<span class="brokar-meta-tip"><?php esc_html_e( 'Alleen invullen bij meerdaagse evenementen', 'brokar' ); ?></span>
		</div>
		<div class="brokar-meta-group">
			<label for="event_time"><?php esc_html_e( 'Starttijd', 'brokar' ); ?></label>
			<input type="time" id="event_time" name="event_time" value="<?php echo esc_attr( $time ); ?>">
		</div>
		<div class="brokar-meta-group">
			<label for="event_time_end"><?php esc_html_e( 'Eindtijd', 'brokar' ); ?></label>
			<input type="time" id="event_time_end" name="event_time_end" value="<?php echo esc_attr( $time_end ); ?>">
		</div>
		<div class="brokar-meta-group full">
			<label for="event_venue"><?php esc_html_e( 'Locatie / Zaal', 'brokar' ); ?></label>
			<input type="text" id="event_venue" name="event_venue"
				value="<?php echo esc_attr( $venue ); ?>"
				placeholder="<?php esc_attr_e( 'bijv. Grote Zaal, Concertzaal, Ateliersaal…', 'brokar' ); ?>">
		</div>
		<div class="brokar-meta-group">
			<label for="event_status"><?php esc_html_e( 'Beschikbaarheid', 'brokar' ); ?></label>
			<select id="event_status" name="event_status">
				<?php foreach ( $statuses as $val => $label ) : ?>
				<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $status, $val ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="brokar-meta-group">
			<label for="event_price"><?php esc_html_e( 'Prijs', 'brokar' ); ?></label>
			<input type="text" id="event_price" name="event_price"
				value="<?php echo esc_attr( $price ); ?>"
				placeholder="<?php esc_attr_e( 'bijv. €10 / €5 reductie / Gratis', 'brokar' ); ?>">
		</div>
		<div class="brokar-meta-group full">
			<label for="event_tickets_url"><?php esc_html_e( 'Ticketlink / Inschrijflink', 'brokar' ); ?></label>
			<input type="url" id="event_tickets_url" name="event_tickets_url"
				value="<?php echo esc_attr( $tickets ); ?>"
				placeholder="https://…">
		</div>
		<div class="brokar-meta-group full">
			<div class="brokar-meta-featured">
				<input type="checkbox" id="event_featured" name="event_featured" value="1" <?php checked( $featured, '1' ); ?>>
				<label for="event_featured" style="text-transform:none; font-weight:400;">
					<?php esc_html_e( 'Uitgelicht evenement (wordt bovenaan getoond)', 'brokar' ); ?>
				</label>
			</div>
		</div>
	</div>
	<?php
}

// ─────────────────────────────────────────────────────────────
// Meta opslaan
// ─────────────────────────────────────────────────────────────

function brokar_save_event_meta( int $post_id ): void {
	if ( ! isset( $_POST['brokar_event_nonce'] ) ) return;
	if ( ! wp_verify_nonce( wp_unslash( $_POST['brokar_event_nonce'] ), 'brokar_event_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	$fields = [
		'_event_date'        => 'event_date',
		'_event_date_end'    => 'event_date_end',
		'_event_time'        => 'event_time',
		'_event_time_end'    => 'event_time_end',
		'_event_venue'       => 'event_venue',
		'_event_status'      => 'event_status',
		'_event_price'       => 'event_price',
		'_event_tickets_url' => 'event_tickets_url',
	];

	foreach ( $fields as $meta_key => $post_key ) {
		if ( isset( $_POST[ $post_key ] ) ) {
			$value = sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) );
			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	// URL extra sanitizen
	if ( isset( $_POST['event_tickets_url'] ) ) {
		update_post_meta( $post_id, '_event_tickets_url', esc_url_raw( wp_unslash( $_POST['event_tickets_url'] ) ) );
	}

	// Checkbox
	$featured = isset( $_POST['event_featured'] ) ? '1' : '0';
	update_post_meta( $post_id, '_event_featured', $featured );
}
add_action( 'save_post_brokar_event', 'brokar_save_event_meta' );

// ─────────────────────────────────────────────────────────────
// Admin-Spalten: Datum, Ort, Status in Übersicht anzeigen
// ─────────────────────────────────────────────────────────────

function brokar_event_admin_columns( array $columns ): array {
	$new = [];
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['event_date']   = __( 'Datum', 'brokar' );
			$new['event_time']   = __( 'Tijd', 'brokar' );
			$new['event_venue']  = __( 'Locatie', 'brokar' );
			$new['event_status'] = __( 'Status', 'brokar' );
		}
	}
	return $new;
}
add_filter( 'manage_brokar_event_posts_columns', 'brokar_event_admin_columns' );

function brokar_event_admin_column_content( string $column, int $post_id ): void {
	$status_labels = [
		'available' => [ __( 'Vrije plaatsen', 'brokar' ),  '#16a34a' ],
		'limited'   => [ __( 'Beperkte plaatsen', 'brokar' ), '#d97706' ],
		'soldout'   => [ __( 'Uitverkocht', 'brokar' ),      '#dc2626' ],
		'required'  => [ __( 'Inschrijven vereist', 'brokar' ), '#6b7280' ],
		'free'      => [ __( 'Gratis', 'brokar' ),           '#2563eb' ],
	];

	switch ( $column ) {
		case 'event_date':
			$d = get_post_meta( $post_id, '_event_date', true );
			$e = get_post_meta( $post_id, '_event_date_end', true );
			if ( $d ) {
				$formatted = date_i18n( 'd M Y', strtotime( $d ) );
				if ( $e && $e !== $d ) {
					$formatted .= ' — ' . date_i18n( 'd M Y', strtotime( $e ) );
				}
				echo '<strong>' . esc_html( $formatted ) . '</strong>';
			} else {
				echo '—';
			}
			break;

		case 'event_time':
			$t = get_post_meta( $post_id, '_event_time', true );
			$te = get_post_meta( $post_id, '_event_time_end', true );
			if ( $t ) {
				echo esc_html( $t );
				if ( $te ) echo ' – ' . esc_html( $te );
			} else {
				echo '—';
			}
			break;

		case 'event_venue':
			$v = get_post_meta( $post_id, '_event_venue', true );
			echo $v ? esc_html( $v ) : '—';
			break;

		case 'event_status':
			$s = get_post_meta( $post_id, '_event_status', true );
			if ( $s && isset( $status_labels[ $s ] ) ) {
				[ $label, $color ] = $status_labels[ $s ];
				printf(
					'<span style="background:%s20;color:%s;padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600;">%s</span>',
					esc_attr( $color ),
					esc_attr( $color ),
					esc_html( $label )
				);
			} else {
				echo '—';
			}
			break;
	}
}
add_action( 'manage_brokar_event_posts_custom_column', 'brokar_event_admin_column_content', 10, 2 );

// Admin-Spalten sortierbar machen
function brokar_event_sortable_columns( array $columns ): array {
	$columns['event_date'] = 'event_date';
	return $columns;
}
add_filter( 'manage_edit-brokar_event_sortable_columns', 'brokar_event_sortable_columns' );

function brokar_event_orderby( WP_Query $query ): void {
	if ( ! is_admin() || ! $query->is_main_query() ) return;
	if ( 'event_date' === $query->get( 'orderby' ) ) {
		$query->set( 'meta_key', '_event_date' );
		$query->set( 'orderby', 'meta_value' );
	}
}
add_action( 'pre_get_posts', 'brokar_event_orderby' );

// ─────────────────────────────────────────────────────────────
// Frontend: Events sortiert nach Datum (zukünftige zuerst)
// ─────────────────────────────────────────────────────────────

function brokar_event_archive_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) return;
	if ( $query->is_post_type_archive( 'brokar_event' ) ) {
		$query->set( 'posts_per_page', 12 );
		$query->set( 'meta_key', '_event_date' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'brokar_event_archive_query' );

// ─────────────────────────────────────────────────────────────
// Helper: Formatierten Datum-String holen
// ─────────────────────────────────────────────────────────────

function brokar_event_date_string( int $post_id ): string {
	$start = get_post_meta( $post_id, '_event_date', true );
	$end   = get_post_meta( $post_id, '_event_date_end', true );

	if ( ! $start ) return '';

	$fmt_start = date_i18n( 'd M', strtotime( $start ) );
	if ( $end && $end !== $start ) {
		$fmt_end = date_i18n( 'd M Y', strtotime( $end ) );
		return $fmt_start . ' — ' . $fmt_end;
	}
	return date_i18n( 'd M Y', strtotime( $start ) );
}

function brokar_event_status_config( string $status ): array {
	$map = [
		'available' => [ 'label' => __( 'Vrije plaatsen', 'brokar' ),    'cls' => 'available' ],
		'limited'   => [ 'label' => __( 'Beperkte plaatsen', 'brokar' ), 'cls' => 'warning' ],
		'soldout'   => [ 'label' => __( 'Uitverkocht', 'brokar' ),       'cls' => 'soldout' ],
		'required'  => [ 'label' => __( 'Inschrijven vereist', 'brokar' ),'cls' => 'required' ],
		'free'      => [ 'label' => __( 'Gratis', 'brokar' ),            'cls' => 'free' ],
	];
	return $map[ $status ] ?? [ 'label' => '', 'cls' => '' ];
}

// Flush rewrite rules wanneer CPT geregistreerd wordt (eenmalig)
function brokar_flush_on_activation(): void {
	brokar_register_event_cpt();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'brokar_flush_on_activation' );
