<?php
/**
 * The template for displaying all single posts and attachments
 * Specifically, this is for displaying all candidates.
 */

get_header();

?>
<div id="primary">
    <div id="content" role="main">
		<?php display_all_candidates( $wp_query ); ?>
	</div>
</div>
<?php get_footer(); ?>
