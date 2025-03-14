<?php

namespace XproElementorAddons\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
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
class Woo_Product_Title extends Widget_Base {

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
		return 'xpro-woo-product-title';
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
		return __( 'Woo Product Title', 'xpro-elementor-addons' );
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
		return 'xi-edit xpro-widget-label';
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
		return array( 'xpro-themer' );
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
		return array( 'woo', 'product', 'title' );
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
			'section_general_fields',
			array(
				'label' => __( 'General', 'xpro-elementor-addons' ),
			)
		);

		if ( ! class_exists( '\WooCommerce' ) ) {
			$this->add_control(
				'woo_missing_notice',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						/* translators: %s: Title */
						__( 'Looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'xpro-elementor-addons' ),
						'<a href="' . esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) )
						. '" target="_blank" rel="noopener">Woocommerce Plugin</a>'
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				)
			);

			$this->add_control(
				'woo_install',
				array(
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => '<a href="' . esc_url( admin_url( 'plugin-install.php?s=woocommerce&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">Click to install or activate Woocommerce Plugin</a>',
				)
			);
			$this->end_controls_section();

			return;
		}

		$this->add_control(
			'icon',
			array(
				'label'       => __( 'Icon', 'xpro-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
			)
		);

		$this->add_control(
			'icon_align',
			array(
				'label'     => __( 'Icon Position', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Before', 'xpro-elementor-addons' ),
					'right' => __( 'After', 'xpro-elementor-addons' ),
				),
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'icon_indent',
			array(
				'label'     => __( 'Icon Spacing', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'condition' => array(
					'icon[value]!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .xpro-woo-product-title-icon-left > .xpro-woo-product-title-icon'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-woo-product-title-icon-right > .xpro-woo-product-title-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => __( 'HTML Tag', 'xpro-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1' => __( 'H1', 'xpro-elementor-addons' ),
					'h2' => __( 'H2', 'xpro-elementor-addons' ),
					'h3' => __( 'H3', 'xpro-elementor-addons' ),
					'h4' => __( 'H4', 'xpro-elementor-addons' ),
					'h5' => __( 'H5', 'xpro-elementor-addons' ),
					'h6' => __( 'H6', 'xpro-elementor-addons' ),
				),
				'default' => 'h2',
			)
		);

		$this->add_responsive_control(
			'title_text_align',
			array(
				'label'     => __( 'Alignment', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'xpro-elementor-addons' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'xpro-elementor-addons' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'xpro-elementor-addons' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.elementor-widget-xpro-woo-product-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_styling',
			array(
				'label' => __( 'Title', 'xpro-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .xpro-woo-product-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-woo-product-title-text'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .xpro-woo-product-title-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .xpro-woo-product-title-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_stroke',
			array(
				'label'        => __( 'Stroke', 'xpro-elementor-addons' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'xpro-elementor-addons' ),
				'label_on'     => __( 'Custom', 'xpro-elementor-addons' ),
				'return_value' => 'yes',
			)
		);

		$this->start_popover();

		$this->add_control(
			'stroke_color',
			array(
				'label'     => __( 'Stroke Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-woo-product-title-text' => '-webkit-text-stroke-width: 1px; -webkit-text-stroke-color: {{VALUE}};',
				),
				'condition' => array(
					'title_stroke' => 'yes',
				),
			)
		);

		$this->add_control(
			'stroke_width',
			array(
				'label'      => __( 'Stroke Width', 'xpro-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 10,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .xpro-woo-product-title-text' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'title_stroke' => 'yes',
				),
			)
		);

		$this->end_popover();

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .xpro-woo-product-title-text,{{WRAPPER}} .xpro-woo-product-title-icon',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_icon',
			array(
				'label'     => __( 'Icon', 'xpro-elementor-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'icon[value]!' => '',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Color', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .xpro-woo-product-title-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .xpro-woo-product-title-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'     => __( 'Icon Size', 'xpro-elementor-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .xpro-woo-product-title-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .xpro-woo-product-title-icon svg' => 'height:auto; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

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
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		require XPRO_ELEMENTOR_ADDONS_WIDGET . 'woo-product-title/layout/frontend.php';
	}
}
