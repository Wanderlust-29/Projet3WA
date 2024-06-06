document.addEventListener("DOMContentLoaded", () => {
    let isOrderArticlesOpen = false;

    function showArticles() {
        document.querySelectorAll(".order-articles").forEach((orderArticles) => {
            orderArticles.style.display = "none";
        });

        function toggleArticles(modalDetail) {
            const orderArticles = modalDetail.nextElementSibling;
            if (
                orderArticles.style.display === "none" ||
                orderArticles.style.display === ""
            ) {
                orderArticles.style.display = "flex";
                isOrderArticlesOpen = true;
            } else {
                orderArticles.style.display = "none";
                isOrderArticlesOpen = false;
            }
        }

        // Function to close modal
        function closeModal(orderArticles) {
            orderArticles.style.display = "none";
            isOrderArticlesOpen = false;
        }

        // Event listener for clicking on modal details
        document.querySelectorAll(".modal-detail").forEach((modalDetail) => {
            modalDetail.addEventListener("click", (event) => {
                event.preventDefault();
                if (!isOrderArticlesOpen) {
                    const orderArticles = modalDetail.nextElementSibling;
                    toggleArticles(modalDetail);
                    event.stopPropagation(); // Empêche la propagation du clic pour ne pas fermer les order-articles
                }
            });
        });

        // Event listener for clicking on close buttons
        document.querySelectorAll(".btn-close-modal").forEach((closeButton) => {
            closeButton.addEventListener("click", (event) => {
                event.preventDefault();
                const orderArticles = closeButton.closest(".order-articles");
                closeModal(orderArticles);
            });
        });

        // Event listener to close order-articles when clicking outside
        document.addEventListener("click", (event) => {
            document.querySelectorAll(".order-articles").forEach((orderArticles) => {
                if (!orderArticles.contains(event.target)) {
                    closeModal(orderArticles);
                }
            });
        });
    }

    showArticles();
});
