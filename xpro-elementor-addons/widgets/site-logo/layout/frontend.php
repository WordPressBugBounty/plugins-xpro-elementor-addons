<?php

use Elementor\Utils;
use Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();


$image = ( 'custom' === $settings['logo_type'] && ! empty( $settings['custom_logo']['id'] ) )
	? $settings['custom_logo']['id']
	: get_theme_mod( 'custom_logo' );

$url   = ( 'custom' === $settings['link_type'] && $settings['link']['url'] )
	? $settings['link']['url']
	: get_home_url();

$attr  = ( 'custom' === $settings['link_type'] && $settings['link']['is_external'] ) ? ' target="_blank"' : '';
$attr .= ( 'custom' === $settings['link_type'] && $settings['link']['nofollow'] ) ? ' rel="nofollow"' : '';

if ( 'custom' === $settings['link_type'] && $settings['link']['custom_attributes'] ) {
	$attributes = explode( ',', $settings['link']['custom_attributes'] );

	foreach ( $attributes as $attribute ) {
		if ( ! empty( $attribute ) ) {
			$custom_attr = explode( '|', $attribute, 2 );
			if ( ! isset( $custom_attr[1] ) ) {
				$custom_attr[1] = '';
			}
			$attr .= ' ' . $custom_attr[0] . '="' . $custom_attr[1] . '"';
		}
	}
}

?>
<a href="<?php echo esc_url( $url ); ?>"<?php xpro_elementor_kses( $attr ); ?>>
	<div class="xpro-site-logo">
		<?php
		if ( 'default' === $settings['logo_type'] && has_custom_logo() ) {

			echo wp_get_attachment_image( $image, $settings['thumbnail_size'] );
		} elseif ( 'custom' === $settings['logo_type'] ) {
			echo wp_kses(Group_Control_Image_Size::get_attachment_image_html(
				$settings,
				'thumbnail',
				'custom_logo'
			), xpro_allowed_img_kses());

		}
		?>
	</div>
</a>
