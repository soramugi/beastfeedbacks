/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./blocks/src/like/view.js ***!
  \*********************************/
const elements = document.querySelectorAll(".beastfeedbacks-button-like");
elements.forEach(element => {
  element.onclick = function handleClick(event) {
    fetch("/wp-json/beastfeedbacks/v1/like", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      }
      // body: JSON.stringify({ postID: props.clientId }),
    }).then(response => response.json()).then(data => console.log(data));
  };
});
/******/ })()
;
//# sourceMappingURL=view.js.map