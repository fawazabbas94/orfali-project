<link rel="stylesheet" type="text/css" href="/wp-content/themes/woodmart-child/css/normalize.css">
<link rel="stylesheet" type="text/css" href="/wp-content/themes/woodmart-child/css/jquery.qtip.min.css">
<script type="text/javascript" src="/wp-content/themes/woodmart-child/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/wp-content/themes/woodmart-child/js/raphael-min.js"></script>
<script type="text/javascript" src="/wp-content/themes/woodmart-child/js/paths.js"></script>
<script type="text/javascript" src="/wp-content/themes/woodmart-child/js/turkiye.js?v=123"></script>
<script type="text/javascript" src="/wp-content/themes/woodmart-child/js/jquery.qtip.min.js"></script>
<script type="text/javascript">
	jQuery(function() {
		$("#map svg path").hover(
			function() {
				var id = $(this).attr("id");
				$("#city").text(id);
			}
		);
	});
</script>
<style type="text/css">
	#map {
		width: 1200px;
		height: 900px;
		position: relative;
		margin: auto;
		margin-block-start: -100px;
	}

	#map svg {
		width: 100%;
		height: 100%;
		position: relative;
		top: 0px;
		left: 0px;
	}

	#map svg desc,
	#map svg defs {
		display: none !important;
	}

	#map svg path {
		cursor: pointer;
	}

	svg>a {
		cursor: pointer;
		display: block;
	}

	.district-info {
		display: flex;
		flex-direction: row;
		flex-wrap: nowrap;
		justify-content: flex-start;
		align-items: center;
		gap: 10px;
		font-size: 30px;
		text-align: center;
		color: var(--rem-c3-main);
		background-color: var(--rem-c5-main);
		padding: 5px 15px;
		border-radius: var(--rem-border-radius);
		margin-inline: auto;
		width: max-content;
	}

	.istanbul .title {
		font-size: 30px;
		color: var(--rem-c3-dark);
		font-weight: 600;
		margin-block-end: 30px;
		text-align: center;
	}

	.single-district {
		font-size: 18px;
	}
</style>
<div class="istanbul">
	<div class="title">Explore Istanbul Listings</div>
	<div class="district-info">
		<div id="city">Select a District</div>
		<?php
		$districts = get_terms(array(
			'taxonomy' => 'district',
			'hide_empty' => false,
		));
		foreach ($districts as $district) {
			$listing_count = new WP_Query(array(
				'post_type' => 'listing',
				'tax_query' => array(
					array(
						'taxonomy' => 'district',
						'field' => 'slug',
						'terms' => $district->slug,
					),
				),
				'posts_per_page' => -1,
			)); ?>
			<div class="single-district" style="display: none;" id="D-<?php echo $district->slug; ?>">( <?php echo $listing_count->found_posts ?> listings )</div>
		<?php
		}
		?>
	</div>
	<div id="map"></div>
</div>