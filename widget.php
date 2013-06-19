<?php
/**
 * Custom Widgets
 *
 * @package WP Twitter API
 * @subpackage Widgets
 */

/**
 * TAPI widget class
 *
 * @since 0.1
 */

class TAPI_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'tapi_widget', 'description' => __( 'TAPI Twitter Widget' ) );
		$control_ops = array( 'width' => 300, 'height' => 338 );
		parent::__construct( 'tapi_widget', __( 'TAPI Twitter Widget' ), $widget_ops, $control_ops );
		add_action( 'wp_enqueue_scripts', array(&$this, 'add_script') );
	}

    function add_script() {
		if ( !is_admin() ) {
			wp_enqueue_script( 'tapi_widget_js', TAPI_WIDGET_PLUGIN_URL . '/js/widget.js', array( 'jquery' ) );
			wp_enqueue_style( 'tapi_widget_css', TAPI_WIDGET_PLUGIN_URL . '/css/style.css', array() );
    	}
    }

	function widget( $args, $instance ) {
		//extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$screen_name = ( empty( $instance['screen_name'] ) ) ? '' : $instance['screen_name'];
		$list = ( empty( $instance['list'] ) ) ? '' : $instance['list'];
		$count = ( empty( $instance['count'] ) ) ? 20 : absint( $instance['count'] );
		$names = ( false === strrpos( ',', $screen_name ) ) ? $screen_name : explode(',', $screen_name );
		$tweets = '';
		if ( !empty( $list ) && !is_array( $screen_name ) && !empty( $screen_name ) ) {
			// if list has a value, then we want the list items, and need a single user name of the list owner
			$args = array(
				'type' => 'list_timeline',
				'owner_screen_name' => $names,
				'slug' => $list,
				'count' => $count
			);
		} elseif ( is_array( $screen_name ) ) {
			// temporarily disable multiple name search
			echo "This feature is temporarily disabled.";
			return;
		} elseif ( !array( $screen_name ) && !empty( $screen_name ) ) {
			$args = array(
				'owner_screen_name' => $names,
				'count' => $count
			);
		} else {
			echo "Settings combination is invalid. Please check your widget settings.";
			return;
		}
		echo $before_widget; ?>
			<div class="tapi">
				<div class="tapi-header"><?php echo esc_html( $title ); ?></div>
				<div class="tapi-wrapper">
					<div class="tapi-tweets">
						<?php $x = 0;
							tapi_query_tweets( $args );
							while ( tapi_have_tweets() ) : tapi_the_tweet(); ?>
							<div class="tapi-tweet">
								<a class="tapi-avatar" href="<?php print esc_attr( tapi_get_author_permalink() ); ?>"><img src="<?php print esc_attr( tapi_get_author_avatar_url() ); ?>" width="48" height="48" /></a>
								<div class="tapi-text">
									<div class="tapi-user">
										<span class="tapi-timestamp"><?php print tapi_get_timestamp( 'age' ); ?></span>
										<a class="tapi-user-name" href="<?php print esc_attr( tapi_get_author_permalink() ); ?>"><?php print esc_html( tapi_get_author_name() ); ?></a>
										<a class="tapi-screen-name" href="<?php print esc_attr( tapi_get_author_permalink() ); ?>">@<?php print esc_html( tapi_get_author_screen_name() );?></a>
									</div>
									<?php print wp_kses_post( tapi_get_text() ); ?>
									<div class="tapi-meta">
										<a class="tapi-reply" href="http://twitter.com/intent/tweet?in_reply_to=<?php print esc_attr( tapi_get_tweet_id() ); ?>"><span>reply icon</span>reply</a>
										<a class="tapi-retweet" href="http://twitter.com/intent/retweet?tweet_id=<?php print esc_attr( tapi_get_tweet_id() ); ?>"><span>retweet icon</span>retweet</a>
										<a class="tapi-favorite" href="http://twitter.com/intent/favorite?tweet_id=<?php print esc_attr( tapi_get_tweet_id() ); ?>"><span>favorite icon</span>favorite</a>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<div class="tapi-footer">
					<div class="tapi-scroll">
						More Tweets
						<a href="#" id="tapi-prev"> &#9650;</a>&nbsp;<a href="#" id="tapi-next"> &#9660;</a>
					</div>
				</div>
			</div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['screen_name'] = strip_tags( $new_instance['screen_name'] );
		$instance['list'] = strip_tags( $new_instance['list'] );
		$instance['count'] = (int) $new_instance['count'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$screen_name = isset( $instance['screen_name'] ) ? esc_attr( $instance['screen_name']) : '';
		$list = isset( $instance['list'] ) ? esc_attr( $instance['list'] ) : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 20;
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('screen_name'); ?>"><?php _e( 'Screen name of user to retrieve tweets, a comma separated list of screen names for merged tweets, or the screen name of the list owner if list name is entered below:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('screen_name'); ?>" name="<?php echo $this->get_field_name('screen_name'); ?>" type="text" value="<?php echo esc_attr( $screen_name ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('list'); ?>"><?php _e( 'list name:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" value="<?php echo esc_attr( $list ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Number of tweets (default is 20):' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
<?php
	}
}

/**
 * Register the custom WordPress widget on startup.
 *
 * Calls 'widgets_init' action after all of the WordPress widgets have been
 * registered.
 *
 * @since 0.1
 */
function tapi_twitter_widget_init() {
	if ( !is_blog_installed() )
		return;

	register_widget('TAPI_Widget');
}

add_action('widgets_init', 'tapi_twitter_widget_init', 1);
?>