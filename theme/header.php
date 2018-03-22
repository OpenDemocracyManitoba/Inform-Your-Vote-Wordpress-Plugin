
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Election_Data_Theme
 * @since Election_Data_Theme 2.0
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<?php if(Election_data_option::get_option('site_image')):?>
	<meta property="og:image" content=<?php echo wp_get_attachment_image_src( Election_data_option::get_option('site_image'))[0];?>>
<?php endif;?>

<?php if(Election_Data_Option::get_option('site_title')):?>
	<meta property="og:title" content="<?= Election_Data_Option::get_option('site_title');?>" />
<?php endif;?>

<?php if(Election_Data_Option::get_option('site_description')): ?>
	<meta property="og:description" content="<?= Election_Data_Option::get_option('site_description');?>" />
	<meta name="description" content="<?= Election_Data_Option::get_option('site_description');?>" />
<?php endif; ?>

<title><?php

/*
* Print the <title> tag based on what is being viewed.
*/
global $page, $paged;

wp_title( '|', true, 'right' );

// Add the blog name.
bloginfo( 'name' );

// Add the blog description for the home/front page.
$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description && ( is_home() || is_front_page() ) )
echo " | $site_description";

// Add a page number if necessary:
if ( $paged >= 2 || $page >= 2 )
echo ' | ' . sprintf( __( 'Page %s', 'election_data_theme' ), max( $paged, $page ) );

?></title>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
		<!-- Heng start -->
		<div class="head-top">
		<header id="masthead" class="site-header" role="banner">
		<!-- Different page using different image -->
			<?php 
			$multiple_images = is_tax( $taxonomy = 'ed_candidates_party' ) || is_tax( $taxonomy = 'ed_candidates_constituency' ) || is_singular($post_type = 'ed_candidates') || is_page( 'about-us' );
			if ($multiple_images) {
				echo '<style type="text/css">.head-top{background: url(/wp-content/themes/ElectionData/images/imagesself/img-2.png) no-repeat; background-size: 100% 100%;}@media (max-width: 1024px){
body .head-top{background:url(/wp-content/themes/ElectionData/images/imagesself/img-2.png) no-repeat;background-size: auto 100%;}}</style>';
			}
			 else if  ( get_header_image() ) : ?>
				<!-- <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" class="header_image" /> -->
				
				<?php echo '<style type="text/css">.head-top{background:linear-gradient(to bottom,rgb(255, 255, 255),rgba(255, 255, 255, 0)),url("'.get_header_image().'") no-repeat;background-size: 100% 100%;}@media (max-width: 1024px){
body .head-top{background:linear-gradient(to bottom,rgb(255, 255, 255),rgba(255, 255, 255, 0)),url("'.get_header_image().'") no-repeat;background-size: auto 100%;}}</style>';?>
			<?php endif; ?>
				<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php echo $site_description; ?></h2>
		<div class="search-form">
			<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
				<input class="letterinput" type="text" name="s" value="" placeholder="Search" />
				<input class="gobutton" type="submit" value="" />
			</form>
		</div>
		<input id="menu-toggle" type="checkbox">
		<div id="menu-trigger">
		<label for="menu-toggle">
		</label>
		</div>
		
		<?php wp_nav_menu( array( 'walker' => new new_walker(),'theme_location' => 'header-menu', 'container_class' => 'menu hidden_block_when_mobile mobile-menu', 'menu_class' => '' ) ); ?>
		</header><!-- #masthead .site-header -->
		<div class="header-time">
		<p>Election Day is</p>
		<h2><?php echo date('F d,Y',strtotime(Election_Data_Option::get_option( 'election_date' )));?></h2>
		</div>
		</div>
		<!-- Heng end -->
	<div id="container">
        <?php if (!is_front_page()): ?>
        <p class="visible_block_when_mobile"><br><a href="<?php echo home_url( '/' ); ?>">↩ Return Home</a></p>
        <?php endif ?>
		<div id="main" role="main">
