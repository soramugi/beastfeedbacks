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
$like_count         = BeastFeedbacks::get_instance()->get_like_count( $_post_id );
$form_action        = admin_url( 'admin-ajax.php' );
?>

<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<form action="<?php echo esc_url( $form_action ); ?>" name="beastfeedbacks_like_form" method="POST">
		<div class="beastfeedbacks-like_balloon">
			<p class="like-count"><?php echo esc_html( $like_count ); ?></p>
		</div>
		<?php wp_nonce_field( 'register_beastfeedbacks_form' ); ?>
		<input type="hidden" name="action" value="register_beastfeedbacks_form" />
		<input type="hidden" name="beastfeedbacks_type" value="like" />
		<input type="hidden" name="id" value="<?php echo esc_attr( $_post_id ); ?>" />
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</form>
</div>
