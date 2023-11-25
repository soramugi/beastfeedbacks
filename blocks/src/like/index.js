import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import { select, useSelect } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";
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

		const post = select("core/editor").getCurrentPost();
		console.log(post.guid);

		return (
			<div {...blockProps}>
				<Button>Like</Button>
			</div>
		);
	},
});
