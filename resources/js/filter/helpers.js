export function debounce(func, delay) {
    let debounceTimer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}

export function toggleInputStyle(input, isResultsVisible) {
    input.classList.toggle("rounded-3xl", !isResultsVisible);
    input.classList.toggle("rounded-t-3xl", isResultsVisible);
    input.classList.toggle("border-t", isResultsVisible);
    input.classList.toggle("border-l", isResultsVisible);
    input.classList.toggle("border-r", isResultsVisible);
}

export function restoreInputStyle(input, resultsBox, hideResultsBox = true) {
    if (!input || !resultsBox) return;

    if (hideResultsBox && resultsBox.innerHTML.trim() === "") {
        resultsBox.classList.add("hidden");
        toggleInputStyle(input, false);
    } else {
        const items = resultsBox.querySelectorAll(".bg-gray-200");
        items.forEach(item => item.classList.remove("bg-gray-200"));
    }
}

export function setupKeyboardNavigation(input, resultsBox) {
    const resultsItems = resultsBox.querySelectorAll("a.item");
    let focusedResultIndex = -1;

    function focusResult(index) {
        resultsItems.forEach((item, i) => {
            if (i === index) {
                item.classList.add("bg-gray-200");
                item.focus();
            } else {
                item.classList.remove("bg-gray-200");
            }
        });
    }

    input.addEventListener("keydown", function (event) {
        if (event.key === "ArrowDown" && resultsItems.length > 0) {
            event.preventDefault();
            focusedResultIndex = 0;
            focusResult(focusedResultIndex);
        }
    });

    resultsItems.forEach((item, index) => {
        item.addEventListener("keydown", function (event) {
            if (event.key === "ArrowDown") {
                event.preventDefault();
                focusedResultIndex = (focusedResultIndex + 1) % resultsItems.length;
                focusResult(focusedResultIndex);
            } else if (event.key === "ArrowUp") {
                event.preventDefault();
                if (focusedResultIndex === 0) {
                    input.focus();
                    restoreInputStyle(input, resultsBox, false);
                } else {
                    focusedResultIndex = (focusedResultIndex - 1 + resultsItems.length) % resultsItems.length;
                    focusResult(focusedResultIndex);
                }
            } else if (event.key === "Escape") {
                input.focus();
                restoreInputStyle(input, resultsBox);
            } else if (event.key === "Enter") {
                event.preventDefault();
                item.click();
            }
        });
    });
}

export function updateSwiperContent(swiperInstance, html) {
    const wrapper = swiperInstance.el.querySelector('.swiper-wrapper');
    wrapper.innerHTML = html;
    swiperInstance.update();
}

