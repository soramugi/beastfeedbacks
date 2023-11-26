<?php

/**
 * Dynamic Block Template.
 * @param   array $attributes - A clean associative array of block attributes.
 * @param   array $block - All the block settings and attributes.
 * @param   string $content - The block inner HTML (usually empty unless using inner blocks).
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$post_id = get_the_ID();
$post = get_post($post_id);
$guid = $post->guid;
// $count = $this->get_like_count($guid);
$count = 123;
$nonce = wp_create_nonce('beastfeedbacks_nonce');
?>


<div class="wp-block-beastfeedback-like-wrapper" <?php echo get_block_wrapper_attributes(); ?> data-nonce="<?php echo $nonce ?>" data-guid="<?php echo $guid ?>">
	<div className="wp-block-beastfeedback-like-balloon">
		<p className="like-count">0</p>
	</div>
	<?php echo $content ?>
</div>
