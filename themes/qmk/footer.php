<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'footer_menu',
                        )
                    );
                ?>
            </div>
        </div>
    </div>
    <div class="site-info col-md-12">
		<span class="site-title">
            <small><?php echo bloginfo( 'name' ); ?> &copy; <?php echo date( 'Y' ); ?></small>
        </span>

	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
