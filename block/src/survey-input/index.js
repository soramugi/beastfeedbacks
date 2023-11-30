import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォームの入力値
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
				<textarea cols="45" rows="1" maxlength="65525" />
			</p>
		);
	},
	save: (props) => {
		const blockProps = useBlockProps.save();
		const content = props.attributes.content;
		const name = content.replace(/(<([^>]+)>)/ig, "");

		return (
			<p {...blockProps}>
				<RichText.Content tagName="label" value={content} />
				<textarea name={name} cols="45" rows="1" maxlength="65525" />
			</p>
		);
	},
});
