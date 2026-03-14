<?php
/**
 * Page Template
 *
 * @package Brokar
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( get_the_post_thumbnail() ) : ?>
	<div class="page-hero">
		<?php the_post_thumbnail( 'brokar-hero', [ 'class' => 'page-hero__img', 'alt' => '' ] ); ?>
		<div class="page-hero__overlay"></div>
		<div class="page-hero__content container">
			<h1 class="page-hero__title" data-animate="fade-up"><?php the_title(); ?></h1>
		</div>
	</div>
	<?php else : ?>
	<div class="page-header container">
		<h1 class="page-header__title"><?php the_title(); ?></h1>
	</div>
	<?php endif; ?>

	<article class="page-content">
		<div class="container container--narrow">
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php if ( get_edit_post_link() ) : ?>
			<div class="entry-edit">
				<?php edit_post_link( __( 'Bewerk pagina', 'brokar' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
			<?php endif; ?>
		</div>
	</article>

<?php endwhile; ?>

<?php get_footer(); ?>
