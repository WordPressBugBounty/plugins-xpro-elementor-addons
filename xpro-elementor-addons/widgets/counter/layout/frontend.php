<?php
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
?>
<div class="xpro-counter-wrapper">
		<div class="xpro-counter-wrapper-inner">
			<?php if($settings['show_media_icons']=='yes'){ ?>
				<?php if ( 'icon' === $settings['media_type'] || 'image' === $settings['media_type'] || 'lottie' === $settings['media_type'] ) : ?>
					<div class="xpro-counter-icon-item">
							<?php
							if ( 'icon' === $settings['media_type'] && $settings['icon'] ) {
								Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) );
							}
							if ( 'image' === $settings['media_type'] ) {
								$image_markup = ( ! empty( $settings['image']['id'] ) ) ? wp_get_attachment_image( $settings['image']['id'], $settings['thumbnail_size'] ) : '';
								echo ! empty( $image_markup ) ? $image_markup : '<img src="' . esc_url( $settings['image']['url'] ) . '">';
							}
							if ( 'lottie' === $settings['media_type'] ) {
								?> <div id="xpro-counter-box-lottie"  class="xpro-counter-lottie-animation"></div> 
								<?php } 
							?>
						</div>
				<?php endif; ?>
			<?php } ?>
			<div>
					<?php if ( $settings['badge_text'] ) : ?>
						<div <?php $this->print_render_attribute_string( 'badge_text' ); ?>><?php echo esc_html( $settings['badge_text'] ); ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['value'] ) ) : ?>
						<div class="xpro-counter-item">
							<span class="value"><?php echo esc_html( $settings['value'] ); ?></span>
							<?php if ( $settings['symbol'] ) { ?>
								<span class="symbol"><?php echo esc_html( $settings['symbol'] ); ?></span>
							<?php } ?>
						</div>
					<?php endif; ?>

					<div class="xpro-counter-content">
						<?php
						if ( $settings['title'] ) :
							printf( '<%1$s %2$s>%3$s</%1$s>', tag_escape( $settings['title_tag'] ), $this->get_render_attribute_string( 'title' ), $settings['title'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						endif;
						if ( $settings['description'] ) :
							?>
							<p <?php $this->print_render_attribute_string( 'description' ); ?>><?php echo esc_html( $settings['description'] ); ?></p>
						<?php endif; ?>
				   </div>
		     </div>
	  </div>
</div>
