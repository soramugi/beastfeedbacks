import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import metadata from './block.json';

import './style.scss';

const TEMPLATE = [
	[ 'core/heading', { level: 3, content: '記事の内容には満足しましたか?' } ],
	[
		'core/buttons',
		{},
		[
			[
				'core/button',
				{ text: 'はい', tagName: 'button', type: 'submit' },
			],
			[
				'core/button',
				{ text: 'いいえ', tagName: 'button', type: 'submit' },
			],
		],
	],
];

/**
 * 投票ボタン
 */
registerBlockType( metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div { ...blockProps }>
				<form name="beastfeedbacks_vote_form">
					<InnerBlocks template={ TEMPLATE } templateLock={ false } />
				</form>
			</div>
		);
	},
	save: () => {
		return <InnerBlocks.Content />;
	},
} );
