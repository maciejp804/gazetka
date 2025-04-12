import Sortable from "sortablejs";

// Inicjalizacja SortableJS
let list = document.getElementById('sortable-pages');
new Sortable(list, {
    animation: 150, // Animacja podczas przeciągania
    ghostClass: 'bg-blue-500', // Klasa dla przeciąganego elementu
    onStart: function(evt) {
        // Możesz usunąć ten kod, ponieważ SortableJS automatycznie ustawia draggable
        // let items = evt.from.children;
        // Array.from(items).forEach(item => {
        //     item.setAttribute('draggable', 'true');
        // });
    },
    onEnd: function(evt) {
        // Zmieniamy kolejność na podstawie nowego porządku
        const orderInputs = document.querySelectorAll('input[name="pages[]"]');
        const sortOrderInputs = document.querySelectorAll('input[name="sort_order[]"]');

        // Zaktualizowanie wartości 'pages[]' i 'sort_order[]' zgodnie z nową kolejnością
        orderInputs.forEach((input, index) => {
            input.value = evt.from.children[index].dataset.id; // Zmieniamy ID w inputach
        });

        sortOrderInputs.forEach((input, index) => {
            input.value = index; // Zmieniamy sort_order zgodnie z nową kolejnością
        });
    }
});
