<?php

add_shortcode( 'gallery', 'instant_articles_shortcode_handler_gallery' );

/**
 * Gallery Shortcode
 * @param  array     $atts       Array of attributes passed to shortcode.
 * @return string                The generated content.
*/
function instant_articles_shortcode_handler_gallery( $atts ) {
		// Get the IDs
		$ids = explode( ',', $atts['ids'] );

		ob_start(); ?>
		<figure class="op-slideshow">
			<?php foreach ( $ids as $id ) : ?>
				<?php $image = wp_get_attachment_image_src( $id, 'large' ); ?>
				<?php $url   = ( $image[0] ); ?>
				<figure>
					<img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( get_the_title( $id ) ); ?>">
					<?php $caption = get_post_field( 'post_content', $id ); ?>
					<?php if ( ! empty( $caption ) ) : ?>
						<figcaption><?php echo esc_html( $caption ); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endforeach; ?>
		</figure>
		<?php return ob_get_clean();
}

add_shortcode( 'caption', 'instant_articles_shortcode_handler_caption' );
add_shortcode( 'wp_caption', 'instant_articles_shortcode_handler_caption' );

/**
 * Caption/WP-Caption Shortcode
 * @param  array     $atts       Array of attributes passed to shortcode.
 * @param  string    $content    The content passed to the shortcode.
 * @return string                The generated content.
*/
function instant_articles_shortcode_handler_caption( $atts, $content = "" ) {

  	$doc = new DOMDocument();
    $doc->loadHTML( $content );
    $imageTags = $doc->getElementsByTagName('img');
    $img_src = $imageTags[0]->getAttribute('src');

	ob_start(); ?>
		<figure>
  			<img src="<?php echo esc_url ( $img_src ); ?>" />
  		<figcaption><?php echo $content ; ?></figcaption>
		</figure>
		
	<?php return ob_get_clean();
}

add_shortcode( 'audio', 'instant_articles_shortcode_handler_audio' );

/**
 * Audio Shortcode
 * @param  array     $atts       Array of attributes passed to shortcode.
 * @return string                The generated content.
*/
function instant_articles_shortcode_handler_audio( $atts ) {	

	if ( $atts['mp3'] ) {
		$audio_src =  $atts['mp3'];
	} else if ( $atts['src'] ) {
		$audio_src =  $atts['src'];
	} else if ( $atts['ogg'] ) {
		$audio_src =  $atts['ogg'];
	} else if ( $atts['wav'] ) {
		$audio_src =  $atts['wav'];
	} else {
		$audio_src = null;
	}

	//TODO: $set_autoplay = $atts['autoplay'] == 'true' ? ' autoplay' : '';

	if ( $audio_src ) :
		$file_url = array_reverse( explode( '/', $audio_src ) ) ;

		ob_start(); ?>

		<figure>
			<audio title="<?php echo esc_html( $file_url[0] ); ?>">
				<source src="<?php echo esc_url( $audio_src ); ?>">
			</audio>
		</figure>
			
		<?php return ob_get_clean();
	endif;

}



