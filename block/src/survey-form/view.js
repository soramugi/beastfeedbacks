const form = document.forms["beastfeedbacks_survey_form"];

form.addEventListener("submit", (e) => {
	e.preventDefault();

	const action = form.getAttribute('action');
	fetch(action, {
		method: form.method,
		body: new FormData(form),
	})
		.then((response) => {
			if (!response.ok) {
				console.error(response);
				throw new Error();
			}
			return response.json();
		})
		.then((data) => {
			console.log(data);
			// document.getElementById("message").innerHTML = text;
			// document.forms["enquiry"].style.display = "none";
		})
		.catch((error) => {
			console.error(error);
			// document.getElementById("message").innerHTML = "送信できませんでした";
		});
});
