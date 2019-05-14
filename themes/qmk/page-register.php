<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-12 mx-auto">
            <div class="card card-body bg-light md-5 login-register">
                <?php
                    if ( have_posts() ):
                        while (have_posts() ):
                            the_post();
                ?>
                <h2 class="mb-2"><?php the_title(); ?></h2>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <?php get_template_part( './inc/form', 'validate' ); ?>
                    <?php echo qmk_register_form(); ?>
                </form>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
