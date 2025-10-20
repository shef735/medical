<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient S.O.A.P. Management System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #1a73e8;
            --primary-dark: #0d47a1;
            --primary-light: #e8f0fe;
            --secondary: #34a853;
            --secondary-light: #e6f4ea;
            --accent: #fbbc04;
            --text-primary: #202124;
            --text-secondary: #5f6368;
            --text-light: #ffffff;
            --background: #f8f9fa;
            --surface: #ffffff;
            --border: #dadce0;
            --error: #d93025;
            --error-light: #fce8e6;
            --success: #34a853;
            --success-light: #e6f4ea;
            --warning: #f9ab00;
            --warning-light: #fef7e0;
            --shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3), 0 1px 3px 1px rgba(60, 64, 67, 0.15);
            --shadow-hover: 0 1px 3px 0 rgba(60, 64, 67, 0.3), 0 4px 8px 3px rgba(60, 64, 67, 0.15);
            --radius: 8px;
            --radius-sm: 4px;
            --transition: all 0.2s ease-in-out;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--background);
            color: var(--text-primary);
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            min-height: 600px;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--text-light);
            padding: 20px 30px;
            border-bottom: 1px solid var(--border);
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        header h1::before {
            content: "🩺";
            margin-right: 12px;
            font-size: 1.5em;
        }

        .search-patient {
            padding: 30px;
            border-bottom: 1px solid var(--border);
            background-color: var(--surface);
            position: relative;
            min-height: 200px;
        }

        .search-patient h2 {
            margin-top: 0;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 1.4rem;
            margin-bottom: 20px;
        }

        .search-patient-bar {
            display: flex;
            gap: 10px;
            position: relative;
        }

        .search-patient-bar input[type="text"] {
            flex-grow: 1;
            padding: 14px 16px;
            font-size: 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            background-color: var(--surface);
        }

        .search-patient-bar input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        #search-results {
            list-style-type: none;
            padding: 0;
            margin: 10px 0 0 0;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            max-height: 300px;
            overflow-y: auto;
            background-color: var(--surface);
            box-shadow: var(--shadow);
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            display: none;
        }

        #search-results li {
            padding: 14px 16px;
            cursor: pointer;
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        #search-results li:last-child {
            border-bottom: none;
        }

        #search-results li:hover {
            background-color: var(--primary-light);
        }

        #search-results li::before {
            content: "👤";
            margin-right: 10px;
            font-size: 1.2em;
        }

        .patient-workspace {
            display: none;
            padding: 30px;
        }

        .patient-details-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        .patient-details-card h2 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 500;
        }

        .patient-details-card p {
            margin: 8px 0 0 0;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .patient-details-card p span {
            background-color: var(--primary-light);
            padding: 4px 8px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
        }

        .btn {
            padding: 12px 24px;
            font-size: 1rem;
            border: none;
            border-radius: var(--radius);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
            font-weight: 500;
        }

        .btn-primary {
            background-color: var(--primary);
            color: var(--text-light);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-hover);
        }

        .btn-secondary {
            background-color: var(--surface);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background-color: #f1f3f4;
        }

        .btn-warning {
            background-color: var(--warning);
            color: var(--text-primary);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-warning:hover {
            background-color: #e6a700;
        }

        .btn-success {
            background-color: var(--success);
            color: var(--text-light);
        }

        .btn-success:hover {
            background-color: #2e8b47;
        }

        .btn-info {
            background-color: #17a2b8;
            color: var(--text-light);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .visits-history {
            margin-top: 30px;
            overflow-x: auto;
        }

        .visits-history h3 {
            border-bottom: 2px solid var(--border);
            padding-bottom: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 1.3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto;
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            overflow: hidden;
        }

        th, td {
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid var(--border);
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            word-wrap: break-word;
            max-width: none;
        }

        th:first-child, td:first-child {
            width: 120px;
        }

        th:last-child, td:last-child {
            width: 150px;
            white-space: normal;
            text-align: center;
        }

        th:nth-child(2), td:nth-child(2) {
            width: 100px;
        }

        td:nth-child(3),
        td:nth-child(4),
        td:nth-child(5),
        td:nth-child(6) {
            min-width: 200px;
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.4;
        }

        th {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        tr {
            transition: var(--transition);
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* FIXED MODAL STYLING */
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
            backdrop-filter: blur(2px);
        }

        .modal-content {
            background-color: var(--surface);
            margin: 2% auto;
            padding: 0;
            border-radius: var(--radius);
            width: 95%;
            max-width: 100%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            position: relative;
            display: flex;
            flex-direction: column;
            max-height: 96vh;
            min-height: 600px;
        }

        .modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--primary-light);
            flex-shrink: 0;
        }

        .modal-header h2 {
            margin: 0;
            color: var(--primary-dark);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h2::before {
            content: "📋";
            font-size: 1.3em;
        }

        .modal-close {
            color: var(--text-secondary);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover,
        .modal-close:focus {
            color: var(--text-primary);
        }

        .modal-body {
            padding: 30px;
            overflow-y: auto;
            flex: 1;
            min-height: 400px;
            background-color: var(--surface);
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid var(--border);
            text-align: right;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-shrink: 0;
            background-color: var(--surface);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            font-size: 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-sizing: border-box;
            transition: var(--transition);
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        input[readonly].form-control {
            background-color: #f8f9fa;
            cursor: not-allowed;
            color: var(--text-secondary);
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
            padding: 16px;
            margin-bottom: 20px;
            border-radius: var(--radius);
            display: none;
        }

        #status-message.success {
            background-color: var(--success-light);
            color: var(--success);
            border: 1px solid #c3e6cb;
        }

        #status-message.error {
            background-color: var(--error-light);
            color: var(--error);
            border: 1px solid #f5c6cb;
        }

        /* FIXED MODAL SPLIT LAYOUT */
        .modal-split-layout {
            display: flex;
            gap: 30px;
            min-height: 500px;
            background-color: var(--surface);
        }

        .new-entry-column {
            flex: 1;
            min-width: 50%;
            background-color: var(--surface);
        }

        .previous-visit-column {
            display: none;
            flex: 1;
            background: #f8f9fa;
            border-left: 1px solid var(--border);
            padding-left: 30px;
            border-radius: 0 var(--radius) var(--radius) 0;
        }

        .modal-split-view .previous-visit-column {
            display: block;
        }

        .previous-visit-column h4 {
            margin-top: 0;
            color: var(--primary);
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .previous-visit-column h4::before {
            content: "🕐";
            font-size: 1.2em;
        }

        .previous-visit-column .data-block {
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 14px;
            border-radius: var(--radius);
            min-height: 50px;
            white-space: pre-wrap;
            word-wrap: break-word;
            font-size: 0.95rem;
            color: var(--text-primary);
            line-height: 1.5;
            max-height: 150px;
            overflow-y: auto;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            color: var(--primary);
        }

        .section-header::before {
            font-size: 1.2em;
        }

        .s-section::before {
            content: "💬";
        }

        .o-section::before {
            content: "🔍";
        }

        .a-section::before {
            content: "📊";
        }

        .p-section::before {
            content: "📝";
        }

        /* FIXED PRINT STYLES */
        @media print {
            body * {
                visibility: hidden;
            }
            #print-modal, #print-modal * {
                visibility: visible;
            }
            #print-modal {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
                background: white;
                z-index: 9999;
            }
            .modal-content {
                box-shadow: none;
                border: none;
                margin: 0;
                max-height: none;
                min-height: auto;
            }
            .modal-header, .modal-footer {
                display: none;
            }
            .modal-body {
                padding: 20px;
                overflow: visible;
                height: auto;
            }
            .no-print {
                display: none !important;
            }
            .print-section {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }
            .print-soap-content {
                min-height: auto;
                border: 1px solid #000;
                padding: 15px;
                margin-bottom: 10px;
            }
            /* Ensure proper page breaks */
            .print-patient-info, 
            .print-soap-section {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            /* Set proper margins for printing */
            @page {
                margin: 1cm;
            }
            body {
                margin: 0;
                padding: 0;
            }
        }

        .print-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .print-patient-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: var(--radius);
            margin-bottom: 30px;
            border: 1px solid #000;
        }

        .print-soap-section {
            margin-bottom: 25px;
        }

        .print-soap-section h4 {
            background: var(--primary-light);
            padding: 10px 15px;
            margin: 0 0 10px 0;
            border-radius: var(--radius-sm);
            color: var(--primary-dark);
            border: 1px solid #000;
        }

        .print-soap-content {
            padding: 15px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            min-height: 100px;
            white-space: pre-wrap;
            line-height: 1.6;
            background: white;
        }

        /* Quick action buttons */
        .quick-actions {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .quick-action-btn {
            padding: 10px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .quick-action-btn:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        /* Status indicators */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-active {
            background-color: var(--success);
        }

        .status-inactive {
            background-color: var(--text-secondary);
        }

        /* Loading indicator */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .modal-split-layout {
                flex-direction: column;
            }
            
            .previous-visit-column {
                border-left: none;
                border-top: 1px solid var(--border);
                padding-left: 0;
                padding-top: 20px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                margin: 0;
                border-radius: 0;
            }
            
            .search-patient, .patient-workspace {
                padding: 20px;
            }
            
            .patient-details-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .modal-content {
                width: 100%;
                margin: 0;
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
            }
            
            .modal-body {
                padding: 20px;
            }

            table {
                display: block;
                overflow-x: auto;
            }
            
            td:nth-child(3),
            td:nth-child(4),
            td:nth-child(5),
            td:nth-child(6) {
                min-width: 150px;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <a style="float: right;" href="../index.php" class="btn btn-success">
                Home
            </a>
            <h1>Patient S.O.A.P. Management System</h1>
        </header>

        <section class="search-patient">
            <h2>Find Patient</h2>
            <div class="search-patient-bar">
                <input type="text" id="patient-search-input" placeholder="Search by Last Name, First Name, or Patient Code...">
                <ul id="search-results"></ul>
            </div>
        </section>

        <section class="patient-workspace" id="patient-workspace">
            <div class="patient-details-card">
                <div>
                    <h2 id="patient-name"></h2>
                    <p id="patient-info"></p>
                </div>
                <button class="btn btn-primary" id="btn-new-visit">
                    <span>➕</span> Add New Visit
                </button>
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

    <!-- SOAP Modal -->
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
                                    <label for="next_visit">Next Visit Date</label>
                                    <input type="date" class="form-control" id="next_visit" name="next_visit">
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label for="case_number">Case Number</label>
                                    <input type="text" class="form-control" id="case_number" name="case_number" readonly>
                                </div>
                            </div>
                            
                            <div class="section-header s-section">Subjective (Review of Systems)</div>
                            <div class="form-group">
                                <textarea class="form-control" id="review_of_systems" name="review_of_systems" rows="4" placeholder="Patient's complaints, symptoms, medical history..."></textarea>
                            </div>
                            
                            <div class="section-header o-section">Objective</div>
                            <div class="form-group">
                                <textarea class="form-control" id="objective" name="objective" rows="4" placeholder="Physical exam findings, lab results, vital signs..."></textarea>
                            </div>
                            
                            <div class="section-header a-section">Assessment</div>
                            <div class="form-group">
                                <textarea class="form-control" id="assessment" name="assessment" rows="4" placeholder="Diagnosis, differential diagnosis, clinical impression..."></textarea>
                            </div>
                            
                            <div class="section-header p-section">Plans</div>
                            <div class="form-group">
                                <textarea class="form-control" id="plans" name="plans" rows="4" placeholder="Treatment plan, medications, referrals, follow-up..."></textarea>
                            </div>
                            
                            <div class="form-row" style="display: none;">
                                <div class="form-group">
                                    <label for="notes">Other Notes</label>
                                    <input type="text" class="form-control" id="notes" name="notes" placeholder="Additional clinical notes...">
                                </div>
                            </div>
                        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="modal-cancel-btn">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <span>💾</span> Save Visit
                                </button>
                            </div>
                        </div>

                        <div class="previous-visit-column">
                            <h4>Previous Visit Details /  
                                <label id="prev_visit_date_label">Last Visit Date:</label> 
                                <input style="font-size: 20px; text-align:center;color: red" type="date" id="prev_visit_date" readonly>
                            </h4>
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
            </form>
        </div>
    </div>

    <!-- Print Modal -->
    <div id="print-modal" class="modal-overlay">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h2>Print S.O.A.P. Record</h2>
                <span class="modal-close" id="print-modal-close-btn">&times;</span>
            </div>
            
            <div class="modal-body">
                <div id="print-content">
                    <!-- Print content will be dynamically inserted here -->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary no-print" id="print-cancel-btn">Close</button>
                <button type="button" class="btn btn-primary no-print" id="print-btn">
                    <span>🖨️</span> Print
                </button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        let currentPatientId = null;
        let currentPatientDetails = null;
        
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

        // Close search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-patient-bar').length) {
                $('#search-results').hide();
            }
        });

        $('#patient-search-input').on('keyup', function() {
            let query = $(this).val();
            if (query.length < 2) {
                $('#search-results').empty().hide();
                return;
            }
            
            $('#search-results').html('<li><div class="loading"></div> Searching...</li>').show();
            
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
                },
                error: function() {
                    $('#search-results').html('<li>Error searching patients. Please try again.</li>').show();
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
                        currentPatientDetails = response.data;
                        $('#patient-name').text(`${currentPatientDetails.first_name} ${currentPatientDetails.middle_name || ''} ${currentPatientDetails.last_name}`);
                        $('#patient-info').html(`
                            Patient Code: <span>${currentPatientDetails.patient_code}</span> | 
                            Patient ID: <span>${currentPatientDetails.patient_id}</span> |
                            <span class="status-indicator status-active"></span>Active
                        `);
                        $('#patient-workspace').slideDown();
                    }
                }
            });
            loadVisitHistory(patientId);
        }

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
                            const displayText = (str) => str || 'N/A';
                            historyBody.append(
                                `<tr>
                                    <td>${visit.visit_date}</td>
                                    <td>${visit.case_number || ''}</td>
                                    <td>${displayText(visit.review_of_systems)}</td>
                                    <td>${displayText(visit.objective)}</td>
                                    <td>${displayText(visit.assessment)}</td>
                                    <td>${displayText(visit.plans)}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-edit-visit" data-visit-id="${visit.visit_id}">
                                            <span>✏️</span> 
                                        </button> 
                                        <button class="btn btn-info btn-sm btn-print-visit" data-visit-id="${visit.visit_id}">
                                            <span>🖨️</span>
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

        function openModal() {
            $('#soap-modal').fadeIn(200);
            $('body').css('overflow', 'hidden');
        }
        
        function closeModal() {
            $('#soap-modal').fadeOut(200);
            $('body').css('overflow', 'auto');
            $('#soap-form')[0].reset(); 
            $('#modal-title').text('Add New Visit');
            $('#visit_id').val(''); 
            $('#patient_id').val(currentPatientId);
            $('#soap-modal').removeClass('modal-split-view'); 
        }

        function openPrintModal() {
            $('#print-modal').fadeIn(200);
            $('body').css('overflow', 'hidden');
        }
        
        function closePrintModal() {
            $('#print-modal').fadeOut(200);
            $('body').css('overflow', 'auto');
        }

        $('#modal-close-btn, #modal-cancel-btn').on('click', closeModal);
        $('#print-modal-close-btn, #print-cancel-btn').on('click', closePrintModal);

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

        // Print functionality
        $('#visit-history-tbody').on('click', '.btn-print-visit', function() {
            let visitId = $(this).data('visit-id');
            
            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: { action: 'get_visit_details', visit_id: visitId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let visit = response.data;
                        generatePrintView(visit);
                        openPrintModal();
                    } else {
                        showStatusMessage('Error: Could not load visit details for printing.', 'error');
                    }
                }
            });
        });

        function generatePrintView(visit) {
            const printContent = `
                <div class="print-header">
                    <h1>Medical S.O.A.P. Record</h1>
                    <p><strong>Clinic Name</strong> | Printed on: ${new Date().toLocaleDateString()}</p>
                </div>

                <div class="print-patient-info">
                    <h3>Patient Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <strong>Name:</strong> ${currentPatientDetails.first_name} ${currentPatientDetails.middle_name || ''} ${currentPatientDetails.last_name}
                        </div>
                        <div class="form-group">
                            <strong>Patient Code:</strong> ${currentPatientDetails.patient_code}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <strong>Visit Date:</strong> ${visit.visit_date}
                        </div>
                        <div class="form-group">
                            <strong>Case Number:</strong> ${visit.case_number || 'N/A'}
                        </div>
                    </div>
                    ${visit.next_visit ? `<div class="form-row"><div class="form-group"><strong>Next Visit:</strong> ${visit.next_visit}</div></div>` : ''}
                </div>

                <div class="print-soap-section">
                    <h4>Subjective (S) - Patient's Complaints & Symptoms</h4>
                    <div class="print-soap-content">${visit.review_of_systems || 'No subjective notes recorded.'}</div>
                </div>

                <div class="print-soap-section">
                    <h4>Objective (O) - Clinical Findings & Observations</h4>
                    <div class="print-soap-content">${visit.objective || 'No objective findings recorded.'}</div>
                </div>

                <div class="print-soap-section">
                    <h4>Assessment (A) - Diagnosis & Clinical Impression</h4>
                    <div class="print-soap-content">${visit.assessment || 'No assessment recorded.'}</div>
                </div>

                <div class="print-soap-section">
                    <h4>Plan (P) - Treatment Plan & Follow-up</h4>
                    <div class="print-soap-content">${visit.plans || 'No treatment plan recorded.'}</div>
                </div>

                ${visit.notes ? `
                <div class="print-soap-section" style="display:none">
                    <h4>Additional Notes</h4>
                    <div class="print-soap-content">${visit.notes}</div>
                </div>
                ` : ''}

                <div style="margin-top: 60px; padding-top: 20px; border-top: 2px solid #000;">
                    <div class="form-row">
                        <div class="form-group" style="flex: 1;">
                            <strong>Physician's Signature:</strong><br><br>
                            ________________________________<br>
                            <em>Dr. Physician Name</em>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <strong>Date:</strong><br><br>
                            ________________________________<br>
                            <em>${new Date().toLocaleDateString()}</em>
                        </div>
                    </div>
                </div>
            `;
            
            $('#print-content').html(printContent);
        }

        $('#print-btn').on('click', function() {
            window.print();
        });

        $('#soap-form').on('submit', function(e) {
            e.preventDefault(); 
            let formData = $(this).serialize();
            formData += '&action=save_visit'; 

            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<div class="loading"></div> Saving...').prop('disabled', true);

            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    submitBtn.html(originalText).prop('disabled', false);
                    
                    if (response.success) {
                        closeModal();
                        showStatusMessage(response.message, 'success');
                        loadVisitHistory(currentPatientId);
                    } else {
                        showStatusMessage('Error: ' + response.message, 'error');
                    }
                },
                error: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                    showStatusMessage('An unknown error occurred. Please try again.', 'error');
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

        $(document).keydown(function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                $('#patient-search-input').focus();
            }
            
            if (e.key === 'Escape') {
                closeModal();
                closePrintModal();
            }
        });

        $('#patient-search-input').focus();
    });
    </script>

</body>
</html>