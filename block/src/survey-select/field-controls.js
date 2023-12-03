import { __ } from "@wordpress/i18n";
import { BlockControls, InspectorControls } from "@wordpress/block-editor";
import {
	PanelBody,
	ToggleControl,
	ToolbarGroup,
	ToolbarButton,
	Path,
} from "@wordpress/components";
import TagTypeDropdown from "./tag-type-dropdown";

export default function FieldControls({ attributes, setAttributes }) {
	return (
		<>
			<InspectorControls>
				<PanelBody title={"フィールド設定"}>
					<ToggleControl
						label={"必須入力"}
						className="label__required"
						checked={attributes.required}
						onChange={(value) => setAttributes({ required: value })}
						help={__(
							'You can edit the "required" label in the editor',
							"beastfeedbacks",
						)}
					/>
				</PanelBody>
			</InspectorControls>

			<BlockControls>
				<ToolbarGroup>
					<TagTypeDropdown
						value={attributes.tagType}
						onChange={(type) => {
							setAttributes({ tagType: type });
						}}
					/>
				</ToolbarGroup>
				<ToolbarGroup>
					<ToolbarButton
						title={"必須"}
						label={"必須"}
						text={"必須"}
						icon={null}
						onClick={() => {
							setAttributes({ required: !attributes.required });
						}}
						className={attributes.required ? "is-pressed" : undefined}
					/>
				</ToolbarGroup>
			</BlockControls>
		</>
	);
}
