
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
<link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,700" rel="stylesheet">

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

<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var ajaxurl = '<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>';
</script>

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

$siteurl = home_url();
$candidates_party_header_img = wp_get_attachment_image_src(Election_Data_Option::get_option('candidates_party_header_img'),'full')[0];
$candidates_constituency_header_img = wp_get_attachment_image_src(Election_Data_Option::get_option('candidates_constituency_header_img'),'full')[0];
$candidates_header_img = wp_get_attachment_image_src(Election_Data_Option::get_option('candidates_header_img'),'full')[0];
?></title>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div class="head-top">
		<header id="masthead" class="site-header" role="banner">
			<!-- Different page using different image -->
			<?php
				$default_header_image = get_header_image() ?: $siteurl.'/wp-content/themes/ElectionData/ElectionData-V2/images/imagesself/background.png';

				if(is_tax( $taxonomy = 'ed_candidates_party' ) ){
					$header_image =($candidates_party_header_img!='') ? $candidates_party_header_img : $default_header_image;
				}
				else if(is_tax( $taxonomy = 'ed_candidates_constituency' )){
					$header_image = ($candidates_constituency_header_img!='') ? $candidates_constituency_header_img : $default_header_image;
				}
				else if(is_singular($post_type = 'ed_candidates')){
					$header_image = ($candidates_header_img!='') ? $candidates_header_img : $default_header_image;
				}
				else if (is_page()){
					$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
					$header_image = has_post_thumbnail() ? $full_image_url[0] : $default_header_image;
				}
				else
					$header_image = $default_header_image;

				echo '<style type="text/css">.head-top{background:linear-gradient(to bottom, rgb(225,225,225) 20%, rgba(225,225,225,0) 80%),url("'.$header_image.'") no-repeat;background-size: 100% 100%;}@media (max-width: 1024px){body .head-top{background:url("'.$header_image.'") no-repeat;background-size: auto 100%;}}</style>';
			;?>

			<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php echo $site_description; ?></h2>
			<?php get_search_form(); ?>
			<input id="menu-toggle" type="checkbox">
			<div id="menu-trigger">
			<label for="menu-toggle">
			</label>
			</div>

			<?php wp_nav_menu( array( 'walker' => new new_walker(),'theme_location' => 'header-menu', 'container_class' => 'menu hidden_block_when_mobile mobile-menu', 'menu_class' => '' ) ); ?>
		</header><!-- #masthead .site-header -->
		<div class="header-time">
			<p>Election Day is</p>
			<h2><?php echo date('F d, Y',strtotime(Election_Data_Option::get_option( 'election_date' )));?></h2>
		</div>
	</div>
	<div id="container">
        <?php if (!is_front_page()): ?>
        <p class="visible_block_when_mobile"><br><a href="<?php echo home_url( '/' ); ?>">↩ Return Home</a></p>
        <?php endif ?>
		<div id="main" role="main">
