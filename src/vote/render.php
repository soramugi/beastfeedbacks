<?php
/**
 * 投票(vote)で表示されるhtmlコード
 *
 * @param array $attributes The block attributes.
 * @param string $content save関数で返却された値 = <InnerBlocks.Content />
 * @param \WP_Block $block The block instance.
 * @package    BeastFeedbacks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div
	<?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" name="beastfeedbacks_vote_form" method="POST">
		<?php wp_nonce_field( 'register_beastfeedbacks_form' ); ?>
		<input type="hidden" name="action" value="register_beastfeedbacks_form" />
		<input type="hidden" name="beastfeedbacks_type" value="vote" />
		<input type="hidden" name="id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</form>
</div>

