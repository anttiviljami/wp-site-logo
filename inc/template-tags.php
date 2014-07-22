<?php
/**
 * Template tags for using site logos.
 *
 * @package Site_Logo
 */

/**
 * Retrieve the site logo URL or ID (URL by default). Pass in the string 'id' for ID.
 *
 * @uses get_option()
 * @uses esc_url_raw()
 * @uses set_url_scheme()
 * @return mixed The URL or ID of our site logo, false if not set
 * @since 1.0
 */
function get_site_logo( $show = 'url' ) {
	// Bail quietly if the theme hasn't declared support.
	if ( ! current_theme_supports( 'site-logo' ) ) {
		return;
	}

	$logo = get_option( 'site_logo' );

	// Return false if no logo is set
	if ( ! isset( $logo['id'] ) || 0 == $logo['id'] ) {
		return false;
	}

	// Return the ID if specified, otherwise return the URL by default
	if ( 'id' == $show ) {
		return $logo['id'];
	} else {
		return esc_url_raw( set_url_scheme( $logo['url'] ) );
	}
}

/**
 * Output an <img> tag of the site logo, at the size specified
 * in the theme's add_theme_support() declaration.
 *
 * @uses current_theme_supports()
 * @uses get_option()
 * @uses site_logo_theme_size()
 * @uses site_logo_is_customize_preview()
 * @uses esc_url()
 * @uses home_url()
 * @uses esc_attr()
 * @uses wp_get_attachment_image()
 * @since 1.0
 */
function the_site_logo() {
	// Bail quietly if the theme hasn't declared support.
	if ( ! current_theme_supports( 'site-logo' ) ) {
		return;
	}

	$logo = get_option( 'site_logo' );
	$size = site_logo_theme_size();

	// Leave placeholder if no logo is currently set.
	if ( ! isset( $logo['id'] ) || 0 == $logo['id'] ) {
		echo '<img class="site-logo" data-size="' . $size . '" style="display:none;" />';
		return;
	}

	// We have a logo. Logo is go.
	printf( '<a href="%1$s" rel="home">%2$s</a>',
		esc_url( home_url( '/' ) ),
		wp_get_attachment_image(
			$logo['id'],
			$size,
			false,
			array(
				'class'     => "site-logo attachment-$size",
				'data-size' => $size,
			)
		)
	);
}
