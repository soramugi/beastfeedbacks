import { isEmpty, tap, noop, split, trim } from "lodash";
import { useRef } from "@wordpress/element";
import { RichText } from "@wordpress/block-editor";
import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

const setFocus = (wrapper, selector, index, cursorToEnd) => {
	setTimeout(() => {
		tap(wrapper.querySelectorAll(selector)[index], (input) => {
			if (!input) {
				return;
			}

			input.focus();

			// 全削除
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
};

export default function EditListBlock({
	style,
	attributes,
	setAttributes,
	isSelected,
}) {
	const setItems = (items) => setAttributes({ items });
	const { items, tagType } = attributes;

	const itemsRef = useRef();
	const changeFocus = (index, cursorToEnd) =>
		setFocus(itemsRef.current, "[role=textbox]", index, cursorToEnd);

	const handleSingleValue = (index, value) => {
		const _items = [...items];
		_items[index] = value;

		setItems(_items);
		changeFocus(index);
	};

	const handleMultiValues = (index, array) => {
		const _items = [...items];
		const cursorToEnd = array[array.length - 1] !== "";

		if (_items[index]) {
			_items[index] = array.shift();
			index++;
		}

		_items.splice(index, 0, ...array);

		setItems(_items);
		changeFocus(index + array.length - 1, cursorToEnd);
	};

	const handleChange = (index) => (value) => {
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

	const handleSplit = (index) => (value, isOriginal) => {
		if (!isOriginal) {
			return;
		}

		const splitValue = items[index].slice(value.length);

		if (isEmpty(value) && isEmpty(splitValue)) {
			return;
		}

		handleMultiValues(index, [value, splitValue]);
	};

	const handleDelete = (index) => () => {
		if (items.length === 1) {
			return;
		}

		const _items = [...items];
		_items.splice(index, 1);
		setItems(_items);
		changeFocus(Math.max(index - 1, 0), true);
	};

	console.log(style);

	return (
		<div
			ref={itemsRef}
			className="beastfeedbacks-survey-select_items"
			style={style}
		>
			{"select" === tagType && (
				<div className="beastfeedbacks-survey-select_item select_wrap">
					<div className="dummy-select">選択してください</div>
				</div>
			)}

			{("select" !== tagType || isSelected) &&
				items.map((value, index) => (
					<div className="beastfeedbacks-survey-select_item">
						{"select" === tagType ? "・" : <input type={tagType} />}
						<RichText
							tagName="label"
							key={index}
							value={value}
							onChange={handleChange(index)}
							onSplit={handleSplit(index)}
							onRemove={handleDelete(index)}
							onReplace={noop}
							placeholder={"項目追加"}
							__unstableDisableFormats
						/>
					</div>
				))}
		</div>
	);
}
