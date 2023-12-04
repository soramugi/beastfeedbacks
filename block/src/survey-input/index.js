import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Icon, text } from "@wordpress/icons";
import metadata from "./block.json";
import "./style.scss";
import FieldControls from "./field-controls";

/**
 * アンケートフォームの入力値
 */
registerBlockType(metadata.name, {
	icon: "text",

	attributes: {
		label: {
			type: "string",
			default: "サンプル入力値",
		},
		tagType: {
			type: "string",
			default: "text",
		},
		required: {
			type: "boolean",
			default: false,
		},
	},

	edit: ({ attributes, setAttributes }) => {
		const { label, required, tagType } = attributes;
		const blockProps = useBlockProps();

		return (
			<>
				<div {...blockProps}>
					<div>
						<RichText
							tagName="label"
							onChange={(value) => setAttributes({ label: value })}
							value={label}
						/>{" "}
						{required && <span>(必須)</span>}
					</div>
					<div>
						{tagType === "textarea" ? (
							<textarea rows="3" />
						) : (
							<input type={tagType} />
						)}
					</div>
				</div>
				<FieldControls attributes={attributes} setAttributes={setAttributes} />
			</>
		);
	},
	save: ({ attributes }) => {
		const { label, required, tagType } = attributes;
		const blockProps = useBlockProps.save();
		const name = label.replace(/(<([^>]+)>)/gi, "");

		return (
			<div {...blockProps}>
				<div>
					<RichText.Content tagName="label" value={label} />{" "}
					{required && <span>(必須)</span>}
				</div>
				<div>
					{tagType === "textarea" ? (
						<textarea name={name} rows="3" required={required} />
					) : (
						<input name={name} type={tagType} required={required} />
					)}
				</div>
			</div>
		);
	},
});
