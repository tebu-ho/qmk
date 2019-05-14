<?php
    /**
     * Plugin Name: QMK User Registration Form
     * Description: Register new users with custom registration fields
     * Version: 1.0.0
     * Author: Tebu
     * Author URI: https://www.creativegemini.co.za
     */

     //Set custom user data
    function set_user_registration_data()
    {
        if ( isset( $_POST['submit'] ) ) {
            validating_user_input(
                $_POST['username'],
                $_POST['password'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['biography'],
                $_POST['email'],
                $_POST['area_code'],
                $_POST['artform']
            );

            //Sanitize user data
            global $username, $password, $area_code, $artform, $biography, $first_name, $last_name, $email;
            $username = sanitize_user( $_POST['username'] );
            $password = esc_attr( $_POST['password'] );
            $area_code = intval( $_POST['area_code'] );
            $artform = sanitize_text_field( $_POST['artform'] );
            $biography = esc_textarea( $_POST['biography'] );
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
            $email = sanitize_email( $_POST['email'] );

            /**
             * Call complete_registration fumction to create the user
             * only when no WP_Error is not found
             */
            complete_user_registration(
                $username,
                $password,
                $area_code,
                $artform,
                $biography,
                $first_name,
                $last_name,
                $email
            );
            qmk_registration_form(
                $username,
                $password,
                $area_code,
                $artform,
                $biography,
                $first_name,
                $last_name,
                $email
            );
        }
    }

    function qmk_registration_form( $username, $password, $area_code, $artform, $biography, $first_name, $last_name, $email )
    {
        echo '
        <style>
            div {margin-bottom: 2px}
            input {margin-bottom: 4px}
        </style>';

        echo '
        <form action=" '. $_SERVER['REQUEST_URI'] . '" method="post">
            <div class="form-row">
                <div class="col">
                    <label for="first_name">First Name <strong>*</strong></label>
                    <input type="text" class="form-control" name="first_name" value="' . ( isset( $_POST['first_name'] ) ? $first_name : null ) . '">
                </div>

                <div class="col">
                    <label for="last_name">Last Name <strong>*</strong></label>
                    <input type="text" class="form-control" name="last_name" value="' . ( isset( $_POST['last_name'] ) ? $last_name : null ) . '">
                </div>
            </div>
            <div class="form-group">
                <label for="username">Username<strong>*</strong></label>
                <input type="text" class="form-control" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
            </div>

            <div class="form-group">
                <label for="password">Password <strong>*</strong></label>
                <input type="password" class="form-control" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
            </div>

            <div class="form-group">
                <label for="email">Email <strong>*</strong></label>
                <input type="email" class="form-control" name="email" value="' . ( isset( $_POST['email'] ) ? $email : null ) . '">
            </div>

            <div class="form-group">
                <label for="biography">Biography <strong>*</strong></label>
                <textarea class="form-control" name="biography">' . ( isset( $_POST['biography'] ) ? $biography : null ) . '</textarea>
            </div>
            <div class="form-row form-group">
                <div class="col">
                    <label for="areacode">Area Code <strong>*</strong></label>
                    <input class="form-control" type="number" name="area_code" value="' . ( isset( $_POST['area_code'] ) ? $area_code : null ) . '">
                </div>

                <div class="col">
                    <label for="artform">Artform<strong>*</strong></label></label>
                    <input class="form-control" type="text" name="artform" value="' . ( isset( $_POST['artform'] ) ? $artform : null ) . '">
                </div>
            </div>

            <input type="submit" class="btn btn-primary mb-2" name="submit" value="Register" />
        </form>';
    }

    //Validating and sanitizing user input
    function validating_user_input( $username, $password, $area_code, $artform, $biography, $first_name, $last_name, $email )
    {
        //Counter for area code length
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

        global $reg_errors;
        $reg_errors = new WP_Error();

        //Check all the fields have been field
        if ( empty( $username ) || empty( $password ) || empty( $area_code ) || empty( $artform ) || empty( $biography ) || empty( $first_name ) || empty( $last_name ) || empty( $email ) ) {
            $reg_errors->add( 'field', 'Make sure you fill all the form fields' );
        }

        //Check if username already exists
        if ( username_exists( $username ) ) {
            $reg_errors->add( 'user_name', 'Eish, someone is already using that username here! Try another one.' );
        }

        //Check if username provided is valid
        if ( ! validate_username( $username ) ) {
            $reg_errors->add( 'username_invalid', 'Please register a valid username' );
        }

        //Check if password is not less than 5 characters
        if ( 5 > strlen( $password ) ) {
            $reg_errors->add( 'password', 'Your password must be more than 5 characters long.' );
        }

        //Check if email is valid
        if ( ! is_email( $email ) ) {
            $reg_errors->add( 'email_invalid', 'Enter a valid email.' );
        }

        //Check if the email is already registered
        if ( email_exists( $email ) ) {
            $reg_errors->add( 'email', 'Seems like there\'s someone already registered with this email address.' );
        }

        //Check if area code is not less than and not more than 4 characters long
        if ( trim( $_POST['area_code'] )  < countDigit($n) && trim( $_POST['area_code'] ) > countDigit($n) ) {
            $Reg_errors->add( 'area_code_error',  'Your area code should be ' . countDigit($n) . ' digits long.' );
        }

        //Loop through the errors and show individual error
        if ( is_wp_error( $reg_errors ) ) {
            foreach ( $reg_errors->get_error_messages() as $error ) {
                echo '<div class="alert alert-danger" role="alert">';
                echo '<strong>Error: </strong>';
                echo $error . '<br />';
                echo '</div>';
            }
        }
    }

    //User registration
    function complete_user_registration()
    {
        global $reg_errors, $username, $password, $area_code, $artform, $biography, $first_name, $last_name, $email;
        if ( 1 > count( $reg_errors->get_error_messages() ) ) {
            $userdata = array(
                'user_login' => $username,
                'user_email' => $email,
                'user_pass' => $password,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'description' => $biography,
            );
            $user = wp_insert_user( $userdata );
            echo 'Nice, your registration is complete. Click <a href="' . esc_url( site_url() ) . '/wp_login.php">here to login</a>.';
        }
    }

    
    //Register a new shortcode [qmk_register_form]
    function register_qmk_shortcode()
    {
        ob_start();
        set_user_registration_data();
        return ob_get_clean();
    }
    add_shortcode( 'qmk_form', 'register_qmk_shortcode' );