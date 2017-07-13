<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?>

<article itemscope itemtype="https://schema.org/BlogPosting" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
    <meta itemprop="dateModified" content="<?php the_modified_date('c'); ?>"/>

    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" style="display:none;">
    <span itemprop="streetAddress">название улицы</span>
    <span itemprop="postalCode">индекс</span>
    <span itemprop="addressLocality">страна, область, город</span>
    <span itemprop="telephone">телефон</span>
    </div>
    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
    <?php
    $url_l = ld_options( 'logo', false, 'url' );
    $width_l = ld_options( 'logo', false, 'width' );
    $height_l = ld_options( 'logo', false, 'height' );
    ?>
    <img itemprop="url" itemprop="image" src="<?php echo $url_l; ?>" style="display:none;"/>
    <meta itemprop="width" content="<?php echo $width_l; ?>">
    <meta itemprop="height" content="<?php echo $height_l; ?>">
    </div>
    <meta itemprop="name" content="<?php echo wp_get_document_title(); ?>">
    </div>


	<div itemprop="articleBody">

<?php if ( has_post_thumbnail()) { // post image ?>
    <span itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <?php $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID, '' ), 'thumbnail' ); ?>
        <img itemprop="url" itemprop="image" src="<?php echo $image_attributes[0] ?>" />
        <meta itemprop="width" content="<?php echo $image_attributes[1] ?>">
        <meta itemprop="height" content="<?php echo $image_attributes[2] ?>">
    </span>
<?php } ?>

        <?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>

        <div class="entry-content" itemprop="text">
            <?php the_content(); ?>
        </div>
	</div>

    <time class="date-container" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time('Y-m-d'); ?></time>

    <span itemprop="author">Denis Lipatov</span>

    <?php
    $categories = get_the_category();
    if($categories){
    	foreach($categories as $category) {
    		$out .= '<a href="'.get_category_link($category->term_id ).'"><span itemprop="articleSection">'.$category->name.'</span></a>, ';
    	}
    	echo trim($out, ', ');
    }
    ?>

</article><!-- #post-## -->