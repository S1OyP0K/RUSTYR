// Правильнее конечно по id искать т.к. может быть не один попап, но в моем случае я знаю что он будет один
const popupWrapper = document.querySelector(".popup-wrapper")
const popup = document.querySelector(".popup")
const openPopup = document.querySelectorAll(".open-popup")
const closePopupButton = document.querySelector(".close-popup")

popup.addEventListener("click", (e) => [
    e.stopPropagation()
])

openPopup.forEach((button) => {
    button.addEventListener("click", () => {
        popupWrapper.classList.toggle("_closed")
        popupWrapper.classList.toggle("_opened")
        document.body.classList.toggle("overflow-hidden")
    })
})

popupWrapper.addEventListener("click", () => {
    closePopup()
})

closePopupButton.addEventListener("click", () => {
    closePopup()
})

function closePopup() {
    popupWrapper.classList.add("_closed")
    popupWrapper.classList.remove("_opened")
    document.body.classList.remove("overflow-hidden")
}