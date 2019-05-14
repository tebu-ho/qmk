<?php

/**
 * Adding the theme's stylesheets and scripts
 *
 * @since 1.0.0
 */
function add_qmk_theme_scripts()
{
    //styles and fonts
    wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1', 'all' );
    wp_enqueue_style( 'font-awesome', '//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), '4.7', 'all' );
    wp_enqueue_style( 'style', get_stylesheet_uri(), array(), '1.0.0', 'all' );
    
    //Scripts
    wp_enqueue_script( 'jquery-scripts', get_template_directory_uri() . '/js/jquery.js', array(), '1.11.1', true );
    wp_enqueue_script( 'bootstrap-js', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', '', '4.3.1', true );
    wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', '', '3.3.6', true );
    wp_enqueue_script( 'main', get_template_directory_uri() . '/js/main.js', '', '1.0.0', true );
    wp_register_script( 'profile', get_template_directory_uri() . '/js/UserProfile.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'profile' );
    wp_enqueue_script( 'animateHeader', get_template_directory_uri() . '/js/cbpAnimatedHeader.min.js', '', '1.0.0', true );
    wp_localize_script( 'main', 'qmkData', array(
        'root_url' => get_site_url(), 'nonce' => wp_create_nonce('wp_rest')
    ));
    wp_enqueue_media();
}
add_action( 'wp_enqueue_scripts', 'add_qmk_theme_scripts' );

/**
 * Adding features supported by this theme
 *
 * @since 1.0.0
 */
function add_qmk_theme_features()
{
    add_theme_support( 'custom-logo' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background' );
    add_theme_support( 'title-tag' );
    register_nav_menus( 
        array(
            'primary_menu' => 'Primary Menu',
            'login_register_menu' => 'User Menu',
            'footer_menu' => 'Footer Menu',
        )
     );
}
add_action( 'after_setup_theme', 'add_qmk_theme_features' );

/**
 * Redirect subscriber user from admin
 * to front page
 */
function redirect_subscriber_to_homepage()
{
    $qmkCurrentUser = wp_get_current_user();
    if ( count( $qmkCurrentUser->roles) == 1 AND $qmkCurrentUser->roles[0] == 'subscriber' ) {
        wp_redirect( esc_url( site_url( '/' ) ) );
        exit;
    }
}
add_action( 'admin_init', 'redirect_subscriber_to_homepage' );

/**
 * Remove admin bar if
 * User is a subscriber
 */
function remove_admin_bar_for_subscribers()
{
    if ( ! current_user_can( 'manage_options' ) ) {
        show_admin_bar( false );
    }
}
add_action( 'wp_loaded', 'remove_admin_bar_for_subscribers' );

function qmk_adjust_queries($query)
{
    $query->set( 'posts_per_page', 2 );
}
add_action( 'pre_get_posts', 'qmk_adjust_queries' );

/**
 * Change logo url on the default login page
 * to point qmk home page
 */
function qmk_header_url()
{
    return esc_url( site_url( '/' ) );
}
add_filter( 'login_headerurl', 'qmk_header_url' );

/**
 * Load custom style to the login page
 */
function qmk_login_scripts()
{
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'login_enqueue_scripts', 'qmk_login_scripts' );

/**
 * Load custom style to the login page
 */
function qmk_login_page_title()
{
    return 'Register Your Profile - ' . get_bloginfo( 'name' );
}
add_filter( 'login_title', 'qmk_login_page_title' );

/**
 * Change logo url on the default login page
 * to point qmk home page
 */
function qmk_header_title()
{
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', 'qmk_header_title' );

/**
 * Adding customization options for QMK
 * @since 1.0.0
 */
function add_qmk_customization( $wp_customize )
{
      /** 
     * Creating a section for the footer that can be customised
     */
    $wp_customize->add_section(
        'call_to_action_section', array(
            'title' => __( 'Call to Action', 'qmk' )
        )
    );

/** 
 * Settings for customizing the copyright
 */
    $wp_customize->add_setting(
        'call_to_action', array(
            'default'   => '',
            'transport' => 'refresh',
        )  
    );

    $wp_customize->add_control(
        'call_to_action_control', array(
            'label'    => __( 'Text', 'qmk' ),
            'section'  => 'call_to_action_section',
            'settings' => 'call_to_action',
            'type'     => 'text',
        )
        );

        /** 
         * Settings for customizing the copyright
         */
            $wp_customize->add_setting(
                'cta_btn', array(
                    'default'   => '',
                    'transport' => 'refresh',
                )  
            );
        
            $wp_customize->add_control(
                'cta_btn_control', array(
                    'label'    => __( 'Button Text', 'qmk' ),
                    'section'  => 'call_to_action_section',
                    'settings' => 'cta_btn',
                    'type'     => 'text',
                )
                );
}
 add_action( 'customize_register', 'add_qmk_customization' );

 /**
  * Call to action
  */
function call_to_action()
{ 
    if ( ! is_user_logged_in() ) {
    ?>
<section class="cta-section">
    <div class="container">
        <div class="col-md-12 cl-xs-6 cta">
            <span  class="push-col-sm-12" style="font-family: Hobo Std;"><?php echo get_theme_mod('call_to_action', 'Call to action goes here'); ?><br></span>
            <span class="cta-btn"><a href="<?php echo esc_url( site_url( '/register/' ) ); ?>" class="page-scroll btn btn-sm" style="position:relative; font-family: Hobo Std;"><?php echo get_theme_mod('cta_btn', 'Place text here'); ?></a></span>
        </div>
	</div>
</section>
<?php } }

//A new registration form
add_action( 'register_form', 'qmk_register_form' );
function qmk_register_form() 
{
    $validate_user   = new QMK_User();
    $first_name      = $validate_user->validate_first_name();
    $last_name       = $validate_user->validate_last_name();
    $username        = $validate_user->validate_username();
    $password        = $validate_user->validate_password();
    $email           = $validate_user->validate_email();
    $biography       = $validate_user->validate_biography();
    $area_code       = $validate_user->validate_area_code();
    $artform         = $validate_user->validate_artform();
    $phone_number    = $validate_user->validate_phone_number();
    ?>
    <div class="form-row form-group">
        <div class="col">
            <label for="first_name"><?php _e( 'First Name', 'qmk' ) ?> <strong>*</strong></label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo esc_attr(  $first_name  ); ?>" size="25" /></label>
        </div>
        <div class="col">
            <label for="last_name"><?php _e( 'Last Name', 'qmk' ) ?> <strong>*</strong></label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo esc_attr(  $last_name  ); ?>" size="25" /></label>
        </div>
    </div>
    <div class="form-group">
        <label for="username">Username <strong>*</strong></label>
        <input type="text" class="form-control" name="username" value="<?php echo ( isset( $_POST['username'] ) ? $username : null ); ?>">
    </div>
    <div class="form-group">
        <label for="password">Password <strong>*</strong></label>
        <input type="password" class="form-control" name="password" value="<?php echo ( isset( $_POST['password'] ) ? $password : null ); ?>">
    </div>
    <div class="form-group">
        <label for="email">Email <strong>*</strong></label>
        <input type="email" class="form-control" name="email" value="<?php echo ( isset( $_POST['email'] ) ? $email : null ); ?>">
    </div>
    <div class="form-group">
        <label for="phone_number">Phone Number <strong>*</strong></label>
        <input type="tel" class="form-control" name="phone_number" min="10" maxlength="10" value="<?php echo ( isset( $_POST['phone_number'] ) ? $phone_number : null ); ?>">
    </div>
    <div class="form-group">
        <label for="biography">Biography <strong>*</strong></label>
        <textarea class="form-control" name="biography" maxlength="140"><?php echo ( isset( $_POST['biography'] ) ? $biography : null ); ?></textarea>
    </div>
    <div class="form-row form-group">
        <div class="col">
            <label for="area_code"><?php _e( 'Area Code', 'qmk' ) ?> <strong>*</strong></label>
            <input type="number" name="area_code" id="area_code" class="form-control" value="<?php echo esc_attr(  $area_code  ); ?>" size="25" />
        </div>
        <div class="col">
            <label for="artform">What do you do? <strong>*</strong></label>
            <input class="form-control" type="text" name="artform" value="<?php echo ( isset( $_POST['artform'] ) ? $artform : null ); ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <input type="submit" class="btn btn-primary mb-2" name="submit" value="Register" />
        </div>
        <div class="col">
            <a href="<?php echo esc_url( site_url( 'login' ) ); ?>" class="login-link" title="Login">Already registered? Login</a>
        </div>
    </div>
    <?php
}

/**
 * Perform automatic login.
 */
function login_user() {
    global $login_error;
    global $email_error;
    if (isset($_POST['login'])) {
        $login_data = array();
        $login_data['user_login']    = sanitize_email($_POST['email']);
        $login_data['user_password'] = esc_attr($_POST['password']);

    $user = wp_signon( $login_data );
    
    if ( ! email_exists( sanitize_email($_POST['email']) ) ) {
        $email_error = 'Email is incorrect';
    }
    if ( is_wp_error( $user ) ) {
        $login_error = $user->get_error_message();
    }else {    
        wp_clear_auth_cookie();
        do_action('wp_login', $user->ID);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        $redirect_to = esc_url( site_url( 'profile' ) );
        wp_safe_redirect($redirect_to);
        exit;
    }
}
}
 
// Run before the headers and cookies are sent.
add_action( 'after_setup_theme', 'login_user' );


//Save user meta on registration.
add_action( 'user_register', 'qmk_user_register' );
function qmk_user_register( $user_id ) {
    if ( ! empty( $_POST['area_code'] ) ) {
        update_user_meta( $user_id, 'area_code', intval( $_POST['area_code'] ) );
    }
    if ( ! empty( $_POST['artform'] ) ) {
        update_user_meta( $user_id, 'artform', sanitize_text_field( $_POST['artform'] ) );
    }
    if ( ! empty( $_POST['profile_image'] ) ) {
        update_user_meta( $user_id, 'profile_image', sanitize_text_field( $_POST['profile_image'] ) );
    } 
}

class QMK_User{
    public function validate_first_name()
    {
        if ( ! empty( $_POST['first_name'] ) ) {
           return sanitize_text_field( $_POST['first_name'] );
        } else {
            return '';
        }
    }
    public function validate_last_name()
    {
        if ( ! empty( $_POST['last_name'] ) ) {
           return sanitize_text_field( $_POST['last_name'] );
        } else {
            return '';
        }
    }
    public function validate_username()
    {
        if ( ! empty( $_POST['username'] ) ) {
           return sanitize_text_field( $_POST['username'] );
        } else {
            return '';
        }
    }
    public function validate_password()
    {
        if ( ! empty( $_POST['password'] ) ) {
           return sanitize_text_field( $_POST['password'] );
        } else {
            return '';
        }
    }
    public function validate_email()
    {
        if ( ! empty( $_POST['email'] ) ) {
           return sanitize_email( $_POST['email'] );
        } else {
            return '';
        }
    }
    public function validate_biography()
    {
        if ( ! empty( $_POST['biography'] ) ) {
           return sanitize_textarea_field( $_POST['biography'] );
        } else {
            return '';
        }
    }
    public function validate_area_code()
    {
        if ( ! empty( $_POST['area_code'] ) ) {
            return intval( $_POST['area_code'] );
        } else {
            return '';
        }
    }
    public function validate_artform()
    {
        if ( ! empty( $_POST['artform'] ) ) {
           return sanitize_text_field( $_POST['artform'] );
        } else {
            return '';
        }
    }
    public function validate_profile_image()
    {
        if ( ! empty( $_POST['profile_image'] ) ) {
           return sanitize_text_field( $_POST['profile_image'] );
        } else {
            return '';
        }
    }
    public function validate_image()
    {
        if ( ! empty( $_POST['image'] ) ) {
           return sanitize_text_field( $_POST['image'] );
        } else {
            return '';
        }
    }
    public function validate_image1()
    {
        if ( ! empty( $_POST['image1'] ) ) {
           return sanitize_text_field( $_POST['image1'] );
        } else {
            return '';
        }
    }
    public function validate_facebook()
    {
        if ( ! empty( $_POST['facebook'] ) ) {
           return esc_url_raw( $_POST['facebook'] );
        } else {
            return '';
        }
    }
    public function validate_instagram()
    {
        if ( ! empty( $_POST['instagram'] ) ) {
           return esc_url_raw( $_POST['instagram'] );
        } else {
            return '';
        }
    }
    public function validate_twitter()
    {
        if ( ! empty( $_POST['twitter'] ) ) {
           return esc_url_raw( $_POST['twitter'] );
        } else {
            return '';
        }
    }
    public function validate_youtube()
    {
        if ( ! empty( $_POST['youtube'] ) ) {
           return esc_url_raw( $_POST['youtube'] );
        } else {
            return '';
        }
    }
    public function validate_soundcloud()
    {
        if ( ! empty( $_POST['soundcloud'] ) ) {
           return esc_url_raw( $_POST['soundcloud'] );
        } else {
            return '';
        }
    }
    public function validate_website()
    {
        if ( ! empty( $_POST['website'] ) ) {
           return esc_url_raw( $_POST['website'] );
        } else {
            return '';
        }
    }
    public function validate_behance()
    {
        if ( ! empty( $_POST['behance'] ) ) {
           return esc_url_raw( $_POST['behance'] );
        } else {
            return '';
        }
    }
    public function validate_phone_number()
    {
        if ( ! empty( $_POST['phone_number'] ) ) {
            return intval( $_POST['phone_number'] );
        } else {
            return '';
        }
    }
}
global $user_id;
function update_user()
    {
        $user_id = get_current_user_id();
        $validate_user   = new QMK_User();
        $first_name      = $validate_user->validate_first_name();
        $last_name       = $validate_user->validate_last_name();
        $username        = $validate_user->validate_username();
        $password        = $validate_user->validate_password();
        $email           = $validate_user->validate_email();
        $biography       = $validate_user->validate_biography();
        $area_code       = $validate_user->validate_area_code();
        $artform         = $validate_user->validate_artform();
        $profile_image   = $validate_user->validate_profile_image();
        $image           = $validate_user->validate_image();
        $image1          = $validate_user->validate_image1();
        $facebook        = $validate_user->validate_facebook();
        $instagram       = $validate_user->validate_instagram();
        $twitter         = $validate_user->validate_twitter();
        $youtube         = $validate_user->validate_youtube();
        $soundcloud      = $validate_user->validate_soundcloud();
        $website         = $validate_user->validate_website();
        $behance         = $validate_user->validate_behance();
        $phone_number    = $validate_user->validate_phone_number();

        if (isset($_POST['update'])) {
            $username             = $username;
            $last_name            = $last_name;
            $first_name           = $first_name;
            $password             = $password;
            $email                = $email;
            $biography            = $biography;
            $area_code            = $area_code;
            $artform              = $artform;
            $profile_image        = $profile_image;
            $image                = $image;
            $image1               = $image1;
            $facebook             = $facebook;
            $instagram            = $instagram;
            $twitter              = $twitter;
            $youtube              = $youtube;
            $soundcloud           = $soundcloud;
            $behance              = $behance;
            $website              = $website;
            $phone_number         = $phone_number;

            $user_id = wp_update_user(
                array( 
                    'ID' => $user_id,
                    'user_pass'   => $password,
                    'nickname'    => $username,
                    'first_name'  => $first_name,
                    'last_name'   => $last_name,
                    'description' => $biography,
                    'user_email'  => $email,

                )
            );
            if ( ! empty( $area_code && wp_get_current_user() ) ) {
                update_user_meta( $user_id, 'area_code', intval( $_POST['area_code'] ) );
            }
            if ( ! empty( $artform ) ) {
                update_user_meta( $user_id, 'artform', sanitize_text_field( $_POST['artform'] ) );
            } 
            if ( ! empty( $image ) ) {
                update_user_meta( $user_id, 'image', sanitize_text_field( $_POST['image'] ) );
            } 
            if ( ! empty( $profile_image ) ) {
                update_user_meta( $user_id, 'profile_image', sanitize_text_field( $_POST['profile_image'] ) );
            } 
            if ( ! empty( $image1 ) ) {
                update_user_meta( $user_id, 'image1', sanitize_text_field( $_POST['image1'] ) );
            }
            if ( ! empty( $phone_number ) ) {
                update_user_meta( $user_id, 'phone_number', intval( $_POST['phone_number'] ) );
            }
            echo $phone_number;
            /**
             * Adding/updating user social media links
             * 
             * Whether empty or not
             */ 
            update_user_meta( $user_id, 'facebook', esc_url_raw( $_POST['facebook'] ) );
            update_user_meta( $user_id, 'instagram', esc_url_raw( $_POST['instagram'] ) );
            update_user_meta( $user_id, 'twitter', esc_url_raw( $_POST['twitter'] ) );
            update_user_meta( $user_id, 'youtube', esc_url_raw( $_POST['youtube'] ) );
            update_user_meta( $user_id, 'soundcloud', esc_url_raw( $_POST['soundcloud'] ) );
            update_user_meta( $user_id, 'behance', esc_url_raw( $_POST['behance'] ) );
            update_user_meta( $user_id, 'website', esc_url_raw( $_POST['website'] ) );

            if ( is_wp_error( $user_id ) ) {
                $login_error = $user_id->get_error_message();
            } else {    
                $success = '<div class="alert alert-success" role="alert">Your profile has been updated successfully.</div>';
                echo $success;
            } 
        }
    }
    function show_social_icons()
    {
        $args = array(
            'number' => 1,
            'include' => get_current_user_id(),
            'key' => 'ID',
            array(
                'meta_key' => 'instagram'
            ),
            array(
                'meta_key' => 'facebook'
            ),
            array(
                'meta_key' => 'twitter'
            ),
            array(
                'meta_key' => 'youtube'
            ),
            array(
                'meta_key' => 'soundcloud'
            ),
            array(
                'meta_key' => 'behance'
            ),
            array(
                'meta_key' => 'website'
            ),
        );
        
        // The Query
        $user_query = new WP_User_Query( $args );
        
        // User Loop
        if ( ! empty( $user_query->get_results() ) ) {
            foreach ( $user_query->get_results() as $user ) {
                if (!empty($user->facebook)) {
                    echo '<li><a href="'. $user->facebook .'"><i class="fa fa-facebook"></i></a></li>';
                } 
                if (!empty($user->instagram)) {
                    echo '<li><a href="'. $user->instagram .'"><i class="fa fa-instagram"></i></a></li>';
                }
                
                if (!empty($user->twitter)) {
                    echo '<li><a href="'. $user->twitter .'"><i class="fa fa-twitter"></i></a></li>';
                }
                if (!empty($user->youtube)) {
                    echo '<li><a href="'. $user->youtube .'"><i class="fa fa-youtube"></i></a></li>';
                }
                if (!empty($user->soundcloud)) {
                    echo '<li><a href="'. $user->soundcloud .'"><i class="fa fa-soundcloud"></i></a></li>';
                }
                if (!empty($user->behance)) {
                    echo '<li><a href="'. $user->behance .'"><i class="fa fa-behance"></i></a></li>';
                }
                if (!empty($user->website)) {
                    echo '<li><a href="'. $user->website .'"><i class="fa fa-globe"></i></a></li>';
                }
        }
    }
    }
function filter_media( $query ) {
    // admins get to see everything
    if ( current_user_can( 'upload_files' ) )
        $query['subscriber'] = get_current_user_id();
    return $query;
}
function qmk_filter_media($query) {
    // admins get to see everything
    if (!current_user_can('manage_options'))
        $query['author'] = get_current_user_id();
     return $query;
 }
 add_filter('ajax_query_attachments_args', 'qmk_filter_media');

 function slug_get_user_meta_cb( $user, $field_name, $request ) {
    return get_user_meta( $user[ 'id' ] );
   }
 add_action( 'rest_api_init', 'qmk_rest_meta_fields_query');
 function qmk_rest_meta_fields_query() {
    register_rest_field( 'user',
     'custom_fields',
     array(
     'get_callback' => 'slug_get_user_meta_cb',
     'schema' => null,
     )
     );
    }
    add_filter( 'rest_user_query', 'prefix_remove_has_published_posts_from_wp_api_user_query', 10, 2 );
/**
 * Removes `has_published_posts` from the query args so even users who have not
 * published content are returned by the request.
 *
 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
 *
 * @param array           $prepared_args Array of arguments for WP_User_Query.
 * @param WP_REST_Request $request       The current request.
 *
 * @return array
 */
function prefix_remove_has_published_posts_from_wp_api_user_query( $prepared_args, $request ) {
	unset( $prepared_args['has_published_posts'] );

	return $prepared_args;
}
if ( is_user_logged_in() && isset( $_GET['delete'] ) ) {
	add_action( 'init', 'remove_logged_in_user' );
}

function remove_logged_in_user() {
	// Verify that the user intended to take this action.
	if ( ! wp_verify_nonce( 'delete_account' ) ) {
		return;
	}

	require_once(ABSPATH.'wp-admin/includes/user.php' );
	$current_user = wp_get_current_user();
	wp_delete_user( $current_user->ID );
}
