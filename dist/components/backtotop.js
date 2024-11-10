import { backToTopBtn } from "../global.js";
function visibleBactToTopButton() {
    if (backToTopBtn && document.documentElement.scrollTop > 20) {
        backToTopBtn.style.display = "inline";
    }
    else if (backToTopBtn) {
        backToTopBtn.style.display = "none";
    }
}
function backToTop() {
    let backToTopTimer = setInterval(function () {
        if (document.documentElement.scrollTop)
            document.documentElement.scrollTop *= 0.97;
        else
            clearInterval(backToTopTimer);
    }, 5);
}
export { visibleBactToTopButton, backToTop };
//# sourceMappingURL=backtotop.js.map