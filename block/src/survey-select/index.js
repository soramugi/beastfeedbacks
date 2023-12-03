import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";

import metadata from "./block.json";
import "./style.scss";
import FieldControls from "./field-controls";

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

					<div>
						<input type="radio" id="huey" name="drone" value="huey" checked/>
						<label for="huey">Huey</label>
					</div>
					<div>
						<input type="radio" id="dewey" name="drone" value="dewey" />
						<label for="dewey">Dewey</label>
					</div>
					<div>
						<input type="radio" id="louie" name="drone" value="louie" />
						<label for="louie">Louie</label>
					</div>
				</div>
				<FieldControls attributes={attributes} setAttributes={setAttributes} />
			</>
		);
	},
	save: ({ attributes }) => {
		const blockProps = useBlockProps.save();
		const name = attributes.content.replace(/(<([^>]+)>)/gi, "");
		const required = attributes.required;

		return (
			<div {...blockProps}>
				<div style={{ alignItems: "baseline" }}>
					<RichText.Content tagName="label" value={attributes.content} />{" "}
					{required && <span>(必須)</span>}
				</div>

				<div>
					<input type="radio" id="huey" name={name} value="huey" required={ required } />
					<label for="huey">Huey</label>
				</div>
				<div>
					<input type="radio" id="dewey" name={name} required={ required } value="dewey" />
					<label for="dewey">Dewey</label>
				</div>
				<div>
					<input type="radio" id="louie" name={name} required={ required } value="louie" />
					<label for="louie">Louie</label>
				</div>
			</div>
		);
	},
});
