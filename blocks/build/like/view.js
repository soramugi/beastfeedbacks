/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./blocks/src/like/view.js ***!
  \*********************************/
const elements = document.querySelectorAll(".wp-block-beastfeedbacks-like");
elements.forEach(element => {
  const nonce = element.dataset.nonce;
  const id = element.dataset.id;
  const buttons = element.getElementsByTagName("button");
  for (const button of buttons) {
    button.onclick = event => {
      button.setAttribute("disabled", true);
      fetch("/wp-json/beastfeedbacks/v1/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
          // "X-WP-Nonce": nonce,
        },

        body: JSON.stringify({
          beastfeedbacks_type: "like",
          nonce,
          id
        })
      }).then(response => response.json()).then(data => {
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
/******/ })()
;
//# sourceMappingURL=view.js.map