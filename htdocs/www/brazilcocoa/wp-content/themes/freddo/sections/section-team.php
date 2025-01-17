<?php $showTeam = freddo_options('_onepage_section_team', ''); ?>
<?php if ($showTeam == 1) : ?>
	<?php
		$teamSectionID = freddo_options('_onepage_id_team', 'team');
		$teamTitle = freddo_options('_onepage_title_team', __('Our Team', 'freddo'));
		$teamSubTitle = freddo_options('_onepage_subtitle_team', __('Nice to meet you', 'freddo'));
		$customMore = freddo_options('_excerpt_more', '&hellip;');
		$textLenght = freddo_options('_onepage_lenght_team', '50');
		$teamTestimonialBox = array();
		for( $number = 1; $number < FREDDO_VALUE_FOR_TEAM; $number++ ){
			$teamTestimonialBox["$number"] = freddo_options('_onepage_choosepage_'.$number.'_team', '');
			$teamLink["$link".$number] = $number;
		}
	?>
<section class="freddo_onepage_section freddo_team" id="<?php echo esc_attr($teamSectionID); ?>">
	<div class="freddo_team_color"></div>
	<div class="freddo_action_team">
		<?php if($teamTitle || is_customize_preview()): ?>
			<h2 class="freddo_main_text"><?php echo esc_html($teamTitle); ?></h2>
		<?php endif; ?>
		<?php if($teamSubTitle || is_customize_preview()): ?>
			<p class="freddo_subtitle"><?php echo esc_html($teamSubTitle); ?></p>
		<?php endif; ?>
		<div class="team_columns">
			<?php 
			
			$links = ["eventos/","cuidado-del-cabello/","app/", "distribuidores/", "cat/", "directorio-de-belleza/"];
			
			for( $number = 1; $number < FREDDO_VALUE_FOR_TEAM; $number++ ) : ?>
				<?php if ($teamTestimonialBox["$number"]) : ?>
					<a href="<?php echo $links[($number-1)]; ?>">
						<div class="freddoTeamSingle">
							<?php if ('' != get_the_post_thumbnail($teamTestimonialBox["$number"])) : ?>
								<?php echo get_the_post_thumbnail(intval($teamTestimonialBox["$number"]), 'freddo-little-post'); ?>
							<?php endif; ?>
							<div class="freddoTeamName"><?php echo get_the_title(intval($teamTestimonialBox["$number"])); ?></div>
							<div class="freddoTeamDesc">
							<?php 
								$post_contentt = get_post(intval($teamTestimonialBox["$number"]));
								$content = $post_contentt->post_content; ?>
								<p><?php echo wp_trim_words($content , intval($textLenght), esc_html($customMore) ); ?></p>
							</div>
						</div>
					</a>
				<?php endif; ?>
			<?php endfor; ?>
		</div>
	</div>
</section>
<?php endif; ?>