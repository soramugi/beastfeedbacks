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
		placeholder: {
			type: "string",
			default: "",
		},
		width: {
			type: "number",
		},
	},

	edit: ({ attributes, setAttributes }) => {
		const { label, required, tagType, placeholder, width } = attributes;
		const blockProps = useBlockProps();

		return (
			<>
				<div {...blockProps} style={{ width: width ? width + '%' : null }}>
					<div className="beastfeedbacks-survey-input_label">
						<RichText
							tagName="label"
							onChange={(value) => setAttributes({ label: value })}
							value={label}
						/>{" "}
						{required && (
							<span className="beastfeedbacks-survey-input_label_required">
								(必須)
							</span>
						)}
					</div>
					<div className="beastfeedbacks-survey-input_item">
						{tagType === "textarea" ? (
							<RichText
								className="dummy-textarea"
								tagName="span"
								onChange={(value) => setAttributes({ placeholder: value })}
								value={placeholder}
							/>
						) : (
							<RichText
								className="dummy-input"
								tagName="span"
								onChange={(value) => setAttributes({ placeholder: value })}
								value={placeholder}
							/>
						)}
					</div>
				</div>
				<FieldControls attributes={attributes} setAttributes={setAttributes} />
			</>
		);
	},
	save: ({ attributes }) => {
		const { label, required, tagType, placeholder, width } = attributes;
		const blockProps = useBlockProps.save();
		const name = label.replace(/(<([^>]+)>)/gi, "");

		return (
			<div {...blockProps} style={{ width: width ? width + '%' : null }}>
				<div className="beastfeedbacks-survey-input_label">
					<RichText.Content tagName="label" value={label} />{" "}
					{required && (
						<span className="beastfeedbacks-survey-input_label_required">
							(必須)
						</span>
					)}
				</div>
				<div className="beastfeedbacks-survey-input_item">
					{tagType === "textarea" ? (
						<textarea
							name={name}
							rows="3"
							required={required}
							placeholder={placeholder}
						/>
					) : (
						<input
							name={name}
							type={tagType}
							required={required}
							placeholder={placeholder}
						/>
					)}
				</div>
			</div>
		);
	},
});
