import apiFetch from "@wordpress/api-fetch";

const elements = document.querySelectorAll(".wp-block-beastfeedbacks-like");

elements.forEach((element) => {
	element.onclick = (event) => {
		apiFetch({
			path: "/beastfeedbacks/v1/like",
			method: "POST",
			data: { title: "New Post Title" },
		}).then((res) => {
			console.log(res);
		});

		// fetch("/wp-json/beastfeedbacks/v1/like", {
		// 	method: "POST",
		// 	headers: {
		// 		"Content-Type": "application/json",
		// 	},
		// 	// body: JSON.stringify({ postID: props.clientId }),
		// })
		// 	.then((response) => response.json())
		// 	.then((data) => console.log(data));
	};
});
