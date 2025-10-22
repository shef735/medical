<?php
/* File: index.php */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient S.O.A.P. Management</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1400px; 
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px 30px;
            border-bottom: 1px solid #ddd;
        }
        header h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .search-patient {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }
        .search-patient-bar {
            display: flex;
            gap: 10px;
        }
        .search-patient-bar input[type="text"] {
            flex-grow: 1;
            padding: 12px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        #search-results {
            list-style-type: none;
            padding: 0;
            margin: 10px 0 0 0;
            border: 1px solid #ddd;
            border-radius: 6px;
            max-height: 200px;
            overflow-y: auto;
        }
        #search-results li {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        #search-results li:last-child {
            border-bottom: none;
        }
        #search-results li:hover {
            background-color: #f0f0f0;
        }
        .patient-workspace {
            display: none; 
            padding: 30px;
        }
        .patient-details-card {
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .patient-details-card h2 {
            margin: 0;
            font-size: 1.4em;
            color: #007bff;
        }
        .patient-details-card p {
            margin: 5px 0 0 0;
            color: #555;
        }
        .btn {
            padding: 12px 20px;
            font-size: 1em;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            padding: 8px 12px;
            font-size: 0.9em;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }

        .visits-history {
            margin-top: 30px;
            overflow-x: auto; 
        }
        .visits-history h3 {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
        }
        
        /* --- *** MODIFIED CSS RULE *** --- */
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            white-space: normal; /* Allow text wrapping */
            word-wrap: break-word; /* Break long words */
            max-width: 200px; /* S.O.A.P columns */
            vertical-align: top; /* Align text to top */
        }
        
        th:first-child, td:first-child { 
            width: 120px; /* Visit Date */
        }
        th:last-child, td:last-child { 
            width: 120px; /* Actions */
            white-space: normal;
            text-align: center;
            vertical-align: middle;
        }
        th:nth-child(2), td:nth-child(2) { 
            width: 100px; /* Case # */
        }
        /* --- *** END OF MODIFIED CSS *** --- */
        
        th {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        
        /* This hover rule is no longer needed as wrapping is default */
        /*
        td:hover {
            white-space: normal;
            overflow: visible;
        }
        */

        /* --- Modal (Popup) Styles --- */
        .modal-overlay {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 3% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 90%;
            max-width: 1300px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }

        .modal-header {
            padding: 10px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h2 {
            margin: 0;
        }
        .modal-close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .modal-close:hover,
        .modal-close:focus {
            color: black;
        }
        .modal-body {
            padding: 20px;
            max-height: 75vh;
            overflow-y: auto;
        }
        .modal-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            text-align: right;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box; 
        }
        
        input[readonly].form-control {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        #status-message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: none;
        }
        #status-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        #status-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* --- CSS FOR 2-COLUMN MODAL --- */
        .modal-split-layout {
            display: flex;
            gap: 20px;
        }

        .new-entry-column {
            flex: 1;
            min-width: 50%;
        }

        .previous-visit-column {
            display: none;
            flex: 1;
            background: #f8f9fa;
            border-left: 1px solid #eee;
            padding-left: 20px;
        }

        .modal-split-view .previous-visit-column {
            display: block;
        }

        .previous-visit-column h4 {
            margin-top: 0;
            color: #007bff;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .previous-visit-column .data-block {
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 6px;
            min-height: 50px;
            white-space: pre-wrap; 
            word-wrap: break-word; 
            font-size: 0.9em;
            color: #333;
        }

    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Patient S.O.A.P. Management</h1>
        </header>

        <section class="search-patient">
            <h2>Find Patient</h2>
            <div class="search-patient-bar">
                <input type="text" id="patient-search-input" placeholder="Search by Last Name, First Name, or Patient Code...">
            </div>
            <ul id="search-results"></ul>
        </section>

        <section class="patient-workspace" id="patient-workspace">
            <div class="patient-details-card">
                <div>
                    <h2 id="patient-name"></h2>
                    <p id="patient-info"></p>
                </div>
                <button class="btn btn-primary" id="btn-new-visit">Add New Visit</button>
            </div>

            <div class="visits-history">
                <h3>Previous Visits</h3>
                <div id="status-message"></div>
                <table id="visit-history-table">
                    <thead>
                        <tr>
                            <th>Visit Date</th>
                            <th>Case #</th>
                            <th>Subjective (S)</th>
                            <th>Objective (O)</th>
                            <th>Assessment (A)</th>
                            <th>Plan (P)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="visit-history-tbody"></tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="soap-modal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Add New Visit</h2>
                <span class="modal-close" id="modal-close-btn">&times;</span>
            </div>
            
            <form id="soap-form">
                <div class="modal-body">
                    <input type="hidden" id="patient_id" name="patient_id">
                    <input type="hidden" id="visit_id" name="visit_id">

                    <div class="modal-split-layout">
                        <div class="new-entry-column">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="visit_date">Visit Date</label>
                                    <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="case_number">Case Number</label>
                                    <input type="text" class="form-control" id="case_number" name="case_number" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="review_of_systems">Subjective (Review of Systems)</label>
                                <textarea class="form-control" id="review_of_systems" name="review_of_systems" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="objective">Objective</label>
                                <textarea class="form-control" id="objective" name="objective" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="assessment">Assessment</label>
                                <textarea class="form-control" id="assessment" name="assessment" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="plans">Plans</label>
                                <textarea class="form-control" id="plans" name="plans" rows="4"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="next_visit">Next Visit Date</label>
                                    <input type="date" class="form-control" id="next_visit" name="next_visit">
                                </div>
                                <div class="form-group">
                                    <label for="notes">Other Notes</label>
                                    <input type="text" class="form-control" id="notes" name="notes">
                                </div>
                            </div>
                        </div>

                        <div class="previous-visit-column">
                            <h4>Previous Visit Details</h4>
                            <div class="form-group">
                                <label id="prev_visit_date_label">Last Visit Date:</label>
                                <input type="date" class="form-control" id="prev_visit_date" readonly>
                            </div>
                            <div class="form-group">
                                <label>Subjective (S):</label>
                                <p id="prev_review_of_systems" class="data-block">N/A</p>
                            </div>
                            <div class="form-group">
                                <label>Objective (O):</label>
                                <p id="prev_objective" class="data-block">N/A</p>
                            </div>
                            <div class="form-group">
                                <label>Assessment (A):</label>
                                <p id="prev_assessment" class="data-block">N/A</p>
                            </div>
                            <div class="form-group">
                                <label>Plan (P):</label>
                                <p id="prev_plans" class="data-block">N/A</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="modal-cancel-btn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Visit</button>
                </div>
            </form>
        </div>
    </div>


    <script>
    $(document).ready(function() {

        let currentPatientId = null;
        
        function generateCaseNumber() {
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            return `${year}${month}${day}-${hours}${minutes}${seconds}`;
        }

        $('#patient-search-input').on('keyup', function() {
            let query = $(this).val();
            if (query.length < 2) {
                $('#search-results').empty().hide();
                return;
            }
            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'search_patient', query: query },
                dataType: 'json',
                success: function(response) {
                    let resultsList = $('#search-results');
                    resultsList.empty();
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(patient) {
                            resultsList.append(
                                `<li data-id="${patient.patient_id}">
                                    <strong>${patient.last_name}, ${patient.first_name}</strong>
                                    (${patient.patient_code})
                                </li>`
                            );
                        });
                        resultsList.show();
                    } else {
                        resultsList.append('<li>No patients found.</li>');
                        resultsList.show();
                    }
                }
            });
        });

        $('#search-results').on('click', 'li', function() {
            let patientId = $(this).data('id');
            if (patientId) {
                currentPatientId = patientId;
                loadPatientWorkspace(currentPatientId);
                $('#search-results').empty().hide();
                $('#patient-search-input').val('');
            }
        });

        function loadPatientWorkspace(patientId) {
            $('#patient_id').val(patientId);
            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'get_patient_details', patient_id: patientId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let patient = response.data;
                        $('#patient-name').text(`${patient.first_name} ${patient.middle_name || ''} ${patient.last_name}`);
                        $('#patient-info').text(`Patient Code: ${patient.patient_code} | Patient ID: ${patient.patient_id}`);
                        $('#patient-workspace').slideDown();
                    }
                }
            });
            loadVisitHistory(patientId);
        }

        // --- *** MODIFIED JAVASCRIPT FUNCTION *** ---
        function loadVisitHistory(patientId) {
            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'get_visit_history', patient_id: patientId },
                dataType: 'json',
                success: function(response) {
                    let historyBody = $('#visit-history-tbody');
                    historyBody.empty();
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(function(visit) {
                            // Removed the 'truncate' function
                            
                            // Appending the full text now
                            historyBody.append(
                                `<tr>
                                    <td>${visit.visit_date}</td>
                                    <td>${visit.case_number || ''}</td>
                                    <td>${visit.review_of_systems || 'N/A'}</td>
                                    <td>${visit.objective || 'N/A'}</td>
                                    <td>${visit.assessment || 'N/A'}</td>
                                    <td>${visit.plans || 'N/A'}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit-visit" data-visit-id="${visit.visit_id}">
                                            View/Edit
                                        </button>
                                    </td>
                                </tr>`
                            );
                        });
                    } else {
                        historyBody.append('<tr><td colspan="7">No previous visits found.</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading visit history: ", status, error);
                    historyBody.empty().append('<tr><td colspan="7">Error loading visit history. Please try again.</td></tr>');
                }
            });
        }
        // --- *** END OF MODIFIED JAVASCRIPT *** ---

        function openModal() {
            $('#soap-modal').fadeIn(200);
        }
        function closeModal() {
            $('#soap-modal').fadeOut(200);
            $('#soap-form')[0].reset(); 
            $('#modal-title').text('Add New Visit');
            $('#visit_id').val(''); 
            $('#patient_id').val(currentPatientId);
            $('#soap-modal').removeClass('modal-split-view'); 
        }

        $('#modal-close-btn, #modal-cancel-btn').on('click', closeModal);

        function clearPreviousVisitColumn() {
            $('#prev_visit_date').val('');
            $('#prev_visit_date_label').text('Last Visit Date:');
            $('.previous-visit-column .data-block').text('N/A');
        }

        function populatePreviousVisitColumn(visit) {
            if (visit) {
                $('#prev_visit_date_label').text('Last Visit Date:');
                $('#prev_visit_date').val(visit.visit_date || '');
                $('#prev_review_of_systems').text(visit.review_of_systems || 'N/A');
                $('#prev_objective').text(visit.objective || 'N/A');
                $('#prev_assessment').text(visit.assessment || 'N/A');
                $('#prev_plans').text(visit.plans || 'N/A');
            } else {
                clearPreviousVisitColumn();
                $('#prev_visit_date_label').text('Last Visit Date: (No previous visits found)');
            }
        }

        $('#btn-new-visit').on('click', function() {
            $('#soap-form')[0].reset();
            $('#modal-title').text('Add New Visit');
            $('#visit_id').val('');
            $('#patient_id').val(currentPatientId);
            let today = new Date().toISOString().split('T')[0];
            $('#visit_date').val(today);
            $('#case_number').val(generateCaseNumber());
            
            clearPreviousVisitColumn();
            $('#prev_visit_date_label').text('Last Visit Date: (Loading...)');
            $('#soap-modal').addClass('modal-split-view');

            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'get_last_visit', patient_id: currentPatientId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populatePreviousVisitColumn(response.data);
                    } else {
                         $('#prev_visit_date_label').text('Last Visit Date: (Error loading)');
                    }
                },
                error: function() {
                    $('#prev_visit_date_label').text('Last Visit Date: (Error loading)');
                }
            });
            openModal();
        });

        $('#visit-history-tbody').on('click', '.btn-edit-visit', function() {
            let visitId = $(this).data('visit-id');
            $('#soap-modal').removeClass('modal-split-view');

            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'get_visit_details', visit_id: visitId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let visit = response.data;
                        $('#modal-title').text('Edit Visit Details');
                        $('#patient_id').val(visit.patient_id);
                        $('#visit_id').val(visit.visit_id);
                        $('#visit_date').val(visit.visit_date);
                        $('#case_number').val(visit.case_number);
                        $('#review_of_systems').val(visit.review_of_systems);
                        $('#objective').val(visit.objective);
                        $('#assessment').val(visit.assessment);
                        $('#plans').val(visit.plans);
                        $('#next_visit').val(visit.next_visit);
                        $('#notes').val(visit.notes);
                        openModal();
                    } else {
                        showStatusMessage('Error: Could not load visit details.', 'error');
                    }
                }
            });
        });

        $('#soap-form').on('submit', function(e) {
            e.preventDefault(); 
            let formData = $(this).serialize();
            formData += '&action=save_visit'; 

            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        closeModal();
                        showStatusMessage(response.message, 'success');
                        loadVisitHistory(currentPatientId);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An unknown error occurred. Please try again.');
                }
            });
        });

        function showStatusMessage(message, type) {
            let statusBox = $('#status-message');
            statusBox.text(message).removeClass('success error').addClass(type).slideDown();
            setTimeout(function() {
                statusBox.slideUp();
            }, 5000);
        }
    });
    </script>

</body>
</html>