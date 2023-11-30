const addMessage = (form, message) => {
	const messageElement = document.createElement("p");
	messageElement.textContent = message;
	form.parentElement.insertBefore(messageElement, form.nextSibling);
	setTimeout(function () {
		messageElement.style.display = 'none'
	}, 3000);
};

const submit = (e) => {
	e.preventDefault();

	const form = e.target;
	const action = form.getAttribute("action");

	fetch(action, {
		method: form.method,
		body: new FormData(form),
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error(response);
			}
			return response.json();
		})
		.then((data) => {
			if (data.count) {
				const likeCounts = form.querySelectorAll(".like-count");
				for (const likeCount of likeCounts) {
					likeCount.textContent = data.count;
				}
			}

			addMessage(form, data.message);
		})
		.catch((error) => {
			console.error(error);
			addMessage(form, "おっと！なにか問題が発生しました。");
		});
};

// 複数フォームを設定した場合に考慮
const forms = document.querySelectorAll(
	'form[name="beastfeedbacks_like_form"]',
);
for (const form of forms) {
	form.addEventListener("submit", submit);
}
