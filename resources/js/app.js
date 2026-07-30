import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import TomSelect from 'tom-select';
import './map-view.js'
import './navbar.js'
import './ticket-scanner.js'

function initTheaterSelector() {
    const theaterSelect = document.getElementById('theater');
    const capacityValue = document.getElementById('capacity-value');
    if (!theaterSelect) return;
    const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
    if (selectedOption.getAttribute('data-capacity')) {
        capacityValue.textContent = "Capacidad: " + selectedOption.getAttribute('data-capacity') + " localidades";
    }
    theaterSelect.addEventListener('change', function () {
        const selectedOption = theaterSelect.options[theaterSelect.selectedIndex];
        const capacity = selectedOption.getAttribute('data-capacity');
        if (capacity) {
            capacityValue.textContent = "Capacidad: " + capacity + " localidades";
        }
    });
}

function initPerformanceGeneratorAdmin() {
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

function initPerformanceGeneratorPublic() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (!startDateInput || !endDateInput) return;

    const days = document.querySelectorAll('[id^="day-"]');

    function generatePerformanceList() {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        if (isNaN(start) || isNaN(end)) return;

        days.forEach(checkbox => {
            const targetDay = parseInt(checkbox.value);
            const container = document.getElementById(`times_${targetDay}`);

            container.innerHTML = '';
            if (checkbox.checked) {
                const timeInput = document.createElement('input');
                timeInput.type = "time";
                timeInput.name = `day_times[${targetDay}]`;
                timeInput.required = true;

                container.append(timeInput);
            }
        });
    }
    days.forEach(day =>
        day.addEventListener('change', generatePerformanceList)
    );
    startDateInput.addEventListener('change', generatePerformanceList);
    endDateInput.addEventListener('change', generatePerformanceList);
}

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
            newPerformancesListDiv.classList.remove('d-none');
            newPerformancesListDiv.classList.add('d-block');
            submitPerformancesBtn.classList.remove('d-none');
            submitPerformancesBtn.classList.add('d-block');
        } else {
            newPerformancesListDiv.classList.add('d-block');
            newPerformancesListDiv.classList.add('d-none');
            submitPerformancesBtn.classList.remove('d-block');
            submitPerformancesBtn.classList.add('d-none');
        }
    }

    addPerformanceBtn.addEventListener('click', function () {
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

    performancesToAdd.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-perf-btn')) {
            const index = parseInt(event.target.dataset.index);
            newPerformances.splice(index, 1);
            renderNewPerformances();
        }
    });

    addPerformancesForm.addEventListener('submit', function (event) {
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
    initPerformanceGeneratorAdmin();
    initPerformanceGeneratorPublic();
    initPerformanceEditor();
    const el = document.getElementById('staff-search');

    if (el) {
        const tomSelectInstance = new TomSelect(el, {
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            clearValueOnItemAdd: true,
            load: function (query, callback) {
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
                option: function (item, escape) {
                    return `<div>
                                <img src="${escape(item.avatar)}" alt="">
                                <span>${escape(item.name)}</span>
                            </div>`;
                },
                item: function (item, escape) {
                    return `<div class="selected-staff-item">${escape(item.name)}</div>`;
                }
            }
        });
        tomSelectInstance.on('item_add', function (value, item) {
            const container = document.getElementById('staff-roles-container');
            const itemData = tomSelectInstance.options[value];
            const itemName = itemData ? itemData.name : 'Staff Member';
            const roleInput = document.createElement('div');
            roleInput.classList.add('role-wrapper')
            roleInput.id = `role-wrapper-${value}`;
            roleInput.innerHTML = `
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <label for="staff_role_${value}">¿Rol de ${itemName}?</label>
                        <input class="p-1 mt-2 rounded auth-form-input" type="text" id="staff_role_${value}" name="staff_roles[${value}]" placeholder="Ej: Actor, Director, Productor" />
                    </div>
                    <button type="button" class="p-1 text-danger remove-role-btn"><strong>X</strong></button>
                </div>
            `;
            container.append(roleInput);
            tomSelectInstance.setTextboxValue('');

            const removeButton = roleInput.querySelector('.remove-role-btn');

            removeButton.addEventListener('click', () => {
                tomSelectInstance.removeItem(value);
            });
        });
        tomSelectInstance.on('item_remove', function (value) {
            const wrapper = document.getElementById(`role-wrapper-${value}`);
            if (wrapper) wrapper.remove();
        });
        el.nextElementSibling.firstChild.classList.add('border-0');
    }
});

document.querySelectorAll('.remove-user-btn').forEach(button => {
    button.addEventListener('click', function (event) {
        const id = this.dataset.userId;
        if (!confirm('¿Estás seguro?')) return;

        this.closest('tr').remove();
    });
});

// Manejo de cambio de formulario de auth
const loginTab = document.getElementById('login-tab');
const registerTab = document.getElementById('register-tab');

const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');

loginTab.addEventListener('click', () => {
    loginForm.hidden = false;
    registerForm.hidden = true;

    loginTab.classList.add('active-form');
    registerTab.classList.remove('active-form');
});

registerTab.addEventListener('click', () => {
    loginForm.hidden = true;
    registerForm.hidden = false;

    registerTab.classList.add('active-form');
    loginTab.classList.remove('active-form');
});