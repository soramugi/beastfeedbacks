const elements = document.querySelectorAll(".wp-block-beastfeedbacks-like");

elements.forEach((element) => {
	const nonce = element.dataset.nonce;
	const buttons = element.getElementsByTagName("button");

	for (const button of buttons) {
		button.onclick = (event) => {
			button.setAttribute("disabled", true);

			fetch("/wp-json/beastfeedbacks/v1/register", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					// "X-WP-Nonce": nonce,
				},
				body: JSON.stringify({
					beastfeedbacks: 1,
					nonce,
				}),
			})
				.then((response) => response.json())
				.then((data) => {
					if (!data.success) {
						return;
					}
					const elems = button.getElementsByClassName("count");
					for (const elem of elems) {
						elem.textContent = data.count;
					}
					const messages =
						button.parentElement.getElementsByClassName("message");
					for (const message of messages) {
						message.style.display = "block";
					}
				});
		};
	}
});
