<?php
/**
 * いいね(like)で表示されるhtmlコード
 *
 * @param array $attributes The block attributes.
 * @param string $content save関数で返却された値 = <InnerBlocks.Content />
 * @param \WP_Block $block The block instance.
 * @package    BeastFeedbacks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wrapper_attributes = get_block_wrapper_attributes();
$_post_id           = get_the_ID();
$nonce_key          = BeastFeedbacks_Block::get_instance()->get_rest_api_nonce_key( $_post_id );
$nonce              = wp_create_nonce( $nonce_key );
$like_count         = BeastFeedbacks::get_instance()->get_like_count( $_post_id );
?>

<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-nonce="<?php echo esc_html( $nonce ); ?>"
	data-id="<?php echo esc_html( $_post_id ); ?>"
>
	<div class="wp-block-beastfeedbacks-like-balloon">
		<p class="like-count"><?php echo esc_html( $like_count ); ?></p>
	</div>
	<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
