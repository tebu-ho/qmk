<?php 
    if ( is_user_logged_in()) {
        wp_redirect( esc_url( site_url( '/' ) ) );
    }
    get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light md-5 login-register">
                <?php
                    if ( have_posts() ):
                        while (have_posts() ):
                            the_post();                       
                            $email = ( ! empty( $_POST['email'] ) ) ? sanitize_email( $_POST['email'] ) : '';
                            $password = ( ! empty( $_POST['password'] ) ) ? sanitize_text_field( $_POST['password'] ) : '';
                ?>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <?php echo login_user(); ?>
                    <div class="form-group">
                        <label for="email">Email <strong>*</strong></label>
                        <input type="email" autocomplete="email" class="form-control <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" name="email" value="<?php echo ( isset( $_POST['email'] ) ? $email : null ); ?>">
                        <span class="invalid-feedback"><?php echo $email_error; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password <strong>*</strong></label>
                        <input type="password" autocomplete="password" class="form-control <?php echo (!empty($login_error)) ? 'is-invalid' : ''; ?>" name="password" value="<?php echo ( isset( $_POST['password'] ) ? $password : null ); ?>">
                        <span class="invalid-feedback"><?php echo $login_error; ?></span>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="submit" class="btn btn-primary mb-2" name="login" value="Login" />
                        </div>
                        <div class="col">
                            <a href="<?php echo esc_url( site_url( 'register' ) ); ?>" class="login-link" title="Register">Don't have an account? Register</a>
                        </div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <a class="login-link" href="<?php echo wp_lostpassword_url(); ?>" title="Change Password">Change Password</a>
                    </div>
                </form>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
