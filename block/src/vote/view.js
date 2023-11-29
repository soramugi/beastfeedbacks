import apiFetch from "@wordpress/api-fetch";

const elements = document.querySelectorAll(".wp-block-beastfeedbacks-vote");

elements.forEach((element) => {
	const nonce = element.dataset.nonce;
	const id = element.dataset.id;
	const buttons = element.getElementsByTagName("button");

	for (const button of buttons) {
		button.onclick = (event) => {
			const list = [];
			for (const b of buttons) {
				b.setAttribute("disabled", true);
				list.push(b.textContent);
			}

			apiFetch({
				path: "/beastfeedbacks/v1/register",
				method: "POST",
				data: {
					beastfeedbacks_type: "vote",
					nonce,
					id,
					select: list,
					selected: button.textContent,
				},
			}).then((data) => {
				const messageElement = document.createElement("span");
				messageElement.textContent = data.message;
				element.parentElement.insertBefore(messageElement, element.nextSibling);
			});
		};
	}
});
