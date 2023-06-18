<?php
namespace Schlack_Addon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Ko_Legal_Services extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'services';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Services', 'schlack-addon' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-code';
	}


	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'basic', 'schlack' ];
	}

	// Load CSS
	// public function get_style_depends() {

	// 	wp_register_style( 'guide-posts', plugins_url( '../assets/css/guide-posts.css', __FILE__ ));

	// 	return [
	// 		'guide-posts',
	// 	];

	// }

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	// public function get_keywords() {
	// 	return [ 'oembed', 'url', 'link' ];
	// }

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'schlack-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'title_word_limit',
			[
				'label' => esc_html__( 'Title Word Limit', 'schlack-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 8,
			]
		);
		$this->add_control(
			'content_limit',
			[
				'label' => esc_html__( 'Content Limit', 'schlack-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 10,
			]
		);
		$this->add_control(
			'post_count',
			[
				'label' => esc_html__( 'Post Per Page', 'schlack-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 9,
			]
		);
		$this->add_control(
			'learn_more',
			[
				'label' => esc_html__( 'Learn More', 'schlack-addon' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Learn More',
			]
		);
		


		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$content_limit = $settings['content_limit'];
		$title_word_limit = $settings['title_word_limit'];

		$learn_more = $settings['learn_more'];
	?>
	
	<div class="services-section">

		<?php

		// The Query
		$args = array(
			'post_type' => 'practice-area',
			'posts_per_page'      => $settings['post_count'],
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby' => 'date',
			'order'   =>  'ASC',
		);

		$the_query = new \WP_Query( $args );
		// The Loop
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				
				?>
				<article id="post-<?php the_ID() ;?>" <?php post_class( 'single-service-item' );?>>
					<?php if( has_post_thumbnail(  ) ): ?>
					<!-- <a href="<?php the_permalink(  ); ?>" class="d-block service-thumb-wrap"> -->
						<div class="service-thumb" style="background-image: url(<?php  the_post_thumbnail_url('full'); ?>);"></div>
					<!-- </a> -->
					<?php endif; ?>
					<div class="service-content">
						<!-- <a href="<?php the_permalink(  ); ?>" class="d-block"> -->
							<h2><?php echo wp_trim_words( get_the_title(), $title_word_limit, '' ); ?></h2>
						<!-- </a> -->
						<p class="d-none"><?php echo wp_trim_words( get_the_excerpt(), $content_limit, '...' ); ?></p>

						<?php if(!empty($learn_more)) : ?>
						<a href="<?php the_permalink(  ); ?>" class="learn-btn"><?php echo $learn_more; ?> <i aria-hidden="true" class="fas fa-arrow-right"></i></a>
						<?php endif; ?>
					</div>
				</article>
				<?php
			}
		}
		wp_reset_postdata();
		?>
		
		
	
	</div>
	

	<?php

	}

}