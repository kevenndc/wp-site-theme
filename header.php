<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset=" <?php bloginfo( 'charset' ); ?> ">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page" class="site">
        <header>
            <div style="background-image: url(<?php echo get_theme_mod( 'set_header_bg' ) ?>)" class="px-3 px-lg-0 py-sm-4 py-lg-0">
                <div class="logo-wrapper text-center px-5 px-lg-0">
                    <?php
                        if ( has_custom_logo() ) {
                            if ( is_home() || is_front_page() ) {
                                ?>
                                <h1 class="site-logo">
                                    <?php the_custom_logo(); ?>
                                </h1>   
                                <?php
                            } else {
                                the_custom_logo();
                            }
                        } else {
                            ?>
                            <h1 class="site-title">
                                <a href="<?php home_url(); ?>" title="<?php bloginfo('name'); ?>">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <nav class="navbar navbar-expand-md navbar-light bg-light" role="navigation">
                <div class="container">
                    <!-- <a class="navbar-brand" href="#">
                        Navbar
                    </a> -->
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'your-theme-slug' ); ?>">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php
                        wp_nav_menu( array(
                            'theme_location'    => 'primary',
                            'depth'             => 2,
                            'container'         => 'div',
                            'container_class'   => 'collapse navbar-collapse justify-content-end',
                            'container_id'      => 'bs-example-navbar-collapse-1',
                            'menu_class'        => 'nav navbar-nav',
                            'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                            'walker'            => new WP_Bootstrap_Navwalker(),
                        ) );
                    ?>
                </div>
            </nav>
        </header>