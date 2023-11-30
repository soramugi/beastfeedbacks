import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";

import "./style.scss";

// icon @see https://developer.wordpress.org/resource/dashicons/#calculator

const TEMPLATE = [
	["core/heading", { level: 3, content: "アンケートにご協力ください。" }],
	["beastfeedbacks/survey-input"],
	["beastfeedbacks/survey-select"],
	["core/button", { text: "送信", tagName: "button", type: "submit" }],
];

/**
 * アンケートフォーム
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<form name="beastfeedbacks_form">
					<InnerBlocks template={TEMPLATE} templateLock={false} />
				</form>
			</div>
		);
	},
	save: (props) => {
		return <InnerBlocks.Content />;
	},
});
