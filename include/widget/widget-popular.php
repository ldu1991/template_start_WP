<?php
/**
 * Plugin Name: Popular news
 */

class PopularNewsWidget extends WP_Widget {

	/*
	 * creating a widget
	 */
	function __construct() {
		parent::__construct(
			'popular_news_widget',
			'Popular news', // the title of the widget
			array( 'description' => 'Allows you to display the posts, sorted by the number of comments in them.' )
		);
	}

	/*
	 * frontend widget
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ); // apply filters to the title (optional)
		$posts_per_page = $instance['posts_per_page'];

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		$q = new WP_Query("posts_per_page=$posts_per_page&orderby=comment_count");
		if( $q->have_posts() ) : ?>
            <div class="footer_block_widget">
                <div class="fade-widget">
                    <?php while( $q->have_posts() ): $q->the_post(); ?>

                    <div>
                        <?php $screenshot = get_field('screenshot'); ?>
                        <div class="slid_widget" style="background-image: url(
                                <?php
                                if($screenshot) {
                                    echo $screenshot['sizes']['post-thumb'];
                                } else {
                                    echo get_template_directory_uri() . '/include/img/img-none.jpg';
                                }
                                ?>)">
                            <div class="title-slid_widget">
                                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="details">
                                    <h4><?php trim_title_chars(30, '...'); ?></h4>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; wp_reset_postdata();

		echo $args['after_widget'];
	}

	/*
	 * backend widget
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		if ( isset( $instance[ 'posts_per_page' ] ) ) {
			$posts_per_page = $instance[ 'posts_per_page' ];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Number of posts:</label>
			<input id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '5'; ?>" size="3" />
		</p>
		<?php
	}

	/*
	 * save settings widget
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : '5'; // The default output 5 posts
		return $instance;
	}
}

/*
 * registration widget
 */
function popular_news_widget_load() {
	register_widget( 'PopularNewsWidget' );
}
add_action( 'widgets_init', 'popular_news_widget_load' );
?>