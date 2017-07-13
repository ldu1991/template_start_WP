<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">

		</div><!-- .entry-meta -->
		<?php
		endif; ?>

<?php // post image
	if ( has_post_thumbnail()) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<?php the_post_thumbnail('thumbnail', array('itemprop' => 'contentUrl'));
			 $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, '' ), 'thumbnail' ); ?>
			    <link itemprop="url" href="<?php echo $image_attributes[0] ?>" />
			    <meta itemprop="width" content="<?php echo $image_attributes[1] ?>">
			    <meta itemprop="height" content="<?php echo $image_attributes[2] ?>">
		 </a>
<?php } ?>        
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', '_s' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->