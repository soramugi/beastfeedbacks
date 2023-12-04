import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

import metadata from "./block.json";
import "./style.scss";

const TEMPLATE = [
	["core/heading", { level: 3, content: "製品アンケートにご協力ください。" }],
	[
		"beastfeedbacks/survey-select",
		{
			label: "あなたの性別は",
			tagType: "radio",
			required: true,
			items: ["男", "女", "その他"],
		},
	],
	[
		"beastfeedbacks/survey-select",
		{
			label: "年齢を選択してください",
			tagType: "select",
			required: true,
			items: [
				"15歳以下",
				"16~20歳",
				"21~25歳",
				"26~30歳",
				"31~39歳",
				"40~49歳",
				"50~59歳",
				"60歳以上",
			],
		},
	],
	[
		"beastfeedbacks/survey-select",
		{
			label: "あなたの職種を選択してください",
			tagType: "select",
			required: true,
			items: [
				"経営者・役員",
				"会社員（総合職）",
				"会社員（一般職）",
				"契約社員・派遣社員",
				"パート・アルバイト",
				"公務員（教職員除く）",
				"教職員",
				"医療関係者",
				"自営業・自由業",
				"専業主婦・主夫",
				"大学生・大学院生",
				"専門学校生・短大生",
				"高校生",
				"士業（公認会計士・弁護士・税理士・司法書士）",
				"無職",
				"定年退職",
				"その他",
			],
		},
	],
	[
		"beastfeedbacks/survey-input",
		{
			label: "あなたの性格はどんなタイプですか?",
			tagType: "text",
			placeholder: "例: 怒りっぽい、短期 or 冷静、内気",
		},
	],
	[
		"beastfeedbacks/survey-select",
		{
			label: "製品はどこで知りましたか",
			tagType: "checkbox",
			items: [
				"インターネット広告",
				"ホームページ",
				"SNS",
				"メールマガジン",
				"知人",
				"店頭",
				"テレビ、ラジオ広告",
				"その他",
			],
		},
	],
	[
		"beastfeedbacks/survey-input",
		{
			label: "製品を購入する決め手は",
			tagType: "textarea",
			required: true,
		},
	],
	[
		"beastfeedbacks/survey-input",
		{
			label: "製品の改善すべき点はありますか",
			tagType: "textarea",
			required: true,
		},
	],
	[
		"beastfeedbacks/survey-select",
		{
			label: "製品に対しての評価をお願いします",
			tagType: "radio",
			required: true,
			items: ["とても満足", "満足", "普通", "不満", "とても不満"],
		},
	],
	[
		"beastfeedbacks/survey-input",
		{
			label: "最後に感想があればご記入ください",
			tagType: "textarea",
			required: true,
		},
	],
	["core/button", { text: "送信", tagName: "button", type: "submit" }],
];

/**
 * アンケートフォーム
 */
registerBlockType(metadata.name, {
	/**
	 * @see https://developer.wordpress.org/resource/dashicons/#feedback
	 */
	icon: "feedback",

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
