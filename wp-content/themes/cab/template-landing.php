<?php
/*
Template Name: Year Landing Page
*/

get_header(); ?>

<?php
/** LOGIC! **/

// get year
$year = '';
while (have_posts()): the_post();
	$year = get_field('year');
endwhile;

// get exhibitors, split into featured & full list
$exhibitors = array();
$featured = array();
$ex_args = array(
	'post_type' => 'cab_exhibitors',
	'category_name' => $year,
	'posts_per_page' => -1
);
$ex_query = new WP_Query($ex_args);
while ($ex_query->have_posts()):
	$ex_query->the_post();
	$alphabetization = get_field('exhibitor_alpha', $post->ID);
	$url = get_field('exhibitor_url', $post->ID);
	$exclude_from_list = get_field('exhibitor_exclude_from_list', $post->ID);
	if (!$alphabetization):
		$alphabetization = $post->post_title;
	endif;
	$post->alphabetization = strtolower($alphabetization);
	$post->their_url = $url;
	if (has_category('Featured Exhibitor', $post->ID)):
		$featured[$post->ID] = (array) $post;
	endif;
	if (!$exclude_from_list) {
		$exhibitors[$post->ID] = (array) $post;
	}
endwhile;
wp_reset_postdata();
function alphaSort($x, $y) {
    return strcasecmp($x['alphabetization'], $y['alphabetization']);
}
usort($featured, 'alphaSort');
usort($exhibitors, 'alphaSort');


// get events
$events = array();
$events_args = array(
	'post_type' => 'cab_calendar_events',
	'category_name' => $year,
	'posts_per_page' => -1
);
$events_query = new WP_Query($events_args);
while ($events_query->have_posts()):
	$events_query->the_post();
	$event_date = get_field('calendar_event_date', $post->ID);
	$event_location = get_field('calendar_event_location', $post->ID);
	$event_artist = get_field('calendar_event_artist', $post->ID);
	$post->event_date = $event_date;
	$post->event_location_id = $event_location->ID;
	$post->event_artist = $event_artist;
	$events[$post->ID] = (array) $post;
endwhile;
wp_reset_postdata();
usort($events, function($a, $b) {
    return $a['event_date'] - $b['event_date'];
});


// get programming
$programming = array();
$programming_dates = array();
$programming_dates_args = array(
	'post_type' => 'cab_prgm_dates',
	'category_name' => $year,
	'posts_per_page' => -1
);
$programming_dates_query = new WP_Query($programming_dates_args);
while ($programming_dates_query->have_posts()):
	$programming_dates_query->the_post();
	$date = get_field('prgm_date', $post->ID);
	$related_programming = cptr_populate($post->ID);
	foreach ($related_programming as $r):
		$r->event_time = get_field('programming_time', $r->ID);
		$r->ticket_link = get_field('programming_ticket_link', $r->ID);
		$programming[$date][] = (array) $r;
	endforeach;
endwhile;


// get locations
$locations = array();
$location_args = array(
	'post_type' => 'cab_locations',
	'category_name' => $year,
	'posts_per_page' => -1
);
$location_query = new WP_Query($location_args);
while ($location_query->have_posts()):
	$location_query->the_post();
	$location_key = get_field('location_key', $post->ID);
	$post->location_key = $location_key;
	$locations[$post->ID] = (array) $post;
endwhile;
wp_reset_postdata();
function keySort($x, $y) {
    return strcasecmp($x['location_key'], $y['location_key']);
}
usort($locations, 'keySort');

/** END LOGIC **/
?>


<div id="year-wrapper">
	<?php get_sidebar(); ?>
	
	<div id="year-content">
		<div id="exhibitors" class="section">
			<h2>An annual festival of comics and cartoon art</h2>
			<div class="main">
				<?php if (!empty($featured)): ?>
				<section class="section-page marquee">
        <div class="container">
          <div class="inner">
            <h2 class="section-header">Featuring</h2>
            <div class="big-names">
            	<?php foreach($featured as $f): ?>
							<a data-toggle="modal" data-target="#modal-featured-<?php echo $f['ID'] ?>" id="featured-<?php echo $f['ID'] ?>"><?php echo $f['post_title'] ?></a>
							<!-- Modal -->
							<div class="modal fade" id="modal-featured-<?php echo $f['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-featured-<?php echo $f['ID'] ?>-label" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel"><?php echo $f['post_title'] ?></h4>
										</div>
										<div class="modal-body">
											<?php $bio_content = get_post_field('post_content', $f['ID']);
											if ($bio_content): ?>
												<p><?php echo $bio_content ?></p>
											<?php else: ?>
												<p>Bio coming soon!</p>
											<?php endif; ?>
										</div>
										<div class="modal-footer">
											<?php if ($f['their_url']): ?>
												<p><a href="<?php echo $f['their_url'] ?>" target="_BLANK">Visit <?php echo $f['post_title'] ?>'s Site</a></p>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
		          </div>
		        </div>
		      </section>
		      <section class="spacer"></section>
								
				<?php endif; ?>
				<?php if (!empty($exhibitors) && false): ?>
					<div id="show-all-exhibitors"></div>
					<div class="name-list" id="entire-list">
						<header>
							<h3>Exhibitors</h3>
						</header>
						<?php foreach($exhibitors as $e): ?>
							<a href="<?php echo $e['their_url'] ?>" target="_BLANK" id="exhibitor-<?php echo $e['ID'] ?>"><?php echo $e['post_title'] ?></a>
						<?php endforeach; ?>
						<footer>
							<div id="hide-all-exhibitors"></div>
						</footer>
					</div>
				<?php endif; ?>
			</div>
		</div>
<section class='section-page featured'>
        <div class='container'>
          <div class='inner'>
            <h2 class='section-header'>Events</h2>
            
            <?php $count = 1 ?>
				<?php foreach ($events as $e): ?>
				<article class='featured-article'>
	              <aside class='featured-article-meta'>
	                <div class='date'>
	                  <div class='date-day'><? echo date('D', strtotime(get_field('calendar_event_date', $e['ID']))); ?></div>
	                  <div class='date-month'><? echo date('M j', strtotime(get_field('calendar_event_date', $e['ID']))); ?></div>
	                </div>
	                <div class='place'>
	                  <div class='place-title'><a href="<?php echo get_field('location_google_map_url', $e['event_location_id']) ?>" target="_BLANK"><?php echo get_the_title($e['event_location_id']) ?></a></div>
	                  <div class='place-time'><?php echo get_field('calendar_event_time', $e['ID']) ?></div>
	                </div>
	              </aside>
	              <div class='featured-article-content'>
	                <h1><?php echo $e['post_title'] ?></h1>
	                <p><?php echo get_post_field('post_content', $e['ID']) ?></p>
	              </div>
	            </article>
					
					<?php $count++ ?>
				<?php endforeach; ?>
          </div>
        </div>
      </section>
      <section class="spacer spacer-2"></section>
      <section class="section-page program"></section>
      <section class='map'>
      	<div class="map-col">
      		<img src="<?php bloginfo('template_directory'); ?>/images/map-img.png" />
      	</div>
      	<div class="map-col">
        <div class='container'>
          <div class='inner map-list'>
            <h2 class='section-header'>Map</h2>
            <?php $count = 1 ?>
			<?php foreach ($locations as $l): ?>
				<div class="single-location<?php if ($count % 2 != 0): echo ' left'; else: echo ' right'; endif ?>" id="location-<?php echo $l['ID'] ?>">
					<header>
						<span class="alpha"><a href="<?php echo get_field('location_google_map_url', $l['ID']) ?>" target="_BLANK"><?php echo $l['post_title'] ?></a></span>
					</header>
					<footer>
						<p><?php echo get_field('location_street_address', $l['ID']) ?></p>
					</footer>
				</div>
				<?php $count++ ?>
			<?php endforeach; ?>
          </div>
        </div>
    </div>
      </section>

		<div id="programming" class="section">
			<h2>Programming</h2>
			<div class="main">
				<header>
					<h1>Sat Nov 8: Our Lady of Mt. Carmel Church, <span>Brooklyn</span></h1>
				</header>
				<table>
					<thead>
						<tr>
							<td>Time</td>
							<td>Event</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="bigger">All Day</td>
							<td>
								<h4>Book sales</h4>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="main">
				<header>
					<h1>Sun Nov 9: Wythe Hotel, <span>Williamsburg</span></h1>
					<h5>Advance tickets are sold out, but some standing room entry will be available<br />on the day of the event on a first-come-first-served basis.</h5>
				</header>
				<table>
					<thead>
						<tr>
							<td>Time</td>
							<td>Event</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($programming as $d): ?>
							<?php foreach ($d as $p): ?>
								<pre><?php //print_r($p) ?></pre>
								<tr>
									<td class="bigger"><?php echo $p['event_time'] ?></td>
									<td>
										<h4><?php echo $p['post_title'] ?></h4>
										<p><?php echo get_post_field('post_content', $p['ID']) ?></p>
										<?php if ($p['ticket_link']): ?>
											<p><a class="get-tickets" href="<?php echo $p['ticket_link'] ?>" target="_BLANK">View Event Details</a></p>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>