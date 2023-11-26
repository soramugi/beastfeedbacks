import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
	useBlockProps,
	InnerBlocks,
} from "@wordpress/block-editor";
import metadata from "./block.json";

import "./style.scss";

const TEMPLATE = [
	[
		"core/button",
		{
			text: "いいね",
			tagName: "button",
			type: "submit",
		},
	],
];

/**
 * Likeボタン
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div className="wp-block-beastfeedback-like-wrapper" {...blockProps}>
				<div className="wp-block-beastfeedback-like-balloon">
					<p className="like-count">0</p>
				</div>
				<InnerBlocks
					allowedBlocks={TEMPLATE}
					template={TEMPLATE}
					templateLock="all"
				/>
			</div>
		);
	},
	save: () => {
		const blockProps = useBlockProps.save();

		const post = select("core/editor").getCurrentPost();
		console.log(post.guid);

		return (
			<div className="wp-block-beastfeedback-like-wrapper" {...blockProps}>
				<div className="wp-block-beastfeedback-like-balloon">
					<p className="like-count">0</p>
				</div>

				<InnerBlocks.Content />
			</div>
		);
	},
});
