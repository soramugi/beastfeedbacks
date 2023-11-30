const form = document.forms["beastfeedbacks_survey_form"];

const addMessage = (message) => {
	const messageElement = document.createElement("span");
	messageElement.textContent = message;
	form.parentElement.insertBefore(messageElement, form.nextSibling);
};

form.addEventListener("submit", (e) => {
	e.preventDefault();
	e.submitter.setAttribute("disabled", true);

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
			addMessage(data.message);
		})
		.catch((error) => {
			console.error(error);
			addMessage('おっと！なにか問題が発生しました。');
		});
});
