<?php
/**
 * Likeで表示されるhtmlコード
 *
 * @package BeastFeedbacks
 */

/**
 * Renders the `beastfeedbacks/like` block on the server.
 *
 * @param array  $attributes Block attributes.
 * @param string $content    Block default content.
 *
 * @return string Returns the next or previous post link that is adjacent to the current post.
 */
function beastfeedbacks_block_like_render_callback( $attributes, $content ) {
	$html = <<<END
<div %s >
	<form action="%s" name="beastfeedbacks_like_form" method="POST">
		<div class="beastfeedbacks-like_balloon">
			<p class="like-count">%s</p>
		</div>
		%s
		<input type="hidden" name="action" value="register_beastfeedbacks_form" />
		<input type="hidden" name="beastfeedbacks_type" value="like" />
		<input type="hidden" name="id" value="%s" />
		%s
	</form>
</div>
END;

	$beastfeedbacks_post_id    = get_the_ID();
	$beastfeedbacks_like_count = BeastFeedbacks::get_instance()->get_like_count( $beastfeedbacks_post_id );

	return sprintf(
		$html,
		$attributes,
		esc_url( admin_url( 'admin-ajax.php' ) ),
		esc_html( $beastfeedbacks_like_count ),
		wp_nonce_field( 'register_beastfeedbacks_form' ),
		esc_attr( $beastfeedbacks_post_id ),
		$content,
	);
}

/**
 * ブロック登録
 */
function beastfeedbacks_block_like_init() {

	$type = register_block_type(
		__DIR__,
		array(
			'render_callback' => 'beastfeedbacks_block_like_render_callback',
		)
	);

	wp_set_script_translations(
		$type->editor_script,
		BEASTFEEDBACKS_DOMAIN,
		BEASTFEEDBACKS_DIR . 'languages',
	);
}

beastfeedbacks_block_like_init();
