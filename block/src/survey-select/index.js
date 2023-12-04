import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { isEmpty, tap, noop, split, trim } from "lodash";
import { useEffect, useRef } from "@wordpress/element";

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
		options: {
			type: "array",
			default: [""],
		},
	},

	edit: ({ attributes, setAttributes }) => {
		const { options } = attributes;

		const setFocus = (wrapper, selector, index, cursorToEnd) =>
			setTimeout(() => {
				tap(wrapper.querySelectorAll(selector)[index], (input) => {
					if (!input) {
						return;
					}

					input.focus();

					// Allows moving the cursor to the end of
					// 'contenteditable' elements like <RichText />
					if (document.createRange && cursorToEnd) {
						const range = document.createRange();
						range.selectNodeContents(input);
						range.collapse(false);
						const selection = document.defaultView.getSelection();
						selection.removeAllRanges();
						selection.addRange(range);
					}
				});
			}, 0);

		const blockProps = useBlockProps();
		const optionsWrapper = useRef();
		const changeFocus = (index, cursorToEnd) =>
			setFocus(optionsWrapper.current, "[role=textbox]", index, cursorToEnd);
		const handleSingleValue = (index, value) => {
			const _options = [...options];

			_options[index] = value;

			setAttributes({ options: _options });
			changeFocus(index);
		};

		const handleMultiValues = (index, array) => {
			const _options = [...attributes.options];
			const cursorToEnd = array[array.length - 1] !== "";

			if (_options[index]) {
				_options[index] = array.shift();
				index++;
			}

			_options.splice(index, 0, ...array);

			setAttributes({ options: _options });
			changeFocus(index + array.length - 1, cursorToEnd);
		};

		const handleChangeOption = (index) => (value) => {
			const values = split(value, "\n").filter((op) => op && trim(op) !== "");

			if (!values.length) {
				return;
			}

			if (values.length > 1) {
				handleMultiValues(index, values);
			} else {
				handleSingleValue(index, values.pop());
			}
		};

		const handleSplitOption = (index) => (value, isOriginal) => {
			if (!isOriginal) {
				return;
			}

			const splitValue = attributes.options[index].slice(value.length);

			if (isEmpty(value) && isEmpty(splitValue)) {
				return;
			}

			handleMultiValues(index, [value, splitValue]);
		};

		const handleDeleteOption = (index) => () => {
			if (attributes.options.length === 1) {
				return;
			}

			const _options = [...attributes.options];
			_options.splice(index, 1);
			setAttributes({ options: _options });
			changeFocus(Math.max(index - 1, 0), true);
		};

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

					<div className="jetpack-field-dropdown__popover" ref={optionsWrapper}>
						{attributes.options.map((value, index) => (
							<div>
								<input type="radio" />
								<RichText
									tagName="label"
									key={index}
									value={value}
									onChange={handleChangeOption(index)}
									onSplit={handleSplitOption(index)}
									onRemove={handleDeleteOption(index)}
									onReplace={noop}
									placeholder={"項目追加"}
									__unstableDisableFormats
								/>
							</div>
						))}
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

				<div className="jetpack-field-dropdown__popover">
					{attributes.options.map((value, index) => (
						<div>
							<input
								type="radio"
								id={value}
								name={name}
								value={value}
								required={required}
							/>
							<RichText.Content
								tagName="label"
								key={index}
								value={value}
								for={value}
							/>
						</div>
					))}
				</div>
			</div>
		);
	},
});
