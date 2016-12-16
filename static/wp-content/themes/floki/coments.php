
                 <?php if($tipopage=="" || $tipopage == 'full') { ?>

<div class="container">

<?php  } ?>	                
		<div class="infofloki">		
				<div class="tagsfloki">
					<?php wp_link_pages(array('before' => '<p class="floki_pagination"><strong>'.__('Pages:', 'floki').' </strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					<?php the_tags( '<span style="float:left">'.__('Tags', 'floki').':</span> ', '', '<div style="clear:both"></div>'); ?>
				</div>
                <p>

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// both comments and pings open ?>
							 <?php _e( 'You can', 'floki' ); ?> <a href="#respond"><?php _e( 'leave a response', 'floki' ); ?></a>, or <a href="<?php trackback_url(); ?>" rel="trackback"><?php _e( 'trackback', 'floki' ); ?></a> <?php _e( 'from own site', 'floki' ); ?>.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// only pings are open ?>
							<?php _e( 'Responses are currently closed, but you can', 'floki' ); ?> <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> <?php _e( 'from your own site', 'floki' ); ?>.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// comments are open, pings are not ?>
							<?php _e( 'You can skip to the end and leave a response. Pinging is currently not allowed.', 'floki' ); ?> 

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// neither comments nor pings are open ?>
							<?php _e( 'Both comments and pings are currently closed.', 'floki' ); ?> 

						<?php } edit_post_link(__('Edit this entry', 'floki'),'','.'); ?>

					</p>
              </div>  

          
<?php comments_template(); ?>

 <?php if($tipopage=="" || $tipopage == 'full') { ?>

</div>

<?php  } ?>	