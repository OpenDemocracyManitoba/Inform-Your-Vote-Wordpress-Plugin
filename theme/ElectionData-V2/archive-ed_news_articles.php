<?php
/**
 * The template for displaying all single posts and attachments
 * Specifically, this is for dealing with news articles.
 */

get_header();

?>
<div id="flow_it">
    <div class="three_columns latest_news_large">
		<h3>Latest News Articles</h3>
		<div class="grey small">
			<p><?php echo Election_Data_Option::get_option( 'news-scraping-subheading' ) ?></p>
		</div>
		<?php news_titles( $wp_query, 'News Article' ); ?>
	</div>
</div>
<?php get_footer(); ?>
