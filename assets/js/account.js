document.addEventListener("DOMContentLoaded", () => {
    const btnmodal = document.querySelector(".btn-modal")
    const modal = document.querySelector(".modal-delete")
    const cancel = document.querySelector(".cancel")

    btnmodal.addEventListener("click", () => {
        modal.style.display = "flex"
    })
    cancel.addEventListener("click", () => {
        modal.style.display = "none"
    })
})