import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import metadata from './block.json';

import './style.scss';

const TEMPLATE = [
	[
		'core/button',
		{
			text: 'いいね',
			tagName: 'button',
			type: 'submit',
		},
	],
];

/**
 * Likeボタン
 */
registerBlockType( metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div { ...blockProps }>
				<form name="beastfeedbacks_like_form">
					<div className="beastfeedbacks-like_balloon">
						<p className="like-count">0</p>
					</div>
					<InnerBlocks
						allowedBlocks={ TEMPLATE }
						template={ TEMPLATE }
						templateLock="all"
					/>
				</form>
			</div>
		);
	},
	save: () => {
		return <InnerBlocks.Content />;
	},
} );
