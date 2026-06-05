import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import TomSelect from 'tom-select';

// Function to get and show the max capacity of the selected theater
function initTheaterSelector() {
    const theaterSelect = document.getElementById('theater');
    const capacityValue = document.getElementById('capacity-value');
    if (!theaterSelect) return;
    const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
    if (selectedOption.getAttribute('data-capacity')) {
        capacityValue.textContent = selectedOption.getAttribute('data-capacity');
    }
    theaterSelect.addEventListener('change', function() {
        const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
        const capacity = selectedOption.getAttribute('data-capacity');
        if (capacity) {
            capacityValue.textContent = capacity;
        }
    });
}

// Function to generate performances start_times based on the start and end dates, the days of the week and the time of each day
function initPerformanceGenerator() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    if (!startDateInput || !endDateInput) return;

    const days = document.querySelectorAll('[id^="day-"]');
    const timeContainer = document.getElementById('perf-times-container');

    function generatePerformanceList() {
        timeContainer.innerHTML = '';   
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        if (isNaN(start) || isNaN(end)) return;
        for (const checkbox of days) {
            if (checkbox.checked) {
                const targetDay = parseInt(checkbox.value);
                const dayName = checkbox.labels[0].textContent;
                let dayWrapper = document.createElement('div');
                dayWrapper.innerHTML = `<h4>Funciones para los días ${dayName}</h4>`;
                let timeInput = document.createElement('input');
                timeInput.type = "time";
                timeInput.name = `day_times[${targetDay}]`;
                timeInput.required = true;
                dayWrapper.append(timeInput);
                timeContainer.append(dayWrapper);
            }
        }
    }
    days.forEach(day => day.addEventListener('change', generatePerformanceList));
    startDateInput.addEventListener('change', generatePerformanceList);
    endDateInput.addEventListener('change', generatePerformanceList);
}

// Function to the edit performances form
function initPerformanceEditor() {
    const addPerformancesForm = document.getElementById('add-performances-form');
    if (!addPerformancesForm) return;

    let newPerformances = [];

    const addPerformanceBtn = document.getElementById('btn-add-performance');
    const performancesToAdd = document.getElementById('performances-to-add');
    const newPerformancesListDiv = document.getElementById('new-performances-list');
    const submitPerformancesBtn = document.getElementById('btn-submit-performances');
    const perfDateInput = document.getElementById('perf-date');
    const perfTimeInput = document.getElementById('perf-time');

    if (!addPerformanceBtn) return;

    function renderNewPerformances() {
        performancesToAdd.innerHTML = '';
        newPerformances.forEach((perf, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <span>${perf.start_time}</span>
                <button type="button" class="remove-perf-btn" data-index="${index}">X</button>
            `;
            performancesToAdd.append(li);
        });
        if (newPerformances.length > 0) {
            newPerformancesListDiv.style.display = 'block';
            submitPerformancesBtn.style.display = 'block';
        } else {
            newPerformancesListDiv.style.display = 'none';
            submitPerformancesBtn.style.display = 'none';
        }
    }

    addPerformanceBtn.addEventListener('click', function() {
        const date = perfDateInput.value;
        const time = perfTimeInput.value;
        if (!date || !time) {
            alert('Por favor completa la fecha y la hora');
            return;
        }
        const startTime = `${date} ${time}:00`;
        const exists = newPerformances.some(p => p.start_time === startTime);
        if (exists) {
            alert('Esta función ya ha sido agregada');
            return;
        }
        newPerformances.push({ start_time: startTime });
        renderNewPerformances();
        perfDateInput.value = '';
        perfTimeInput.value = '';
    });

    performancesToAdd.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-perf-btn')) {
            const index = parseInt(event.target.dataset.index);
            newPerformances.splice(index, 1);
            renderNewPerformances();
        }
    });

    addPerformancesForm.addEventListener('submit', function(event) {
        event.preventDefault();
        newPerformances.forEach((perf, index) => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `new_performances[${index}]`;
            hiddenInput.value = perf.start_time;
            this.append(hiddenInput);
        });
        this.submit();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initTheaterSelector();
    initPerformanceGenerator();
    initPerformanceEditor();
    const el = document.getElementById('staff-search');
    if (el) {
        const tomSelectInstance = new TomSelect(el, {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            clearValueOnItemAdd: true,
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
        tomSelectInstance.on('item_add', function(value, item) {
            const container = document.getElementById('staff-roles-container');
            const itemData = tomSelectInstance.options[value];
            const itemName = itemData ? itemData.name : 'Staff Member';
            const roleInput = document.createElement('div');
            roleInput.id = `role-wrapper-${value}`;
            roleInput.innerHTML = `
                <label for="staff_role_${value}">Rol para ${itemName}</label>
                <input type="text" id="staff_role_${value}" name="staff_roles[${value}]" placeholder="Ej: Actor, Director, Productor" />
            `;
            container.appendChild(roleInput);
            tomSelectInstance.setTextboxValue('');
        });
        tomSelectInstance.on('item_remove', function(value) {
            const wrapper = document.getElementById(`role-wrapper-${value}`);
            if (wrapper) wrapper.remove();
        });
    }
});

// Function to edit staff form
document.querySelectorAll('.remove-user-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        const id = this.dataset.userId; 
        if (confirm('¿Estás seguro?')) {
            const listItem = document.querySelector(`li[data-user-id="${id}"]`);
            if (listItem) listItem.remove();
            const select = document.getElementById('staff-search');
            const option = select.querySelector(`option[value="${id}"]`);
            if (option) {
                option.remove();
            }
        }
    });
});
const staffForm = document.getElementById('staff-form');
if (staffForm) {
    staffForm.addEventListener('submit', function(event) {
        const staffList = document.getElementById('current-staff-list');
        const staffItems = staffList.querySelectorAll('li[data-user-id]');
        staffItems.forEach(item => {
            const userId = item.dataset.userId;
            const role = item.querySelector('small').textContent;
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'staff_ids[]';
            hiddenId.value = userId;
            this.append(hiddenId);
            const hiddenRole = document.createElement('input');
            hiddenRole.type = 'hidden';
            hiddenRole.name = `staff_roles[${userId}]`;
            hiddenRole.value = role;
            this.append(hiddenRole);
        });
    });
}