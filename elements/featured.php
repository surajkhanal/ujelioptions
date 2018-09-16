<?php 

namespace Elementor;

if( !defined('ABSPATH') ) exit;

class News_featured extends Widget_Base{
    public function get_name(){
    	return 'news-featured';
    }

    public function get_title(){
    	return 'Featured News';
    }

    public function get_icon(){
    	return 'fa fa-start';
    }

    protected function _register_controls(){
		$this->start_controls_section(
            'section_layout_general',
            [
                'label' => 'General',
                'type' => Controls_Manager::SECTION
            ]
        );

        $this->add_control(
            'expire_time',
            [
                'label' => 'Expire Time',
                'type' => Controls_Manager::NUMBER,
                'default' => '48',
            ]
        );

        $this->add_control(
            'no_of_post',
            [
                'label' => 'No of post',
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
            ]
        );

        $this->end_controls_section();
    }

    protected function render( $instance = [] ){
    	$settings = $this->get_settings();
        $expire_time = $settings['expire_time'] ? $settings['expire_time'] : 48;

        $no_of_post = $settings['no_of_post']?$settings['no_of_post']:3;

    	$args = array(
    	            'posts_per_page' => $no_of_post,
    	            'meta_key' => 'meta-checkbox',
    	            'meta_value' => 'yes'
    	        );

    	$query = new \WP_Query($args);
    	// $query = get_recent_post(4, 0);
    	while($query->have_posts()): $query->the_post();
            $local_timestamp = get_the_date('U');

            $show = time_diff($local_timestamp,$expire_time);
            if($show):
    	?>
		<div class="featured-post waves-effect waves-light">
			<div class="row">
				<div class="col l12">
					<article class="article featured">
						<div class="entry-header">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title( ), 12, null ); ?></a></h2>
						</div>
					
						<div class="thumb">
							<a href="<?php the_permalink(); ?>" style="display:inline-block;"><?php the_post_thumbnail( 'full', $attr = '' ); ?></a>
						</div>
						<div class="entry-footer">
                                              
                        </div>
					</article>
				</div>
			</div>
		</div>
    	<?php
        endif;      
	    endwhile;
    }
	
	protected function _content_template(){}

	public function render_plain_content( $instance = []){}

} // News_featured
Plugin::instance()->widgets_manager->register_widget_type(new News_featured);

