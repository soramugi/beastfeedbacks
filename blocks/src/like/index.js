import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import metadata from "./block.json";

import "./style.scss";

registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return <Button {...blockProps}>Like</Button>;
	},
});
