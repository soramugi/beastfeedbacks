import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォームの入力値
 * TODO: テキスト入力関連の対応、inputやtextarea
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<p {...blockProps}>
				<label>
					サンプル入力値 <span class="required">※</span>
				</label>
				<textarea
					cols="45"
					rows="1"
					maxlength="65525"
				/>
			</p>
		);
	},
	save: (props) => {
		const blockProps = useBlockProps.save();

		return (
			<p {...blockProps}>
				<label>
					サンプル入力値 <span class="required">※</span>
				</label>
				<textarea
					cols="45"
					rows="8"
					maxlength="65525"
				/>
			</p>
		);
	},
});