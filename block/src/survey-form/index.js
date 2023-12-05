import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
	useBlockProps,
	useInnerBlocksProps,
	InnerBlocks,
} from "@wordpress/block-editor";

import variations from "./variations";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォーム
 */
registerBlockType(metadata.name, {
	/**
	 * @see https://developer.wordpress.org/resource/dashicons/#feedback
	 */
	icon: "feedback",

	variations,

	edit: () => {
		const blockProps = useBlockProps();
		const innerBlocksProps = useInnerBlocksProps(
			{},
			{
				// デフォルトの入れ子ブロック、variationsで上書きされる
				template: [
					[
						"core/heading",
						{ level: 3, content: "お客様の声をお聞かせください" },
					],
					[
						"beastfeedbacks/survey-select",
						{
							label: "当サイトの満足度",
							tagType: "radio",
							required: true,
							items: ["とても満足", "満足", "普通", "不満", "とても不満"],
						},
					],
					[
						"beastfeedbacks/survey-input",
						{
							label: "詳細",
							tagType: "textarea",
						},
					],
					["core/button", { text: "送信", tagName: "button", type: "submit" }],
				],
			},
		);

		return (
			<div {...blockProps}>
				<form name="beastfeedbacks_survey_form">
					<div {...innerBlocksProps} />
				</form>
			</div>
		);
	},
	save: () => {
		return <InnerBlocks.Content />;
	},
});
