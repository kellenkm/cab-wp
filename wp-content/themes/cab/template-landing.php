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


		<?php if (!empty($featured)): ?>
		<section class="section-page marquee">
        <div class="container">
          <div class="inner">
            <h2 class="section-header">Featuring</h2>
            <div class="big-names">
            	<?php foreach($featured as $f): ?>
							<a data-toggle="modal" data-target="#modal-featured-<?php echo $f['ID'] ?>" id="featured-<?php echo $f['ID'] ?>"><?php echo $f['post_title'] ?></a>
							<!-- Modal -->
							<div class="modal fade" style="display:none;" id="modal-featured-<?php echo $f['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-featured-<?php echo $f['ID'] ?>-label" aria-hidden="true">
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
				<?php foreach ($events as $e): 
				?><article class='featured-article'>
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
	            </article><?php 
	            $count++;
	            endforeach; ?>
          </div>
        </div>
      </section>
      <section class="spacer spacer-2"></section>
      <section class="section-page program">
      	<div class="container">
      		<div class="inner">
            <h2 class="section-header">Programming</h2>
            <header class="program-header">
              <div class="date">
                <div class="date-day">Saturday</div>
                <div class="date-month">Nov 8</div>
              </div>
              <div class="place">
                <div class="place-title">Our Lady of Mt. Carmel Church</div>
                <div class="place-sub">Brooklyn</div>
              </div>
            </header>
            <article class="program-article">
              <div class="program-article-content">
                <div class="program-article-time">All Day</div>
                <h1>Book Sales</h1>
              </div>
            </article>
          </div>
			
		</div>
	</div>
      </section>
			<section class="section-page program bg-vibrant">
        <div class="container">
          <div class="inner">
            <header class="program-header">
              <div class="date">
                <div class="date-day">Sunday</div>
                <div class="date-month">Nov 8</div>
              </div>
              <div class="place">
                <div class="place-title">Our Lady of Mt. Carmel Church</div>
                <div class="place-sub">Brooklyn</div>
              </div>
            </header>
            
            <?php foreach ($programming as $d): ?>
			<?php foreach ($d as $p): ?>
				<article class="program-article">
	              <div class="program-article-content">
	                <div class="program-article-time"><?php echo $p['event_time'] ?></div>
	                <h1><?php echo $p['post_title'] ?></h1>
	                <p><?php echo get_post_field('post_content', $p['ID']) ?></p>
	                <?php if ($p['ticket_link']): ?>
							<p><a class="get-tickets" href="<?php echo $p['ticket_link'] ?>" target="_BLANK">View Event Details</a></p>
						<?php endif; ?>
	              </div>
	            </article>
			<?php 

			break;
			endforeach; ?>
		<?php endforeach; ?>
          </div>
        </div>
            <?php 
            $index = 0;
            foreach ($programming as $d): ?>
			<?php foreach ($d as $p): 
				$index++; 
				if($index == 1) continue; ?>
				<div class="container">
          <div class="inner">
            <article class="program-article align-right">
              <div class="program-article-content">
                <div class="program-article-time"><?php echo $p['event_time'] ?></div>
                <h1><?php echo $p['post_title'] ?></h1>
                <p><?php echo get_post_field('post_content', $p['ID']) ?></p>
                <?php if ($p['ticket_link']): ?>
					<p><a class="get-tickets" href="<?php echo $p['ticket_link'] ?>" target="_BLANK">View Event Details</a></p>
				<?php endif; ?>
              </div>
            </article>
          </div>
        </div>
			<?php 
			endforeach; ?>
		<?php endforeach; ?>
      </section>
      <section class="spacer spacer-3"></section>
      <section class="section-page locations">
        <aside class="location-map">
          <div class="map"><img src="<?php bloginfo('template_directory'); ?>/images/map-img.png" /></div>
        </aside>
        <div class="location-directory">
          <ul class="location-list">
          	<?php $count = 1 ?>
			<?php foreach ($locations as $l): ?>
				<li>
	              <h4><a href="<?php echo get_field('location_google_map_url', $l['ID']) ?>" target="_BLANK"><?php echo $l['post_title'] ?></a></h4>
	              <p><?php echo get_field('location_street_address', $l['ID']) ?></p>
	            </li>
				<?php $count++ ?>
			<?php endforeach; ?>
          </ul>
        </div>
      </section>
    
<?php get_footer(); ?>