<?php
    $first_name = ( ! empty( $_POST['first_name'] ) ) ? sanitize_text_field( $_POST['first_name'] ) : '';
    $last_name = ( ! empty( $_POST['last_name'] ) ) ? sanitize_text_field( $_POST['last_name'] ) : '';
    $username = ( ! empty( $_POST['username'] ) ) ? sanitize_text_field( $_POST['username'] ) : '';
    $password = ( ! empty( $_POST['password'] ) ) ? sanitize_text_field( $_POST['password'] ) : '';
    $email = ( ! empty( $_POST['email'] ) ) ? sanitize_email( $_POST['email'] ) : '';
    $biography = ( ! empty( $_POST['biography'] ) ) ? sanitize_textarea_field( $_POST['biography'] ) : '';
    $area_code = ( ! empty( $_POST['area_code'] ) ) ? intval( $_POST['area_code'] ) : '';
    $artform = ( ! empty( $_POST['artform'] ) ) ? sanitize_text_field( $_POST['artform'] ) : '';
    $phone_number = ( ! empty( $_POST['phone_number'] ) ) ? intval( $_POST['phone_number'] ) : '';

    function countDigit($n) 
        { 
            $count = 0; 
            while ($n != 0)  
            { 
                $n = round($n / 10); 
                ++$count; 
            } 
            return $count; 
        } 
        
        // Driver code 
        $n = 3452;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reg_errors = new WP_Error();
    if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
        $reg_errors->add( 'first_name_error', sprintf('<strong>%s</strong>: %s',__( 'Error', 'qmk' ),__( 'You must include a first name.', 'qmk' ) ) );
    }
    if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
        $reg_errors->add( 'last_name_error', sprintf('<strong>%s</strong>: %s',__( 'Error', 'qmk' ),__( 'You must include a last name.', 'qmk' ) ) );
    }
    if ( empty( $_POST['area_code'] ) || ! empty( $_POST['area_code'] ) && trim( $_POST['area_code'] ) == '' ) {
        $reg_errors->add( 'area_code_error', sprintf('<strong>%s</strong>: %s',__( 'Error', 'qmk' ),__( 'You must include your area code.', 'qmk' ) ) );
    }
    if ( strlen( $_POST['area_code'] )  < countDigit($n) || strlen( $_POST['area_code'] ) > countDigit($n) ) {
        $reg_errors->add( 'area_code_error', sprintf('<strong>%s</strong>: %s',__( 'Error', 'qmk' ),__( 'Your area code should be ' . countDigit($n) . ' digits long.', 'qmk' ) ) );
    }
    //Check all the fields have been field
    if ( empty( $username ) || empty( $password ) || empty( $area_code ) || empty( $artform ) || empty( $biography ) || empty( $first_name ) || empty( $last_name ) || empty( $email ) ) {
        $reg_errors->add( 'field', sprintf('<strong>%s</strong>: %s',__( 'Error', 'qmk' ),__( 'Make sure you fill all the form fields', 'qmk' ) ) );
    }
    //Check if username already exists
    if ( username_exists( $username ) ) {
        $reg_errors->add( 'user_name', sprintf( '<strong>%s</strong>: %s', __( 'Error', 'qmk' ),__( 'Eish, someone is already using that username here! Try another one.', 'qmk' )) );
    }
    //Check if username provided is valid
    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', sprintf( '<strong>%s</strong>: %s', __( 'Error', 'qmk' ), __( 'Please register a valid username', 'qmk' ) ) );
    }
    //Check if password is not less than 5 characters
    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', sprintf( '<strong>%s</strong>: %s', __( 'Error', 'qmk' ), __( 'Your password must be more than 5 characters long.', 'qmk' ) ) );
    }
    if ( 10 > intval( $phone_number ) && 10 < intval ($phone_number) ) {
        $reg_errors->add( 'phone_number', sprintf( '<strong>%s</strong>: %s', __( 'Error', 'qmk' ), __( 'Your phone number must start with a 0 and 10 numbers long.', 'qmk' ) ) );
    }


    //Check if email is valid
    // if ( ! is_email( $email ) ) {
    //     $reg_errors->add( 'email_invalid', 'Enter a valid email.' );
    // }

    //Check if the email is already registered
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', sprintf(  '<strong>%s</strong>: %s', __( 'Error', 'qmk' ), __( 'Seems like there\'s someone already registered with this email address.', 'qmk' ) ) );
    }

    //Looping through the errors and showing individual errors
    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $error . '<br />';
            echo '</div>';
        }
    }

if ( 1 > count( $reg_errors->get_error_messages() ) ) {
            $userdata = array(
                'user_login' => $username,
                'user_email' => $email,
                'user_pass' => $password,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'description' => $biography,
                'display_name' => $username,
            );
            $user = wp_insert_user( $userdata );
            echo '
            <div class="alert alert-success" role="alert">
                Your registration has been successful. Please click here to <a href="' . esc_url( site_url( 'login' ) ) . '"> login</a>.
            </div>
            ';
            exit;
        }
        
    }

