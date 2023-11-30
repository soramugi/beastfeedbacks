import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォームの選択肢
 * TODO: 選択肢関連の対応、select,checkbox,radio
 */
registerBlockType(metadata.name, {
	edit: (props) => {
		const {
			attributes: { content },
			setAttributes,
		} = props;
		const blockProps = useBlockProps();
		const onChangeContent = (newContent) => {
			setAttributes({ content: newContent });
		};

		return (
			<p {...blockProps}>
				<RichText tagName="label" onChange={onChangeContent} value={content} />
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
				<RichText.Content tagName="label" value={props.attributes.content} />
				<select name={props.attributes.content}>
					<option>1</option>
					<option>2</option>
					<option>3</option>
				</select>
			</p>
		);
	},
});
