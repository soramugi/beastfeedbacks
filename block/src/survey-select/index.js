import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォームの選択肢
 * TODO: 選択肢関連の対応、select,checkbox,radio
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<p {...blockProps}>
				<label for="comment">
					サンプル選択肢 <span class="required">※</span>
				</label>
				<select>
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</select>
			</p>
		);
	},
	save: (props) => {
		const blockProps = useBlockProps.save();

		return (
			<p {...blockProps}>
				<label for="comment">
					サンプル選択肢 <span class="required">※</span>
				</label>
				<select>
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</select>
			</p>
		);
	},
});
