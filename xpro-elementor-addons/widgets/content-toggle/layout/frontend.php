<div class="xpro-content-toggle-button-wrapper xpro-content-toggle-button-layout-<?php use Elementor\Plugin;
use XproElementorAddons\Control\Xpro_Elementor_Widget_Area_Utils;

echo esc_attr( $settings['layout'] ); ?><?php echo esc_attr( ( 'yes' === $settings['default_active'] ? ' active' : '' ) ); ?>">
	<?php if ( '6' !== $settings['layout'] && $settings['primary_label'] ) : ?>
		<span class="xpro-content-toggle-before"><?php echo esc_html( $settings['primary_label'] ); ?></span>
	<?php endif; ?>
	<button data-text-before="<?php echo esc_attr( $settings['primary_label'] ); ?>"
			data-text-after="<?php echo esc_attr( $settings['secondary_label'] ); ?>" type="button"
			class="xpro-content-toggle-button">
		<span class="xpro-content-toggle-handle"></span>
	</button>
	<?php if ( '6' !== $settings['layout'] && $settings['secondary_label'] ) : ?>
		<span class="xpro-content-toggle-after"><?php echo esc_html( $settings['secondary_label'] ); ?></span>
	<?php endif; ?>
</div>

<div class="xpro-toggle-content-wrapper">
	<div class="xpro-toggle-content-first">
		<?php
		if ( 'dynamic' === $settings['primary_source'] ) {
			Xpro_Elementor_Widget_Area_Utils::parse( $settings['primary_content'], $this->get_id(), 1 );
		} elseif ( 'template' === $settings['primary_source'] ) {
			$template_post = get_post($settings['primary_template']);
			if ( $template_post && 'publish' === get_post_status( $template_post ) ) {
				if ( '' === $settings['primary_template'] ) {
					echo __( 'Your primary content here.', 'xpro-elementor-addons' );
				}
				echo Plugin::instance()->frontend->get_builder_content_for_display( $settings['primary_template'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else if ( $template_post && 'publish' !== get_post_status( $template_post ) ) {
                echo __( 'You do not have permission to view this content. Please update the content status to "Published" to make it visible.', 'xpro-elementor-addons' );
            }
		} else {
			xpro_elementor_kses( $settings['primary_editor'] );
		}
		?>
	</div>
	<div class="xpro-toggle-content-second">
		<?php
		if ( 'dynamic' === $settings['secondary_source'] ) {
			Xpro_Elementor_Widget_Area_Utils::parse( $settings['secondary_content'], $this->get_id(), 2 );
		} elseif ( 'template' === $settings['secondary_source'] ) {
			$template_post = get_post($settings['secondary_template']);
			if ( $template_post && 'publish' === get_post_status( $template_post ) ) {
				if ( '' === $settings['secondary_template'] ) {
					echo __( 'Your secondary content here.', 'xpro-elementor-addons' );
				}
				echo Plugin::instance()->frontend->get_builder_content_for_display( $settings['secondary_template'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else if ( $template_post && 'publish' !== get_post_status( $template_post ) ) {
                echo __( 'You do not have permission to view this content. Please update the content status to "Published" to make it visible.', 'xpro-elementor-addons' );
            }
		} else {
			xpro_elementor_kses( $settings['secondary_editor'] );
		}
		?>
	</div>
</div>
