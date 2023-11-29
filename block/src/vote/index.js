import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";

import "./style.scss";

// icon @see https://developer.wordpress.org/resource/dashicons/#calculator

const TEMPLATE = [
	["core/heading", { level: 3, content: "記事の内容には満足しましたか?" }],
	[
		"core/buttons",
		{},
		[
			["core/button", { text: "はい", tagName: "button", type: "submit" }],
			["core/button", { text: "いいえ", tagName: "button", type: "submit" }],
		],
	],
];

/**
 * 投票ボタン
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<InnerBlocks template={TEMPLATE} templateLock={false} />
			</div>
		);
	},
	save: (props) => {
		return <InnerBlocks.Content />;
	},
});
