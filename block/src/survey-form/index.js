import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";

import "./style.scss";


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

	/**
	 * @see https://developer.wordpress.org/resource/dashicons/#feedback
	 */
	icon: 'feedback',

	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<form name="beastfeedbacks_survey_form">
					<InnerBlocks template={TEMPLATE} templateLock={false} />
				</form>
			</div>
		);
	},
	save: (props) => {
		return <InnerBlocks.Content />;
	},
});
