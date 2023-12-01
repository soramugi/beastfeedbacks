import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Icon, text } from "@wordpress/icons";
import metadata from "./block.json";
import "./style.scss";

/**
 * アンケートフォームの入力値
 */
registerBlockType(metadata.name, {
	icon: 'text',

	attributes: {
		content: {
			type: "string",
			source: "text",
			selector: "label",
			default: "サンプル入力値",
		},
	},

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
		const name = content.replace(/(<([^>]+)>)/gi, "");

		return (
			<p {...blockProps}>
				<RichText.Content tagName="label" value={content} />
				<textarea name={name} cols="45" rows="1" maxlength="65525" />
			</p>
		);
	},
});
