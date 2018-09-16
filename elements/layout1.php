<?php 
namespace Elementor;

if(!defined('ABSPATH')) exit;

class News_layout1 extends Widget_Base{
    public function get_name(){
    	return 'news-layout1';
    }

    public function get_title(){
    	return 'Layout 1';
    }

    public function get_icon(){
    	return 'eicon-gallery-grid';
    }

    protected function _register_controls(){
    	$categories_array = array();

	    $categories = get_categories();

	    foreach( $categories as $category ){
	       $categories_array[$category->term_id] = $category->name;
	     }

		$this->start_controls_section(
			'section_layout_general',
			[
				'label' => 'General',
				'type' => Controls_Manager::SECTION
			]
		);

		$this->add_control(
			'category',
			[
				'label' => 'Select Category',
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => $categories_array
			]
		);

		// $this->add_control(
		// 	'column',
		// 	[
		// 		'label' => 'Select Column size',
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'l12',
		// 		'options' => [
		// 			'l12' => '1 Column',
		// 			'l6' => '2 Column',
		// 			'l4' => '3 Column' 
		// 		]
		// 	]
		// );

		$this->add_control(
			'no_of_post',
			[
				'label' => 'No of Post',
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => 'Offset',
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
			]
		);

		$this->end_controls_section();
    }

    protected function render( $instance = [] ){
    	$settings = $this->get_settings();
    	
    	$category = $settings['category'] ? $settings['category']:1;

    	// $col = $settings['column'] ? $settings['column']: 'l12';

    	$no_of_post = $settings['no_of_post'] ? $settings['no_of_post']: 4;

    	$offset = $settings['offset'] ? $settings['offset']: 0;

    	$query = get_post_by_category($category, $no_of_post, $offset);

    	?>
		 <div class="layout la-one">
                <div class="news_grid--col4">
                <?php $c = 0; ?>
                <?php while($query->have_posts()): $query->the_post(); ?>
                    <div class="news-item <?php echo $c == 0? 'colspan-2 rowspan-2 news__big':'news__small'; ?>">
                        <div class="news-item--thumb">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail-medium'); ?>
                            </a>
                        </div>
                        <div class="news-item--details">
                            <h2 class="news--title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo wp_trim_words(get_the_title(), 10, null); ?>
                                </a>
                            </h2>
                            <p class="time-ago"><i class="fa fa-clock-o"></i> <?php echo time_elapsed_string(get_post_time('l, F j, Y H:i:s')); ?></p>
                            <?php if($c == 0): ?>
                            <p class="news--excerpt"><?php echo wp_trim_words(get_the_excerpt(), 40, null); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $c++; endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
    	<?php
    }
	
	protected function _content_template(){}

	public function render_plain_content($instance = []){}

} // News_layout1
Plugin::instance()->widgets_manager->register_widget_type( new News_layout1);