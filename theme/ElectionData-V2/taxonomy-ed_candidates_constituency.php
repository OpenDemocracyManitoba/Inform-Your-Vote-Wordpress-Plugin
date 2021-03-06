<?php

/**
 *	Standard template for displaying candidates in a constituency.
 *  @author Robert Burton
 */

$constituency = get_constituency( $party_id = get_queried_object()->term_id );
$constituency_id = $constituency['id'];

$child_constituencies = "";

if($constituency['grandchildren']){
	$child_constituencies = 'grandchildren';
} else{
	$child_constituencies = "children";
}

get_header();?>

<?php if ( $constituency['children'] ) : ?>
	<h2 class="hidden_block_when_mobile">Select Your <?php echo $constituency['name']; ?> Electoral Division</h2>
	<!-- <p class="small grey hidden_block_when_mobile">Find by name or click the map.</p> -->
	<p class="small hidden_block_when_mobile" style="margin: 2em 1em;">If you do not know your electoral division, please use <a target="_blank" href="https://www.electionsmanitoba.ca/en/Voting/WhatsMyElectoralDivision">Elections Manitoba's address lookup tool</a> and then return to our site.</p>
	<div class='flow_it'>
		<?php if ( $constituency['map_id'] ) : ?>
			<div class='two_columns hidden_block_when_mobile'>
				<?php echo wp_get_attachment_image($constituency['map_id'], 'map', false, array( 'alt' => $constituency['name'], 'usemap' => '#constituency_map', 'class' => 'highmap'	) ); ?>
				<map id="constituency_map" name="constituency_map">

						<?php foreach ( $constituency[$child_constituencies] as $name => $child ) :?>
							<?php if ( $child['coordinates'] ) : ?>
								<area alt='<?php echo $name; ?>' coords='<?php echo $child['coordinates']; ?>' href='<?php echo $child['url']; ?>' shape='poly' title='<?php echo $name; ?>'>
							<?php endif; ?>
						<?php endforeach; ?>

				</map>
			</div>
		<?php endif;?>
		<div class='one_column map_nav'>
        <h3>
          <?php echo $constituency['name']; ?><br class="visible_block_when_mobile">
          Electoral Divisions
        </h3>

        <p class="visible_block_when_mobile small" style="margin-bottom: 2em">If you do not know your electoral division, please use <a target="_blank" href="https://www.electionsmanitoba.ca/en/Voting/WhatsMyElectoralDivision">Elections Manitoba's address lookup tool</a> and then return to our site.</p>

        <ul>
					<?php foreach ( $constituency['children'] as $name => $child ) :?>
						<?php $child_constituency = get_constituency($child['id']);?>

						<?php if($child_constituency['children']):?>
							<h3><?php echo $name; ?></h3>
							<ul>
								<?php foreach ( $child_constituency['children'] as $name => $child) :?>
									<li><a href="<?php echo $child['url']; ?>"><?php echo $name; ?></a></li>
								<?php endforeach;?>
							</ul>
						<?php else:?>
                <li><a href="<?php echo $child['url']; ?>"><?php echo $name; ?></a></li>
						<?php endif;?>

					<?php endforeach; ?>
        </ul>
        <br>
		</div>
   </div>
<?php else :
	$candidate_references = array();
	?>

  <p class="breadcrumbs">
    <a href="<?= Election_Data_Option::get_option( 'candidate-link', '/' ) ?>">Candidates</a> / 
    <?php if(isset($constituency['parent_name'])): ?>
      <a href="<?= $constituency['parent_url'] ?>"><?= $constituency['parent_name'] ?></a> /
    <?php endif ?>
    <a href="<?php echo $constituency['url']; ?>"><?php echo esc_html( $constituency['name'] ); ?></a> 
  </p>
	<h2 class="constituency_header"><?php echo $constituency['name']; ?></h2>
  <br>
  <p>
    <a class="hover_underline" href="#news">Read news articles that mentions these candidates</a>.
  </p>
  <p>
    <?php if ($constituency['number_of_winners'] < 2) : ?>
    There are <?php echo $wp_query->post_count; ?> candidates in this election race.
  <?php else : ?>
    There are <?php echo $wp_query->post_count; ?> candidates competing for <?php echo $constituency['number_of_winners'] ?> seats in this race.
  <?php endif ?>
    <span class="small grey">Candidates are displayed in random order.</span>
  </p>
  <div class="flow_it politicians">
    <?php display_constituency_candidates( $wp_query, $constituency, $candidate_references ); ?>
  </div>
  <p class="small grey">
    Candidates were sent questionnaires by email from August 28th to September 1st, 2019.
  </p>
  <p class="small grey">
    Parties were contacted to help us reach campaigns without known email addresses.
  </p>
  <p class="small grey">
     Our candidate data retrieval process is available in <a href="/frequently-asked-questions">our FAQ</a>.</span>
  </p>
	<div class="flow_it" >
		<?php if ( !empty( $constituency['details'] ) ) : ?>
      <br>
      <br>
			<div class="three_columns constit_description">
				<h2>The <?php echo $constituency['name']; ?> Electoral Division</h2>
				<p><?php echo $constituency['details']; ?></p>
      <br>
			</div>
		<?php endif; ?>
    <div class="three_columns latest_news_small">
      <h2 id="news">Latest Candidate News</h2>
      <p class="grey small">Articles that mention candidates from this race.</p>
      <?php $article_count = Election_Data_Option::get_option('news-count-constituency', 10);
      display_news_titles( $candidate_references, false, $article_count ); ?>
      <br><br>
      <p class="grey small"><?php echo Election_Data_Option::get_option( 'news-scraping-subheading' ) ?></p>
    </div>
  </div>
<?php endif; ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
