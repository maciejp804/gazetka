document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#star-rating span');
    const ratingForm = document.getElementById('ratingForm');
    const ratingInput = document.getElementById('selectedRatingInput');

    // Pobrana z backendu średnia ocena (do podświetlenia na starcie)
    // Załóżmy, że jest to liczba całkowita lub zaokrąglamy do najbliższej:


    let hoveredRating = 0;   // Ocena przy najechaniu myszką
    let selectedRating = 0;  // Ocena faktycznie kliknięta

    /**
     * FUNKCJA PODŚWIETLAJĄCA GWIAZDKI
     */
    function highlightStars(rating) {
        stars.forEach(star => {
            const starValue = parseInt(star.getAttribute('data-rating'));
            if (starValue <= rating) {
                star.classList.add('text-amber-600'); // np. bursztynowy kolor
            } else {
                star.classList.remove('text-amber-600');
            }
        });
    }

    /**
     * PODŚWIETLENIE GWIAZDEK NA PODSTAWIE ŚREDNIEJ OCENY
     * (wywołujemy to raz po załadowaniu)
     */
    highlightStars(averageRating);

    /**
     * OBSŁUGA ZDARZEŃ MYSZKI
     */
    stars.forEach(star => {
        // 1. Najechanie myszką
        star.addEventListener('mouseover', () => {
            hoveredRating = parseInt(star.getAttribute('data-rating'));
            highlightStars(hoveredRating);
        });

        // 2. Wyjechanie myszką
        star.addEventListener('mouseout', () => {
            if (selectedRating > 0) {
                // Jeśli użytkownik już kliknął, przywracamy jego kliknięcie
                highlightStars(selectedRating);
            } else {
                // W przeciwnym razie przywracamy średnią ocenę
                highlightStars(averageRating);
            }
        });

        // 3. Kliknięcie (ustawiamy ocenę, wysyłamy formularz)
        star.addEventListener('click', () => {
            selectedRating = parseInt(star.getAttribute('data-rating'));
            highlightStars(selectedRating);

            // Przypisujemy oceny do hidden input i submitujemy
            ratingInput.value = selectedRating;
            ratingForm.submit();
        });
    });
    console.log("✅ Rating został zainicjalizowany.");
});
