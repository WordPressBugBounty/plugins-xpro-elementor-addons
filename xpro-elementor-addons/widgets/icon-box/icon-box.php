<?php

namespace XproElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Xpro Elementor Addons
 *
 * Elementor widget.
 *
 * @since 1.0.0
 */
class Icon_Box extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve image widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'xpro-icon-box';
	}

	/**
	 * Get widget inner wrapper.
	 *
	 * Retrieve widget require the inner wrapper or not.
	 *
	 */
	public function has_widget_inner_wrapper(): bool {
		$has_wrapper = ! Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
		return $has_wrapper;
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Icon Box', 'xpro-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'xi-icon-box xpro-widget-label';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the image widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_categories() {
		return array( 'xpro-widgets' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_keywords() {
		return array( 'xpro', 'icon', 'icon-box' );
	}

	/**
	 * Retrieve the list of style the widget depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @return array Widget style dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_style_depends() {

		return array( 'animate' );
	}
    
	public function get_script_depends() {
		return array( 'lottie' );
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'section_icon',
			array(
				'label' => __( 'Content', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
        
		$this->add_control(
			'media_type',
			array(
				'label'       => __( 'Media Type', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'icon'  => array(
						'title' => __( 'Icon', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-star-o',
					),
					'image' => array(
						'title' => __( 'Image', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-image',
					),
					'lottie' => array(
						'title' => __( 'Lottie', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-animation',
					),
				),
				'default'     => 'icon',
				'toggle'      => false,
			)
		);

		$this->add_control(
			'lottie_source',
			array(
				'label'       => __( 'Select Source', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'upload' => __( 'Media File', 'xpro-elementor-addons' ),
					'url'    => __( 'External Link', 'xpro-elementor-addons' ),
				),
				'default'     => 'upload',
				'condition'   => array(
					'media_type' => 'lottie',
				),
				'frontend_available' => true,
			)
		);
		
		$this->add_control(
			'svg_upload',
			array(
				'label'       => __( 'Media File', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::MEDIA,
				'media_type'  => 'application/json',
				'condition'   => array(
					'lottie_source' => 'upload',
					'media_type' => 'lottie',
				),
				'frontend_available' => true,
			)
		);
		
		$this->add_control(
			'lottie_url',
			array(
				'label'       => __( 'External Link', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://lottie.demo/1.json', 'xpro-elementor-addons' ),
				'condition'   => array(
					'lottie_source' => 'url',
					'media_type' => 'lottie', 
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'icon',
			array(
				'show_label'  => false,
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default'     => array(
					'value'   => 'fas fa-fingerprint',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'media_type' => 'icon',
				),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'     => __( 'Image', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'media_type' => 'image',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail',
				'default'   => 'full',
				'separator' => 'none',
				'exclude'   => array(
					'custom',
				),
				'condition' => array(
					'media_type' => 'image',
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Icon Box', 'xpro-elementor-addons' ),
				'placeholder' => __( 'Type Icon Box Title', 'xpro-elementor-addons' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				//'default'     => __( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'xpro-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your description here', 'xpro-elementor-addons' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'badge_text',
			array(
				'label'       => __( 'Badge Text', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Type Icon Badge Text', 'xpro-elementor-addons' ),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);
        
		$this->add_control(
			'box_icon_button',
			array(
				'label'        => __( 'Show Button', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'xpro-elementor-addons' ),
				'label_off'    => __( 'Hide', 'xpro-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);
		
		$this->add_control(
			'button_text',
			array(
				'label'       => __( ' Button Text', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
				'condition' => array(
					'box_icon_button' => 'yes',
				),
				'default'     => __( 'Click Here', 'xpro-elementor-addons' ),
				'placeholder' => __( 'Click Here', 'xpro-elementor-addons' ),
			)
			
		);

		$this->add_control(
			'box_icon_link_option',
			array(
				'label'        => __( 'Add Button Link', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'xpro-elementor-addons' ),
				'label_off'    => __( 'Hide', 'xpro-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
				     'box_icon_button' => 'yes',
				),
			)
		);
		
		$this->add_control(
			'button_link',
			array(
				'label'       => __( ' Button Link', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => __( 'https://your-link.com', 'xpro-elementor-addons' ),
				'default'     => array(
					'url' => '#',
				),
				'condition' => array(
					'box_icon_link_option' => 'yes',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => __( 'Box Link', 'xpro-elementor-addons' ),
				'separator'   => 'before',
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'     => __( 'Title HTML Tag', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'separator' => 'before',
				'options'   => array(
					'h1' => array(
						'title' => __( 'H1', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h1',
					),
					'h2' => array(
						'title' => __( 'H2', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h2',
					),
					'h3' => array(
						'title' => __( 'H3', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h3',
					),
					'h4' => array(
						'title' => __( 'H4', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h4',
					),
					'h5' => array(
						'title' => __( 'H5', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h5',
					),
					'h6' => array(
						'title' => __( 'H6', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-editor-h6',
					),
				),
				'default'   => 'h3',
				'toggle'    => false,
			)
		);

		$this->add_responsive_control(
			'layout',
			array(
				'label'     => __( 'Layout', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'inline-flex'  => array(
						'title' => __( 'Inline', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-ellipsis-h',
					),
					'inline-block' => array(
						'title' => __( 'Block', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-menu-bar',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner' => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'align',
			array(
				'label'        => __( 'Alignment', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'   => array(
						'title' => __( 'Left', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'prefix_class' => 'xpro-content-align%s',
				'selectors'    => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		//Styling Tab
        
		
		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => __( 'Box', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
	
		$this->start_controls_tabs('box_wrapper_background_tabs');
		$this->start_controls_tab(
			'box_wrapper_background_normal_tab',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'box_wrapper_background',
				'label'    => __( 'Background', 'xpro-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .xpro-box-icon-wrapper-inner',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_wrapper_box_shadow',
				'label'    => __( 'Box Shadow', 'xpro-elementor-addons' ),
				'selector' => '{{WRAPPER}} .xpro-box-icon-wrapper-inner',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_wrapper_background_hover_tab',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'box_wrapper_background_hover_color',
			array(
				'label'     => __( 'Hover Background Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_wrapper_box_shadow_hover',
				'label'    => __( 'Hover Box Shadow', 'xpro-elementor-addons' ),
				'selector' => '{{WRAPPER}} .xpro-box-icon-wrapper-inner:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'box_wrapper_border',
				'selector' => '{{WRAPPER}} .xpro-box-icon-wrapper-inner',
			)
		);

		$this->add_responsive_control(
			'box_wrapper_border_radius',
			array(
				'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_wrapper_padding',
			array(
				'label'      => __( 'Padding', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'box_wrapper_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => __( 'Icon', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Size', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 300,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 40,
				),
				'condition'  => array(

					'media_type' => 'icon',
					'media_type' => 'image',

				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'font-size: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-box-icon-item > svg,{{WRAPPER}} .xpro-box-icon-item > img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_bg_size',
			array(
				'label'      => __( 'Background Size', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 500,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'media_type' => 'icon',
				),
			)
		);
       //  add lottie size	
		$this->add_responsive_control(
			'icon_lottie_size',
			array(
				'label'      => __( ' Lottie Size', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 500,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-lottie-animation svg ' => ' width: {{SIZE}}{{UNIT}} !important ;',
				),
				'condition'  => array(
					'media_type' => 'lottie',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'          => __( 'Height', 'xpro-elementor-addons' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( 'px', 'vh' ),
				'range'          => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'vh' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'      => array(
					'media_type' => 'image',
				),
				'selectors'      => array(
					'{{WRAPPER}} .xpro-box-icon-item > img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'object-fit',
			array(
				'label'     => __( 'Object Fit', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''        => __( 'Default', 'xpro-elementor-addons' ),
					'fill'    => __( 'Fill', 'xpro-elementor-addons' ),
					'cover'   => __( 'Cover', 'xpro-elementor-addons' ),
					'contain' => __( 'Contain', 'xpro-elementor-addons' ),
				),
				'default'   => '',
				'condition' => array(
					'media_type'          => 'image',
					'image_height[size]!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-item > img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_vertical_align',
			array(
				'label'     => __( 'Vertical Align', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Start', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => __( 'Center', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => __( 'End', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'condition' => array(
					'layout' => 'inline-flex',
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-wrapper-inner' => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .xpro-box-icon-item',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => __( 'Padding', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'media_type' => 'image',
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .xpro-box-icon-item',
			)
		);

		$this->start_controls_tabs( '_tabs_icon' );

		$this->start_controls_tab(
			'_tab_icon_normal',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .xpro-box-icon-item > svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'icon_bg_color',
				'label'    => __( 'Background', 'xpro-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .xpro-box-icon-item',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_icon_hover',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_hover_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-box-icon-item' => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .xpro-box-icon-item > svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'icon_hover_bg_color',
				'label'    => __( 'Background', 'xpro-elementor-addons' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}}:hover .xpro-box-icon-item',
			)
		);

		$this->add_control(
			'icon_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-box-icon-item' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'icon_border_border!' => '',
				),
			)
		);

		$this->add_control(
			'icon_hover_animation',
			array(
				'label'              => __( 'Animation', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '',
				'options'            => array(
					''           => __( 'None', 'xpro-elementor-addons' ),
					'fadeIn'     => __( 'FadeIn', 'xpro-elementor-addons' ),
					'bounce'     => __( 'Bounce', 'xpro-elementor-addons' ),
					'bounceIn'   => __( 'BounceIn', 'xpro-elementor-addons' ),
					'bounceOut'  => __( 'BounceOut', 'xpro-elementor-addons' ),
					'flash'      => __( 'Flash', 'xpro-elementor-addons' ),
					'pulse'      => __( 'Pulse', 'xpro-elementor-addons' ),
					'rubberBand' => __( 'Rubber', 'xpro-elementor-addons' ),
					'shake'      => __( 'Shake', 'xpro-elementor-addons' ),
					'swing'      => __( 'Swing', 'xpro-elementor-addons' ),
					'tada'       => __( 'Tada', 'xpro-elementor-addons' ),
					'wobble'     => __( 'Wobble', 'xpro-elementor-addons' ),
					'flipInX'    => __( 'Flip X', 'xpro-elementor-addons' ),
					'flipInY'    => __( 'Flip Y', 'xpro-elementor-addons' ),
				),
				'frontend_available' => true,
				'render_type'        => 'template',
			)
		);

		$this->add_control(
			'icon_hover_transition',
			array(
				'label'     => __( 'Transition Duration', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 3,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-item' => 'animation-duration: {{SIZE}}s; transition-duration: {{SIZE}}s;',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			array(
				'label'     => __( 'Title', 'xpro-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'title!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title',
				'selector' => '{{WRAPPER}} .xpro-box-icon-title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title',
				'selector' => '{{WRAPPER}} .xpro-box-icon-title',
			)
		);

		$this->start_controls_tabs( '_tabs_title' );

		$this->start_controls_tab(
			'_tab_title_normal',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_title_hover',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-box-icon-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		//Description
		$this->start_controls_section(
			'section_style_description',
			array(
				'label'     => __( 'Description', 'xpro-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'description!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description',
				'selector' => '{{WRAPPER}} .xpro-box-icon-description',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'description',
				'selector' => '{{WRAPPER}} .xpro-box-icon-description',
			)
		);

		$this->start_controls_tabs( '_tabs_description' );

		$this->start_controls_tab(
			'_tab_description_normal',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-box-icon-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_description_hover',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'description_hover_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-box-icon-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .xpro-box-icon-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_badge',
			array(
				'label'     => __( 'Badge', 'xpro-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'badge_text!' => '',
				),
			)
		);

		$this->add_control(
			'badge_position',
			array(
				'label'   => __( 'Position', 'xpro-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'top-left'      => __( 'Top Left', 'xpro-elementor-addons' ),
					'top-center'    => __( 'Top Center', 'xpro-elementor-addons' ),
					'top-right'     => __( 'Top Right', 'xpro-elementor-addons' ),
					'middle-left'   => __( 'Middle Left', 'xpro-elementor-addons' ),
					'middle-center' => __( 'Middle Center', 'xpro-elementor-addons' ),
					'middle-right'  => __( 'Middle Right', 'xpro-elementor-addons' ),
					'bottom-left'   => __( 'Bottom Left', 'xpro-elementor-addons' ),
					'bottom-center' => __( 'Bottom Center', 'xpro-elementor-addons' ),
					'bottom-right'  => __( 'Bottom Right', 'xpro-elementor-addons' ),
				),
				'default' => 'top-right',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'label'    => __( 'Typography', 'xpro-elementor-addons' ),
				'selector' => '{{WRAPPER}} .xpro-badge',
			)
		);

		$this->add_control(
			'badge_offset_toggle',
			array(
				'label'        => __( 'Offset', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'xpro-elementor-addons' ),
				'label_on'     => __( 'Custom', 'xpro-elementor-addons' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_responsive_control(
			'badge_offset_x',
			array(
				'label'      => __( 'Offset Left', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'badge_offset_toggle' => 'yes',
				),
				'default'    => array(
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => - 1000,
						'max' => 1000,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-badge' => '--xpro-badge-translate-x: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'badge_offset_y',
			array(
				'label'      => __( 'Offset Top', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'condition'  => array(
					'badge_offset_toggle' => 'yes',
				),
				'default'    => array(
					'unit' => 'px',
				),
				'range'      => array(
					'px' => array(
						'min' => - 1000,
						'max' => 1000,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-badge' => '--xpro-badge-translate-y: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_popover();

		$this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => __( 'Padding', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'badge_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-badge' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'badge_bg_color',
			array(
				'label'     => __( 'Background Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-badge' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'badge_border',
				'selector' => '{{WRAPPER}} .xpro-badge',
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .xpro-badge',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			array(
				'label'     => __( 'Button', 'xpro-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'       => __( 'Icon', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
			)
		);

		$this->add_control(
			'button_icon_align',
			array(
				'label'     => __( 'Icon Position', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'xpro-elementor-addons' ),
					'right' => __( 'After', 'xpro-elementor-addons' ),
				),
			)
		);

		$this->add_responsive_control(
			'icon_indent',
			array(
				'label'     => __( 'Icon Spacing', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'default'   => array(
					'unit' => 'px',
					'size' => 8,
				),
				'selectors' => array(
					'{{WRAPPER}} a.xpro-elementor-button-info-box.icon-after i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} a.xpro-elementor-button-info-box.icon-before i'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} a.xpro-elementor-button-info-box.icon-after svg' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} a.xpro-elementor-button-info-box.icon-before svg'  => 'margin-right: {{SIZE}}{{UNIT}};',
				),	
			)
		);

		$this->add_responsive_control(
			'info_box_button_icon_size',
			array(
				'label'     => __( 'Icon Size', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 16,
				),
				'range'     => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-info-box-button-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typo',
				'selector' => '{{WRAPPER}} .xpro-info-box-button-wrapper .xpro-elementor-button-info-box span.info-box-button-text',
			)
		);
		
		$this->add_responsive_control(
			'info_box_button_icon_alignment',
			array(
				'label'     => __( 'Text Alignment', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'label_block' => true,
				'options'   => array(
					'top'   => __( 'Top', 'xpro-elementor-addons' ),
					'center' => __( 'Center', 'xpro-elementor-addons' ),
					'end'  => __( 'End', 'xpro-elementor-addons' ),
				),
				'selectors' => array(
					'{{WRAPPER}} a.xpro-elementor-button-info-box ' => 'display: flex; align-items: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'info_box_button_postion',
			array(
				'label'        => __( 'Button Alignment', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => true,
				'options'      => array(
					'left'   => array(
						'title' => __( 'Left', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper' => 'display: flex; justify-content: {{VALUE}};',
				),
				'default' => 'center',
			)
		);

		$this->add_responsive_control(
			'info_box_button_padding',
			array(
				'label'      => __( 'Padding', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}}  .xpro-info-box-button-wrapper  button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$this->add_responsive_control(
			'info_box_button_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'default'    => array(
					'top'    => '10',
					'right'  => '10',
					'bottom' => '10',
					'left'   => '10',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper  button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);
		
		// Button Border Control
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'info_box_button_border',
				'label'       => __( 'Border', 'xpro-elementor-addons' ),
				'selector'    => '{{WRAPPER}} .xpro-info-box-button-wrapper button',
			)
		);
        
		$this->add_responsive_control(
			'info_box_button_border_radius',
			 array(
				 'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				 'type'       => Controls_Manager::DIMENSIONS,
				 'size_units' => array( 'px', '%' ),
				 'selectors'  => array(
					 '{{WRAPPER}} .xpro-info-box-button-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				 ),
			 )
		 );
		
		$this->start_controls_tabs('info_box_button_color_tabs');

		$this->start_controls_tab(
			'info_box_button_normal_tab',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);
		
		$this->add_control(
			'info_box_button_background',
			array(
				'label'     => __( 'Background Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#61ce70', 
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper  button' => 'background-color: {{VALUE}};',
				),
			)
		);
		
		$this->add_control(
			'info_box_button_text_color',
			array(
				'label'     => __( 'Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff', 
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper .xpro-elementor-button-info-box  span.info-box-button-text' => 'color: {{VALUE}};',
				),
			)
		);
		
		$this->add_control(
			'info_box_button_icon_color',
			array(
				'label'     => __( 'Icon Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff', 
				'selectors' => array(
					'{{WRAPPER}} a.xpro-elementor-button-info-box svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} a.xpro-elementor-button-info-box svg path' => 'fill: {{VALUE}};',

				),
			)
		);
		
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'info_box_button_hover_tab',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);
		
		$this->add_control(
			'info_box_button_hover_background',
			array(
				'label'     => __( 'Hover Background Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#55a960',
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper button:hover' => 'background-color: {{VALUE}};',
				),
			)
		);
		
		$this->add_control(
			'info_box_button_hover_text_color',
			array(
				'label'     => __( 'Hover Text Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .xpro-info-box-button-wrapper .xpro-elementor-button-info-box:hover span.info-box-button-text' => 'color: {{VALUE}};',
				),
			)
		);
		
		$this->add_control(
			'info_box_button_hover_icon_color',
			array(
				'label'     => __( 'Hover Icon Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(

					'{{WRAPPER}} a.xpro-elementor-button-info-box:hover svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} a.xpro-elementor-button-info-box:hover svg path' => 'fill: {{VALUE}};',

				),
			)
		);
		
		$this->end_controls_tab(); 
		$this->end_controls_tabs(); 

		$this->end_controls_section();
	}

	/**
	 * Render image widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_render_attribute( 'title', 'class', 'xpro-box-icon-title' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_render_attribute( 'description', 'class', 'xpro-box-icon-description' );

		$this->add_inline_editing_attributes( 'badge_text', 'none' );
		$this->add_render_attribute( 'badge_text', 'class', 'xpro-badge xpro-badge-' . $settings['badge_position'] );

		require XPRO_ELEMENTOR_ADDONS_WIDGET . 'icon-box/layout/frontend.php';
	}
}
