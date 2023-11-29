<?php
/**
 * アンケートフォームで表示されるhtmlコード
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
?>

<div
	<?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<form>
		<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</form>
</div>

