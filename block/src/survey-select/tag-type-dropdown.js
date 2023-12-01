import { ToolbarDropdownMenu } from "@wordpress/components";
import { __, sprintf } from "@wordpress/i18n";

const POPOVER_PROPS = {
	position: "bottom right",
};
const TAG_TYPES = ["select", "radio", "checkbox"];

/** @typedef {import('react').ComponentType} ComponentType */

export default function TagTypeDropdown({
	options = TAG_TYPES,
	value,
	onChange,
}) {
	return (
		<ToolbarDropdownMenu
			label="タイプ"
			text="タイプ"
			icon={null}
			popoverProps={POPOVER_PROPS}
			controls={options.map((targetTagType) => {
				const isActive = targetTagType === value;

				return {
					title: targetTagType,
					isActive,
					onClick() {
						onChange(targetTagType);
					},
					role: "menuitemradio",
				};
			})}
		/>
	);
}
