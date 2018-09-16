<?php 
namespace Elementor;

if(!defined('ABSPATH')) exit;

class Title_widget extends Widget_Base{
    public function get_name(){
    	return 'title-widget';
    }

    public function get_title(){
    	return 'Section Title';
    }

    public function get_icon(){
    	return 'fa fa-title';
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
			'title',
			[
				'label' => 'Section title',
				'type' => Controls_Manager::TEXT,
				'default' => 'Enter Title',
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
			'title_style',
			[
				'label' => 'Select Style',
				'type' => Controls_Manager::SELECT,
				'default' => 'style1',
				'options' => [
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Style', 'understrap' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'understrap' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Background Color', 'understrap' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
    }

    protected function render( $instance = [] ){
    	$settings = $this->get_settings();
    	$title = $settings['title'] ? $settings['title'] : 'Enter Title';
    	$category = $settings['category'] ? $settings['category']: 1;
    	$category_link = get_category_link( $category );

    	$bg_color = $settings['bg_color']? $settings['bg_color']: '#000';
    	$titleColor = $settings['title_color']?$settings['title_color']: '#fff';
    	?>	
    	
    	<?php if($settings['title_style'] == 'style1'): ?>
			
        <div class="section-title">
            <h2><span><?php echo $title; ?></span></h2>
            <div class="more">
                <a href="<?php echo $category_link; ?>">सबै <i class="fa fa-ellipsis-v"></i></a>
            </div>
        </div>
		
    	<?php
	    else: ?>
		
	  <?php endif;
    }
	
	protected function _content_template(){
		
	}

	public function render_plain_content($instance = []){}

} // Title_widget
Plugin::instance()->widgets_manager->register_widget_type( new Title_widget);