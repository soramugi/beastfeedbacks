import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";

import metadata from "./block.json";
import "./style.scss";
import FieldControls from "./field-controls";
import EditListBlock from "./edit-list-block";


function GenerateStyle({layout}) {
	const display = layout?.type ?? 'flex';
	const flexFlow = layout?.orientation === 'vertical' ? 'column' : null;
	const justifyContent = layout?.justifyContent;
	const flexWrap = layout?.flexWrap ?? 'wrap';

	const style = {
		display,
		flexFlow,
		justifyContent,
		flexWrap,
	};

	if ('space-between' === justifyContent) {
		style.width = '100%';
	}

	return style;
}

/**
 * アンケートフォームの選択肢
 */
registerBlockType(metadata.name, {
	/**
	 * @see https://developer.wordpress.org/resource/dashicons/
	 */
	icon: "yes",

	attributes: {
		label: {
			type: "string",
			default: "サンプル選択肢",
		},
		tagType: {
			type: "string",
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
		width: {
			type: "number",
		},
	},

	edit: ({ attributes, setAttributes, isSelected }) => {
		const { width } = attributes;
		const blockProps = useBlockProps();
		const childStyle = GenerateStyle(attributes);

		return (
			<>
				<div {...blockProps} style={{ width: width ? width + '%' : null }}>
					<div className="beastfeedbacks-survey-select_label">
						<RichText
							tagName="label"
							onChange={(value) => {
								setAttributes({ label: value });
							}}
							value={attributes.label}
						/>
						{attributes.required && (
							<span className="beastfeedbacks-survey-select_label_required">
								(必須)
							</span>
						)}
					</div>

					<EditListBlock
						style={childStyle}
						isSelected={isSelected}
						attributes={attributes}
						setAttributes={setAttributes}
					/>
				</div>
				<FieldControls attributes={attributes} setAttributes={setAttributes} />
			</>
		);
	},
	save: ({ attributes }) => {
		const { label, items, required, tagType, width } = attributes;
		const childStyle = GenerateStyle(attributes);

		const blockProps = useBlockProps.save();
		let name = label.replace(/(<([^>]+)>)/gi, "");
		if (tagType === "checkbox") {
			name += "[]";
		}

		return (
			<div {...blockProps} style={{ width: width ? width + '%' : null }}>
				<div className="beastfeedbacks-survey-select_label">
					<RichText.Content tagName="label" value={label} />
					{required && (
						<span className="beastfeedbacks-survey-select_label_required">
							(必須)
						</span>
					)}
				</div>

				<div className="beastfeedbacks-survey-select_items" style={childStyle}>
					{"select" === tagType ? (
						<div className="beastfeedbacks-survey-select_item select_wrap">
							<select name={name} required={required}>
								<option value="">選択してください</option>
								{items.map((value) => (
									<option value={value}>{value}</option>
								))}
							</select>
						</div>
					) : (
						items.map((value, index) => (
							<div className="beastfeedbacks-survey-select_item">
								<label for={value}>
									<input
										type={tagType}
										name={name}
										id={value}
										value={value}
										required={required}
									/>
									<RichText.Content tagName="span" value={value} />
								</label>
							</div>
						))
					)}
				</div>
			</div>
		);
	},
});
