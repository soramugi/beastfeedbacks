import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import "./editor.scss";

export default function Edit() {
	return (
		<Button {...useBlockProps()} variant="primary">
			Like
		</Button>
	);
}
