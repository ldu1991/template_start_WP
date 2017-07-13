<?php
/*
 * Schema.org
 */

// Navigation
function nav($content) {
$pattern = "<a ";
$replacement = '<a itemprop="url" ';
$content = str_replace($pattern, $replacement, $content);
return $content;
}
add_filter('wp_nav_menu', 'nav');


// img
function micro_images_captions ($a , $attr, $content = null){
extract(shortcode_atts(array('id' => '', 'align' => 'alignnone', 'width' => '', 'caption' => ''), $attr));
 if ( 1 > (int) $width || empty($caption) )
 return $content;
 $caption = html_entity_decode( $caption );
 if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
return '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';}
function micro_image($content) {
$ar_mk = '!<img class="(.*?)" (.*?) width="(.*?)" height="(.*?)" (.*?)/>!si';
$br_mk = '<span class="\\1" itemprop="image" itemscope itemtype="https://schema.org/ImageObject"><img itemprop="url" itemprop="image" \\2 width="\\3" height="\\4" \\5/><meta itemprop="width" content="\\2"><meta itemprop="height" content="\\3"></span>';
$content = preg_replace($ar_mk, $br_mk, $content);
 return $content;
}
add_filter('the_content', 'micro_image');
add_filter('img_caption_shortcode', 'micro_images_captions', 10, 3);


// thumbnail
function micro_thumbnail($content) {
$ar	= '!<img alt="" width="(.*?)" height="(.*?)" />!si';
$br = '<img alt="" width="\\1" height="\\2" />';
$content = preg_replace($ar, $br, $content);
	return $content;
}
add_filter('post_thumbnail_html', 'micro_thumbnail');