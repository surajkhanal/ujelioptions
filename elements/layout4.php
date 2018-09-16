<?php 

namespace Elementor;

if( !defined('ABSPATH') ) exit;


class News_layout4 extends Widget_Base{
    public function get_name(){
    	return 'news-layout';
    }

    public function get_title(){
    	return 'Layout 4';
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

    	$no_of_post = $settings['no_of_post'] ? $settings['no_of_post']: 4;

    	$offset = $settings['offset'] ? $settings['offset']: 0;

    	$query = get_post_by_category($category, $no_of_post, $offset);
    	?>
		<div class="layout la-four">
                <?php while($query->have_posts()): $query->the_post(); ?>
                    <div class="news-item news__small">
                        <div class="news--thumb">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail-medium'); ?></a>
                        </div>
                        <div class="news--details">
                            <h2 class="news--title">
                            <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 10, null); ?></a>
                            </h2>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
                </div>
    	<?php
    }
	
	protected function _content_template(){}

	public function render_plain_content( $instance = []){}

} // News_layout4
Plugin::instance()->widgets_manager->register_widget_type( new News_layout4);