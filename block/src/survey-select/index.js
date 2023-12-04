import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";

import metadata from "./block.json";
import "./style.scss";
import FieldControls from "./field-controls";
import EditListBlock from "./edit-list-block";

/**
 * アンケートフォームの選択肢
 * TODO: 選択肢関連の対応、select,checkbox,radio
 */
registerBlockType(metadata.name, {
	/**
	 * @see https://developer.wordpress.org/resource/dashicons/
	 */
	icon: "yes",

	attributes: {
		content: {
			type: "string",
			source: "text",
			selector: "label",
			default: "サンプル選択肢",
		},
		tagType: {
			type: "string",
			selector: "radio,checkbox,select",
			source: "text",
			default: "radio",
		},
		required: {
			type: "boolean",
			default: false,
		},
		items: {
			type: "array",
			default: [""],
		},
	},

	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();

		return (
			<>
				<div {...blockProps}>
					<div style={{ alignItems: "baseline" }}>
						<RichText
							tagName="label"
							onChange={(newContent) => {
								setAttributes({ content: newContent });
							}}
							value={attributes.content}
						/>{" "}
						{attributes.required && <span>(必須)</span>}
					</div>

					<EditListBlock
						attributes={attributes}
						setAttributes={setAttributes}
					/>
				</div>
				<FieldControls attributes={attributes} setAttributes={setAttributes} />
			</>
		);
	},
	save: ({ attributes }) => {
		const blockProps = useBlockProps.save();
		const { content, items, required, tagType } = attributes;
		const name = content.replace(/(<([^>]+)>)/gi, "");

		return (
			<div {...blockProps}>
				<div style={{ alignItems: "baseline" }}>
					<RichText.Content tagName="label" value={content} />{" "}
					{required && <span>(必須)</span>}
				</div>

				<div>
					{items.map((value, index) => (
						<div>
							{"select" !== tagType && (
								<input
									type={tagType}
									name={name}
									id={value}
									value={value}
									required={required}
								/>
							)}
							<RichText.Content
								tagName="label"
								key={index}
								value={value}
								for={value}
							/>
						</div>
					))}
				</div>
			</div>
		);
	},
});
