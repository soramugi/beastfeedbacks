import apiFetch from "@wordpress/api-fetch";

const elements = document.querySelectorAll(".wp-block-beastfeedbacks-like");

elements.forEach((element) => {
	const nonce = element.dataset.nonce;
	const id = element.dataset.id;
	const buttons = element.getElementsByTagName("button");

	for (const button of buttons) {
		button.onclick = (event) => {
			for (const b of buttons) {
				b.setAttribute("disabled", true);
			}

			apiFetch({
				path: "/beastfeedbacks/v1/register",
				method: "POST",
				data: {
					beastfeedbacks_type: "like",
					nonce,
					id,
				},
			}).then((data) => {
				if (data.count) {
					const likeCounts = element.querySelectorAll(".like-count");
					for (const likeCount of likeCounts) {
						likeCount.textContent = data.count;
					}
				}

				const messageElement = document.createElement("span");
				messageElement.textContent = data.message;
				element.parentElement.insertBefore(messageElement, element.nextSibling);
			});
		};
	}
});
