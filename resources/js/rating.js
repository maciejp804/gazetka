document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('#star-rating span');
    const ratingValueDisplay = document.getElementById('rating-value');
    let selectedRating = 0;

    stars.forEach(star => {
        // Podświetlanie gwiazdek podczas najechania myszką
        star.addEventListener('mouseover', function () {
            resetStars();
            highlightStars(this.dataset.rating);
        });

        // Przywracanie zaznaczonej oceny po opuszczeniu myszki
        star.addEventListener('mouseout', function () {
            resetStars();
            if (selectedRating > 0) {
                highlightStars(selectedRating);
            }
        });

        // Ustawienie oceny po kliknięciu
        star.addEventListener('click', function () {
            selectedRating = this.dataset.rating;
            ratingValueDisplay.textContent = `Ocena: ${selectedRating}`;
        });
    });

    // Funkcja do podświetlania gwiazdek
    function highlightStars(rating) {
        stars.forEach(star => {
            if (star.dataset.rating <= rating) {
                star.classList.add('text-amber-600');
            }
        });
    }

    // Funkcja do resetowania gwiazdek
    function resetStars() {
        stars.forEach(star => {
            star.classList.remove('text-amber-600');
        });
    }
});
