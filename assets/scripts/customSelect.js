const Datepicker = new AirDatepicker("#datepicker", {
    range: true,
    multipleDatesSeparator: ' - ',
    classes: "custom-datepicker",
    container: "#datepicker-container"
})

const cells = document.querySelectorAll(".air-datepicker-cell")

cells.forEach((cell) => {
    cell.addEventListener("click", () => {
        console.log(Datepicker.selectedDates)
    })
})