// Fonction pour gérer le clic sur le bouton "Lire plus"
document.querySelectorAll(".read-more-btn").forEach(button => {
    button.addEventListener("click", function() {
        const moreText = this.previousElementSibling; // Sélectionne le div more-text avant le bouton
        if (moreText.style.display === "block") {
            moreText.style.display = "none";
            this.textContent = "Lire plus";
        } else {
            moreText.style.display = "block";
            this.textContent = "Lire moins";
        }
    });
});
