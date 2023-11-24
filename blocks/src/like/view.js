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
				},
				body: JSON.stringify({
					beastfeedbacks: 1,
					nonce,
				}),
			})
				.then((response) => response.json())
				.then((data) => console.log(data));
		};
	}
});
