import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
	useBlockProps,
	RichText,
	BlockControls,
} from "@wordpress/block-editor";
import { Icon, check } from "@wordpress/icons";
import metadata from "./block.json";
import "./style.scss";
import TagTypeDropdown from "./tag-type-dropdown";

/**
 * アンケートフォームの選択肢
 * TODO: 選択肢関連の対応、select,checkbox,radio
 */
registerBlockType(metadata.name, {
	/**
	 * @see https://developer.wordpress.org/resource/dashicons/
	 */
	icon: 'yes',

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
	},

	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();

		return (
			<>
				{
					<BlockControls group="other">
						<TagTypeDropdown
							value={attributes.tagType}
							onChange={(type) => {
								setAttributes({ tagType: type });
							}}
						/>
					</BlockControls>
				}
				<p {...blockProps}>
					<RichText
						tagName="label"
						onChange={(newContent) => {
							setAttributes({ content: newContent });
						}}
						value={attributes.content}
					/>

					<div>
						<input type="radio" id="huey" name="drone" value="huey" checked />
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
				</p>
			</>
		);
	},
	save: ({ attributes }) => {
		const blockProps = useBlockProps.save();
		const name = attributes.content.replace(/(<([^>]+)>)/gi, "");

		return (
			<p {...blockProps}>
				<RichText.Content tagName="label" value={attributes.content} />

				<div>
					<input type="radio" id="huey" name={name} value="huey" checked />
					<label for="huey">Huey</label>
				</div>
				<div>
					<input type="radio" id="dewey" name={name} value="dewey" />
					<label for="dewey">Dewey</label>
				</div>
				<div>
					<input type="radio" id="louie" name={name} value="louie" />
					<label for="louie">Louie</label>
				</div>
			</p>
		);
	},
});
