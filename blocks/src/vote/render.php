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

$wrapper_attributes = get_block_wrapper_attributes();
$_post_id = get_the_ID();
$nonce              = wp_create_nonce( 'beastfeedbacks_' . $_post_id . '_nonce' );
?>

<div <?php echo $wrapper_attributes; ?> data-nonce="<?php echo $nonce; ?>" data-id="<?php echo $_post_id; ?>">
	<?php echo $content; ?>
</div>

