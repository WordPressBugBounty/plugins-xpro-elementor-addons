<?php

namespace XproElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

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
class Counter extends Widget_Base {

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
		return 'xpro-counter';
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
		return __( 'Counter', 'xpro-elementor-addons' );
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
		return 'xi-counter xpro-widget-label';
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
		return array( 'xpro', 'number', 'counter' );
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */

	public function get_script_depends() {
		return array( 'waypoints', 'lottie' );
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
			'section_counter',
			array(
				'label' => __( 'General', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'value',
			array(
				'label'              => esc_html__( 'Counter Value', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 10000,
				'step'               => 1,
				'default'            => 90,
				'frontend_available' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'symbol',
			array(
				'label'              => __( 'Symbol', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::TEXT,
				'default'            => __( 'K', 'xpro-elementor-addons' ),
				'frontend_available' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'animate_counter',
			array(
				'label'              => __( 'Animate Value', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Show', 'xpro-elementor-addons' ),
				'label_off'          => __( 'Hide', 'xpro-elementor-addons' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => __( 'Title', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Counter Title', 'xpro-elementor-addons' ),
				'placeholder' => __( 'Type Counter Title', 'xpro-elementor-addons' ),
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
				'default'     => __( 'Description Here', 'xpro-elementor-addons' ),
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
			'align',
			array(
				'label'     => __( 'Alignment', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
					'{{WRAPPER}} .xpro-counter-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'duration',
			array(
				'label'              => esc_html__( 'Animation Duration', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::SLIDER,
				'size_units'         => array( 'px' ),
				'frontend_available' => true,
				'separator'          => 'before',
				'range'              => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 1,
					),

				),
				'default'            => array(
					'size' => 3,
				),
				'condition'          => array(
					'animate_counter' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'show_media_icons',
			array(
				'label'              => __( 'Show Media', 'xpro-elementor-addons' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => __( 'Show', 'xpro-elementor-addons' ),
				'label_off'          => __( 'Hide', 'xpro-elementor-addons' ),
				'return_value'       => 'yes',
				'default'            => 'no',
				'frontend_available' => true,
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
				'condition'   => array(
					'show_media_icons' => 'yes',
				),
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
					'show_media_icons' => 'yes',
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
					'show_media_icons' => 'yes',
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
					'show_media_icons' => 'yes',
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
					'show_media_icons' => 'yes',
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
					'show_media_icons' => 'yes',
				),
				'dynamic'   => array(
					'active' => true,
				),
			)
		);

		$this->end_controls_section();

		//Styling Tab
		$this->start_controls_section(
			'section_style_counter',
			array(
				'label' => __( 'Counter', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'counter_typography',
				'label'    => __( 'Typography', 'xpro-elementor-addons' ),
				'selector' => '{{WRAPPER}} .xpro-counter-item',
			)
		);

		$this->add_responsive_control(
			'counter_bg_size',
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
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-item' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'counter_margin',
			array(
				'label'      => __( 'Margin', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'counter_border',
				'selector' => '{{WRAPPER}} .xpro-counter-item',
			)
		);

		$this->add_responsive_control(
			'counter_border_radius',
			array(
				'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'counter_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .xpro-counter-item',
			)
		);

		$this->start_controls_tabs( '_tabs_icon' );

		$this->start_controls_tab(
			'_tab_counter_normal',
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'counter_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-counter-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'counter_symbol_color',
			array(
				'label'     => __( 'Symbol Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-counter-item > .symbol' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'counter_bg_color',
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .xpro-counter-item',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_hover',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'counter_hover_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-counter-item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'counter_hover_symbol',
			array(
				'label'     => __( 'Symbol Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-counter-item > .symbol' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'counter_hover_bg_color',
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}}:hover .xpro-counter-item',
			)
		);

		$this->add_control(
			'counter_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-counter-item' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'counter_border_border!' => '',
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
				'selector' => '{{WRAPPER}} .xpro-counter-title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title',
				'selector' => '{{WRAPPER}} .xpro-counter-title',
			)
		);

		$this->start_controls_tabs( 'tabs_title' );

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
					'{{WRAPPER}} .xpro-counter-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_title_hover',
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
					'{{WRAPPER}}:hover .xpro-counter-title' => 'color: {{VALUE}};',
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
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .xpro-counter-description',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'description',
				'selector' => '{{WRAPPER}} .xpro-counter-description',
			)
		);

		$this->start_controls_tabs( 'tabs_description' );

		$this->start_controls_tab(
			'tab_description_normal',
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
					'{{WRAPPER}} .xpro-counter-description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_description_hover',
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
					'{{WRAPPER}}:hover .xpro-counter-description' => 'color: {{VALUE}};',
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
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .xpro-badge',
			)
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
			'section_style_icon',
			array(
				'label' => __( 'Media', 'xpro-elementor-addons' ),
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
					'media_type' => array( 'icon','image' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i'   => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);	

		$this->add_responsive_control(
			'icon_lottie_size_height',
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
			         '{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item div#xpro-counter-box-lottie svg' => 'width: {{SIZE}}{{UNIT}} !important; Height: {{SIZE}}{{UNIT}} !important;' ,
				),
				'condition'  => array(
					 'media_type' => 'lottie',
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
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img' => 'object-fit: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_vertical_align',
			array(
				'label'     => __( 'Vertical Align', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'row' => array(
						'title' => __( 'Left', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-h-align-left',
					),
					'column'     => array(
						'title' => __( 'Top', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-v-align-top',
					),
					'column-reverse'   => array(
						'title' => __( 'Bottom', 'xpro-elementor-addons' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-counter-wrapper-inner' => 'align-items: center; display:flex; flex-direction:{{VALUE}} ',
				),
			)
		);

		$this->add_group_control(
		Group_Control_Border::get_type(),
				array(
					'name'     => 'icon_border',
					'selector' => '{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg,
					               {{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img, 
								   {{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i',
			)
		);

		$this->add_responsive_control(
			'icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_padding',
			array(
				'label'      => __( 'Padding', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item,
					{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg,
					{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img,
					{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i' => 
					'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg,
					               {{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img, 
								   {{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i',
			)
		);

		$this->start_controls_tabs( 'tabs_icon_style' ); 

		// Normal Tab
		$this->start_controls_tab(
			'tab_icon_normal', 
			array(
				'label' => __( 'Normal', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'media_type!' => 'image',
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'icon_bg_color',
				'label'     => __( 'Background', 'xpro-elementor-addons' ),
				'types'     => array( 'classic', 'gradient' ),
				'exclude'   => array( 'image' ),
				'condition' => array(
					'media_type!' => 'image',
				),
				'selector' => '{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item svg,
							{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item img,
							{{WRAPPER}} .xpro-counter-wrapper .xpro-counter-icon-item i',
			)
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_icon_hover',
			array(
				'label' => __( 'Hover', 'xpro-elementor-addons' ),
			)
		);

		$this->add_control(
			'icon_hover_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'media_type!' => 'image',
				),
				'selectors' => array(
					'{{WRAPPER}}:hover .xpro-counter-wrapper .xpro-counter-icon-item i'   => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .xpro-counter-wrapper .xpro-counter-icon-item svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'icon_hover_bg_color',
				'label'     => __( 'Background', 'xpro-elementor-addons' ),
				'types'     => array( 'classic', 'gradient' ),
				'exclude'   => array( 'image' ),
				'condition' => array(
					'media_type!' => 'image',
				),
				'selector' => '{{WRAPPER}}:hover .xpro-counter-wrapper .xpro-counter-icon-item svg,
							{{WRAPPER}}:hover .xpro-counter-wrapper .xpro-counter-icon-item img,
							{{WRAPPER}}:hover .xpro-counter-wrapper .xpro-counter-icon-item i',
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
		$this->add_render_attribute( 'title', 'class', 'xpro-counter-title' );
		$this->add_inline_editing_attributes( 'description', 'basic' );
		$this->add_render_attribute( 'description', 'class', 'xpro-counter-description' );

		$this->add_inline_editing_attributes( 'badge_text', 'none' );
		$this->add_render_attribute( 'badge_text', 'class', 'xpro-badge xpro-badge-' . $settings['badge_position'] );

		require XPRO_ELEMENTOR_ADDONS_WIDGET . 'counter/layout/frontend.php';

	}

}
