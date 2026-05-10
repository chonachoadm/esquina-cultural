import './bootstrap';

import TomSelect from 'tom-select';

function initTheaterSelector() {
    const theaterSelect = document.getElementById('theater');
    const capacityValue = document.getElementById('capacity-value');

    if (!theaterSelect) return;

    // Show capacity for initially selected theater
    const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
    if (selectedOption.getAttribute('data-capacity')) {
        capacityValue.textContent = selectedOption.getAttribute('data-capacity');
    }

    // Update capacity when selection changes
    theaterSelect.addEventListener('change', function() {
        const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
        const capacity = selectedOption.getAttribute('data-capacity');
        if (capacity) {
            capacityValue.textContent = capacity;
        }
    });
}


// function initPerformanceGenerator() {
//     const performances = [];
//     const days = document.querySelectorAll('[id^="day-"]');
//     const timeContainer = document.getElementById('perf-times-container')
//     console.log(days);
//     function timeGenerator(event) {
//         const checkbox = event.target; // The specific checkbox changed
//         const dayValue = checkbox.value;
//         const wrapperId = `wrapper-${dayValue}`;
//         const dayName = checkbox.labels[0].textContent;

//         if (checkbox.checked) {
//             // Create a wrapper div to group the label and input
//             let wrapper = document.createElement('div');
//             wrapper.id = wrapperId;

//             let dayLabel = document.createElement('label');
//             dayLabel.textContent = `Horario para ${dayName}: `;
//             dayLabel.htmlFor = `perf-time-${dayValue}`;

//             let dayInput = document.createElement('input');
//             dayInput.id = `perf-time-${dayValue}`;
//             dayInput.name = `perf_times[${dayValue}]`; // Saves as ['Monday' => '12:00']
//             dayInput.type = "time";

//             wrapper.append(dayLabel, dayInput);
//             timeContainer.append(wrapper);
//         } else {
//             // If unchecked, find that specific wrapper and kill it
//             const wrapperToRemove = document.getElementById(wrapperId);
//             if (wrapperToRemove) {
//                 wrapperToRemove.remove();
//             }
//         }
//     }
//     for(const input of days) {
//         input.addEventListener('change', timeGenerator)
//     } 
// }
function initPerformanceGenerator() {
    const days = document.querySelectorAll('[id^="day-"]');
    const timeContainer = document.getElementById('perf-times-container');
    const startDateInput = document.getElementById('start-date'); // Assuming these IDs
    const endDateInput = document.getElementById('end-date');

    function generatePerformanceList() {
        // Clear previous results
        timeContainer.innerHTML = '';
        
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        if (isNaN(start) || isNaN(end)) return; // Don't run if dates aren't set

        for (const checkbox of days) {
            if (checkbox.checked) {
                const targetDay = parseInt(checkbox.value); // 0 = Sunday, 1 = Monday, etc.
                const dayName = checkbox.labels[0].textContent;

                // Create a wrapper for this day's settings
                let dayWrapper = document.createElement('div');
                dayWrapper.innerHTML = `<h4>Funciones para los días ${dayName}</h4>`;
                
                // Add a time input for this specific weekday
                let timeInput = document.createElement('input');
                timeInput.type = "time";
                timeInput.name = `day_times[${targetDay}]`;
                timeInput.required = true;
                
                // When the time changes, we could technically pre-calculate the list
                dayWrapper.append(timeInput);
                timeContainer.append(dayWrapper);
            }
        }
    }

    // Listen for changes on everything
    days.forEach(d => d.addEventListener('change', generatePerformanceList));
    startDateInput.addEventListener('change', generatePerformanceList);
    endDateInput.addEventListener('change', generatePerformanceList);
}

document.addEventListener('DOMContentLoaded', function () {
    initTheaterSelector();
    initPerformanceGenerator();

    const el = document.getElementById('staff-search');
    if (el) {
        const tomSelectInstance = new TomSelect(el, {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            clearValueOnItemAdd: true,
            // Fetch data from our Laravel API
            load: function(query, callback) {
                const url = '/api/users/search?q=' + encodeURIComponent(query);
                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        callback(json);
                    }).catch(() => {
                        callback();
                    });
            },
            // This part creates the UI with the image
            render: {
                option: function(item, escape) {
                    return `<div>
                                <img src="${escape(item.avatar)}" alt="">
                                <span>${escape(item.name)}</span>
                            </div>`;
                },
                item: function(item, escape) {
                    return `<div class="selected-staff-item">${escape(item.name)}</div>`;
                }
            }
        });

        // Listen for item additions and removals
        tomSelectInstance.on('item_add', function(value, item) {
            const container = document.getElementById('staff-roles-container');
            // Get the full item data from Tom Select options
            const itemData = tomSelectInstance.options[value];
            const itemName = itemData ? itemData.name : 'Staff Member';
            
            const roleInput = document.createElement('div');
            roleInput.id = `role-wrapper-${value}`;
            roleInput.innerHTML = `
                <label for="staff_role_${value}">Rol para ${itemName}</label>
                <input type="text" id="staff_role_${value}" name="staff_roles[${value}]" placeholder="Ej: Actor, Director, Productor" />
            `;
            container.appendChild(roleInput);
            
            // Clear the search input
            tomSelectInstance.setTextboxValue('');
        });

        tomSelectInstance.on('item_remove', function(value) {
            const wrapper = document.getElementById(`role-wrapper-${value}`);
            if (wrapper) wrapper.remove();
        });
    }
});