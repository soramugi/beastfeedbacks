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

			fetch("/wp-json/beastfeedbacks/v1/register", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					// "X-WP-Nonce": nonce,
				},
				body: JSON.stringify({
					beastfeedbacks_type: "vote",
					nonce,
					id,
					select: list,
					selected: button.textContent,
				}),
			})
				.then((response) => response.json())
				.then((data) => {
					const messageElement = document.createElement("span");
					messageElement.textContent = data.message;
					element.parentElement.insertBefore(
						messageElement,
						element.nextSibling,
					);
				});
		};
	}
});
