export function initTheaterSelector() {
    const theaterSelect = document.getElementById('theater');
    const capacityValue = document.getElementById('capacity-value');

    if (!theaterSelect) return; // Safety check

    theaterSelect.addEventListener('change', function() {
        const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
        const capacity = selectedOption.getAttribute('data-capacity');

        if (capacity) {
            capacityValue.textContent = capacity;
        }
    });
}