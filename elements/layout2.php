<?php 
namespace Elementor;

if(!defined('ABSPATH')) exit;

class News_layout2 extends Widget_Base{
    public function get_name(){
    	return 'news-layout2';
    }

    public function get_title(){
    	return 'Layout 2';
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

    	$counter = 1;
    	?>
		<div class="layout la-two">
                    <div class="news_grid--col5">
                    <?php 
                        $d = 0; 
                        $output = '';
                        $innerHtml1 = '<div class="news-item colspan-3 rowspan-2 news__big">';
                        $innerHtml2 = '';
                    ?>
                    <?php while($query->have_posts()): $query->the_post(); 
                        if($d == 0){
                            $innerHtml1 .= '
                                <div class="news-item--thumb">
                                    <a href="'.get_the_permalink().'">
                                        '.get_the_post_thumbnail($query->ID, 'thumbnail-medium').'
                                    </a>
                                </div>
                                <div class="news-item--details">
                                    <h2 class="news--title">
                                        <a href="'.get_the_permalink().'">'.wp_trim_words(get_the_title(),10,null).' </a>
                                    </h2>
                                    <p class="time-ago"><i class="fa fa-clock-o"></i>  '.time_elapsed_string(get_post_time('l, F j, Y H:i:s')).'</p>
                                    <p class="news--excerpt">'.wp_trim_words(get_the_excerpt(), 40, null).'</p>
                                </div>
                            ';
                        } else {
                            $innerHtml2 .= '
                            <div class="news-item news__small">
                                <div class="news-item--thumb">
                                    <a href="'.get_the_permalink().'">
                                        '.get_the_post_thumbnail($query->ID, 'thumbnail-medium').'
                                    </a>
                                </div>
                                <div class="news-item--details">
                                    <h2 class="news--title">
                                        <a href="'.get_the_permalink().'">'. wp_trim_words(get_the_title(),10,null).'</a>
                                    </h2>
                                    <p class="time-ago"><i class="fa fa-clock-o"></i> '.time_elapsed_string(get_post_time('l, F j, Y H:i:s')).'</p>
                                </div>
                            </div>
                            ';
                        } 
                        $d++; 
                        endwhile;
                        wp_reset_postdata();
                        $innerHtml1 .= '</div>'; 
                        $output = $innerHtml1 . '<div class="colspan-2">' . $innerHtml2 .'</div>';
                        echo $output;
                    ?>
                    </div>
                </div>
    	<?php
    }
	
	protected function _content_template(){}

	public function render_plain_content( $instance = []){}

} // News_layout2
Plugin::instance()->widgets_manager->register_widget_type( new News_layout2) ;