import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import metadata from "./block.json";

import "./style.scss";

/**
 * Likeボタンの実装
 *
 * ダイナミックブロックとして実装、表示部分は以下で設定
 * @see BeastFeedbacks_Blocks::render_callback_like
 */
registerBlockType(metadata.name, {
	edit: () => {
		const blockProps = useBlockProps();

		return (
			<div {...blockProps}>
				<Button>Like</Button>
			</div>
		);
	},
});
