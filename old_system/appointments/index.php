<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FullCalendar -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Custom styles for a more polished look */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Tailwind gray-50 */
        }
        #calendar {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        /* FullCalendar custom styling */
        .fc .fc-button-primary {
            background-color: #4f46e5; /* Indigo-600 */
            border-color: #4f46e5;
            transition: background-color 0.3s;
        }
        .fc .fc-button-primary:hover {
            background-color: #4338ca; /* Indigo-700 */
        }
        .fc .fc-daygrid-day.fc-day-today {
            background-color: #e0e7ff; /* Indigo-100 */
        }
        .fc-event {
            border-radius: 4px;
            border-width: 1px !important; /* Ensure border is visible */
            cursor: pointer;
            font-weight: 500;
        }
        .fc-event-main {
            padding: 4px 6px;
        }
        
        /* FIX: Simplified and corrected CSS selectors for event text color */
        .fc-event.status-0 .fc-event-title { color: #3b82f6 !important; } /* Scheduled */
        .fc-event.status-1 .fc-event-title { color: #16a34a !important; } /* Confirmed (darker green) */
        .fc-event.status-2 .fc-event-title { color: #6b7280 !important; } /* Completed */
        .fc-event.status-3 .fc-event-title { color: #ef4444 !important; } /* Cancelled */
        .fc-event.status-4 .fc-event-title { color: #f97316 !important; } /* No Show */
        
        /* Modal styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        }
        /* Custom scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 8px;
        }
        .modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .modal-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Form input styling */
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db; /* gray-300 */
            border-radius: 0.5rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-input:focus {
            outline: none;
            border-color: #4f46e5; /* Indigo-600 */
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        /* Select2 custom styling */
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px); /* Match form-input height */
            padding: 0.375rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5rem;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }
        .select2-container--open .select2-dropdown--below {
            border-top: 1px solid #4f46e5;
            border-radius: 0 0 0.5rem 0.5rem;
        }
        .select2-search--dropdown .select2-search__field {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
        }
        .select2-results__option--highlighted {
            background-color: #4f46e5 !important;
        }

        /* Custom notification styling */
        #notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
            pointer-events: none;
        }
        #notification.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    </style>
</head>
<body>

    <div id="calendar"></div>

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="modal-backdrop hidden">
        <div class="modal-content">
            <h2 id="modalTitle" class="text-2xl font-bold mb-6 text-gray-800">Add Appointment</h2>
            <form id="appointmentForm">
                <input type="hidden" id="appointmentId" name="id"> 
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Patient Information -->
                    <div class="md:col-span-2 font-semibold text-lg text-indigo-600 border-b pb-2 mb-2">Patient Details</div>
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                        <select id="patient_id" name="patient_id" class="form-input" style="width: 100%;"></select>
                    </div>
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-input" required >
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" class="form-input">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-input">
                    </div>

                    <!-- Appointment Details -->
                    <div class="md:col-span-2 font-semibold text-lg text-indigo-600 border-b pb-2 mb-2 mt-4">Appointment Details</div>
                    <div class="md:col-span-2">
                        <label for="ailment" class="block text-sm font-medium text-gray-700 mb-1">Ailment / Reason for Visit</label>
                        <input type="text" id="ailment" name="ailment" class="form-input" required>
                    </div>
                    <div>
                        <label for="date_sched" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" id="date_sched" name="date_only" class="form-input" required>
                    </div>
                    <div>
                        <label for="time_sched" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" id="time_sched" name="time_only" class="form-input" required>
                    </div>
                    <div>
                        <label for="doctor" class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                        <input type="text" id="doctor" name="doctor" class="form-input">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="form-input">
                            <option value="0">Scheduled</option>
                            <option value="1">Confirmed</option>
                            <option value="2">Completed</option>
                            <option value="3">Cancelled</option>
                            <option value="4">No Show</option>
                        </select>
                    </div>

                    <!-- Medical & Remarks -->
              <div style="display: none;">
                    <div  class="md:col-span-2 font-semibold text-lg text-indigo-600 border-b pb-2 mb-2 mt-4">Medical Information</div>
                        <div>
                            <label for="bp" class="block text-sm font-medium text-gray-700 mb-1">Blood Pressure</label>
                            <input type="text" id="bp" name="bp" class="form-input">
                        </div>
                    <div>
                        <label for="weight_kg" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" step="0.1" id="weight_kg" name="weight_kg" class="form-input">
                    </div>
                    <div class="md:col-span-2">
                        <label for="findings" class="block text-sm font-medium text-gray-700 mb-1">Findings</label>
                        <textarea id="findings" name="findings" rows="3" class="form-input"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea id="remarks" name="remarks" rows="3" class="form-input"></textarea>
                    </div>
                </div>
             </div>     
                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" id="closeModalBtn" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                    <button type="button" id="deleteAppointmentBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 hidden">Delete</button>
                    <button type="submit" id="saveAppointmentBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Custom Notification -->
    <div id="notification"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- CONFIGURATION ---
            const API_URL = './api/'; 

            // --- DOM ELEMENTS ---
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('appointmentModal');
            const modalTitle = document.getElementById('modalTitle');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const appointmentForm = document.getElementById('appointmentForm');
            const saveAppointmentBtn = document.getElementById('saveAppointmentBtn');
            const deleteAppointmentBtn = document.getElementById('deleteAppointmentBtn');

            let calendar;
            let datesWithAppointments = new Set();

            function applyDayStyles() {
                const dayCells = calendarEl.querySelectorAll('.fc-daygrid-day');
                dayCells.forEach(cell => {
                    const dateStr = cell.getAttribute('data-date');
                    if (dateStr && datesWithAppointments.has(dateStr)) {
                        cell.style.backgroundColor = '#eef2ff'; // Tailwind's indigo-50
                    } else if (dateStr) {
                        cell.style.backgroundColor = ''; 
                    }
                });
            }

            // --- SELECT2 INITIALIZATION ---
            function initializePatientDropdown() {
                $('#patient_id').select2({
                    placeholder: 'Search for a patient',
                    allowClear: true,
                    ajax: {
                        url: `${API_URL}get_patients.php`,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1
                }).on('select2:select', function (e) {
                    var data = e.params.data;
                    document.getElementById('fullname').value = data.text;
                    document.getElementById('email').value = data.email || '';
                    document.getElementById('phone').value = data.phone || '';
                }).on('select2:unselect', function (e) {
                    document.getElementById('fullname').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('phone').value = '';
                });
            }

            // --- FULLCALENDAR INITIALIZATION ---
            function initializeCalendar() {
                if (!calendarEl) return;

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    editable: true,
                    selectable: true,
                    navLinks: true,
                    dayMaxEvents: true,
                    
                    select: handleDateSelect,
                    eventClick: handleEventClick,
                    eventDrop: handleEventDropOrResize,
                    eventResize: handleEventDropOrResize,

                    datesDidUpdate: function() {
                        applyDayStyles();
                    },

                    events: async function(fetchInfo, successCallback, failureCallback) {
                        try {
                            const response = await fetch(`${API_URL}get_appointments.php`);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            const eventsData = await response.json();
                            
                            const statusMainColors = {
                                '0': '#3b82f6', // blue-500 (Scheduled)
                                '1': '#16a34a', // green-600 (Confirmed)
                                '2': '#6b7280', // gray-500 (Completed)
                                '3': '#ef4444', // red-500 (Cancelled)
                                '4': '#f97316', // orange-500 (No Show)
                            };
                            const statusBgColors = {
                                '0': '#dbeafe', // blue-100
                                '1': '#dcfce7', // green-100
                                '2': '#f3f4f6', // gray-100
                                '3': '#fee2e2', // red-100
                                '4': '#ffedd5', // orange-100
                            };

                            datesWithAppointments = new Set(eventsData.map(e => e.date_only));

                            const formattedEvents = eventsData.map(event => {
                                const mainColor = statusMainColors[event.status] || '#6b7280';
                                const bgColor = statusBgColors[event.status] || '#f3f4f6';
                                const eventClassName = `status-${event.status}`;

                                return {
                                    id: event.id,
                                    title: `${event.fullname} - ${event.ailment}`,
                                    start: `${event.date_only}T${event.time_only}`,
                                    allDay: false,
                                    extendedProps: event,
                                    backgroundColor: bgColor,
                                    borderColor: mainColor,
                                    classNames: [eventClassName] // This is the key change
                                };
                            });

                            successCallback(formattedEvents);
                            applyDayStyles();
                        } catch (error) {
                            console.error("Error fetching appointments:", error);
                            showNotification("Failed to load appointments.", "bg-red-600");
                            failureCallback(error);
                        }
                    }
                });

                calendar.render();
            }
            
            // --- MODAL & FORM LOGIC ---
            function openModal(data = {}) {
                appointmentForm.reset();
                $('#patient_id').val(null).trigger('change');

                const { event, startStr } = data;

                if (event) { // Editing
                    modalTitle.textContent = 'Edit Appointment';
                    const props = event.extendedProps;
                    
                    for (const key in props) {
                        const field = appointmentForm.elements[key];
                        if (field && key !== 'patient_id') {
                            field.value = props[key] || '';
                        }
                    }
                    if (props.patient_id && props.fullname) {
                        var option = new Option(props.fullname, props.patient_id, true, true);
                        $('#patient_id').append(option).trigger('change');
                    }

                    document.getElementById('appointmentId').value = props.id;
                    document.getElementById('date_sched').value = props.date_only || '';
                    document.getElementById('time_sched').value = props.time_only || '';

                    deleteAppointmentBtn.classList.remove('hidden');

                } else { // Creating
                    modalTitle.textContent = 'Add Appointment';
                    document.getElementById('appointmentId').value = '';
                    deleteAppointmentBtn.classList.add('hidden');
                    
                    if (startStr) {
                        const date = new Date(startStr);
                        document.getElementById('date_sched').value = date.toISOString().split('T')[0];
                        document.getElementById('time_sched').value = date.toTimeString().substring(0, 5);
                    }
                }
                modal.classList.remove('hidden');
            }

            function closeModal() {
                modal.classList.add('hidden');
            }

            async function saveAppointment(e) {
                e.preventDefault();
                const formData = new FormData(appointmentForm);

                try {
                    const response = await fetch(`${API_URL}save_appointment.php`, {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
                    }

                    const result = await response.json();
                    
                    if (result.status === 'success') {
                        showNotification(result.message, "bg-green-600");
                        calendar.refetchEvents();
                        closeModal();
                    } else {
                        throw new Error(result.message || "An unknown error occurred.");
                    }

                } catch (error) {
                    console.error("Error saving appointment:", error);
                    showNotification(`Error: ${error.message}`, "bg-red-600");
                }
            }

            async function deleteAppointment() {
                const appointmentId = document.getElementById('appointmentId').value;
                if (!appointmentId) return;

                if (!window.confirm("Are you sure you want to delete this appointment?")) {
                    return;
                }

                try {
                    const formData = new FormData();
                    formData.append('id', appointmentId);

                    const response = await fetch(`${API_URL}delete_appointment.php`, {
                        method: 'POST',
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.status === 'success') {
                        showNotification("Appointment deleted.", "bg-gray-700");
                        calendar.refetchEvents();
                        closeModal();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    console.error("Error deleting appointment:", error);
                    showNotification(`Error: ${error.message}`, "bg-red-600");
                }
            }

            // --- EVENT HANDLER FUNCTIONS ---
            function handleDateSelect(selectInfo) {
                openModal({ startStr: selectInfo.startStr });
            }

            function handleEventClick(clickInfo) {
                openModal({ event: clickInfo.event });
            }

            async function handleEventDropOrResize(info) {
                const { event } = info;
                const newDate = event.start;
                
                const formData = new FormData();
                for (const key in event.extendedProps) {
                    formData.append(key, event.extendedProps[key]);
                }
                formData.set('id', event.id);
                formData.set('date_only', newDate.toISOString().split('T')[0]);
                formData.set('time_only', newDate.toTimeString().substring(0, 5));

                try {
                    const response = await fetch(`${API_URL}save_appointment.php`, {
                        method: 'POST',
                        body: formData,
                    });

                    if (!response.ok) throw new Error("Failed to update event time.");
                    
                    const result = await response.json();
                    if(result.status === 'success') {
                        showNotification("Appointment time updated.", "bg-green-600");
                        calendar.refetchEvents();
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    console.error("Error updating event time: ", error);
                    showNotification(error.message, "bg-red-600");
                    info.revert();
                }
            }
            
            // --- UTILITY FUNCTIONS ---
            function showNotification(message, bgColor) {
                const notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = `show ${bgColor}`;
                setTimeout(() => {
                    notification.className = notification.className.replace('show', '');
                }, 3000);
            }

            // --- GLOBAL EVENT LISTENERS ---
            function setupEventListeners() {
                closeModalBtn.addEventListener('click', closeModal);
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });
                appointmentForm.addEventListener('submit', saveAppointment);
                deleteAppointmentBtn.addEventListener('click', deleteAppointment);
            }

            // --- INITIALIZE THE APP ---
            initializeCalendar();
            initializePatientDropdown();
            setupEventListeners();
        });
    </script>
</body>
</html>
