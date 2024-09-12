function total_child_enqueue_parent_theme_style() {
	
	if ( ! defined( 'WPEX_THEME_STYLE_HANDLE' ) ) {
		return;
	}
	
	// De-register main stylesheet
    wp_dequeue_style( WPEX_THEME_STYLE_HANDLE );
    wp_deregister_style( WPEX_THEME_STYLE_HANDLE );

    // Get child theme version.
    $theme = wp_get_theme();
    $version = $theme->get( 'Version' );

    // Re-add child theme with currect version number
    wp_enqueue_style( WPEX_THEME_STYLE_HANDLE, get_stylesheet_uri(), array(), $version );

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme = wp_get_theme( 'Total' );
	$version = $theme->get( 'Version' );

	// Load the parent stylesheet
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), $version );
}
add_action( 'wp_enqueue_scripts', 'total_child_enqueue_parent_theme_style' );

// Insert mega menus into the main menu.
add_filter( 'wp_nav_menu_items', function( $items, $args ) {

    // About Us dropdown menu
    $about_us_dropdown = '<ul class="sub-menu">';
        $about_us_dropdown .= '<div class="nhce-megamenu__content">';
            $about_us_dropdown .= '<div class="nhce-megamenu__heading">About<br/>Us</div>';
            $about_us_dropdown .= '<div class="nhce-megamenu__links">';
                $about_us_dropdown .= '<div><a class="local-scroll-link" href="/about-us/#history">History</a></div>';
                $about_us_dropdown .= '<div><a class="local-scroll-link" href="/about-us/#our-community">Our Community</a></div>';
                $about_us_dropdown .= '<div><a class="local-scroll-link" href="/about-us/#mission">Our Mission, Vision, Values & Commitment</a></div>';
                $about_us_dropdown .= '<div><a class="local-scroll-link" href="/about-us/#our-board">Our Board & Staff</a></div>';
	            $about_us_dropdown .= '<div><a class="local-scroll-link" href="/careers/">Careers</a></div>';
            $about_us_dropdown .= '</div>';
        $about_us_dropdown .= '</div>';
    $about_us_dropdown .= '</ul>';

    // Add current-menu-item class to About Us link
    $current_class_about = '';
    if ( is_page( 'about-us' ) ) {
        $current_class_about = ' current-menu-item';
    }
    
    $about_us = '<li class="menu-item megamenu nhce-megamenu local-scroll-link' . $current_class_about . '"><a href="' . esc_url( home_url( '/about-us/' ) ) . '"><span class="link-inner">About Us</span></a>' . $about_us_dropdown . '</li>';

    // Grants dropdown menu
    $grants_dropdown = '<ul class="sub-menu">';
        $grants_dropdown .= '<div class="nhce-megamenu__content">';
            $grants_dropdown .= '<div class="nhce-megamenu__heading">Grants</div>';
            $grants_dropdown .= '<div class="nhce-megamenu__links">';
                $grants_dropdown .= '<div><a class="local-scroll-link" href="/grants/#overview">Overview</a></div>';
                $grants_dropdown .= '<div><a class="local-scroll-link" href="/grants/#eligibility">Eligibility</a></div>';
                $grants_dropdown .= '<div><a class="local-scroll-link" href="/grants/#application-process">Application Process</a></div>';
                $grants_dropdown .= '<div><a class="local-scroll-link" href="/grants/#funding-options">Funding Options</a></div>';
            $grants_dropdown .= '</div>';
        $grants_dropdown .= '</div>';
    $grants_dropdown .= '</ul>';

    // Add current-menu-item class to Grants link
    $current_class_grants = '';
    if ( is_page( 'grants' ) ) {
        $current_class_grants = ' current-menu-item';
    }
    
    $grants = '<li class="menu-item megamenu nhce-megamenu local-scroll-link' . $current_class_grants . '"><a href="' . esc_url( home_url( '/grants/' ) ) . '"><span class="link-inner">Grants</span></a>' . $grants_dropdown . '</li>';

    // Append both mega menus before existing menu items
    $items = $about_us . $grants . $items;

    return $items;
}, 11, 2 );