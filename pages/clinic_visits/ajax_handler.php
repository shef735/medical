<?php
/* File: ajax_handler.php */
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // All responses are JSON
include 'db.php'; // Include database connection and table names

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$response = ['success' => false, 'message' => 'Invalid action.'];

switch ($action) {
    // --- SEARCH FOR A PATIENT ---
    case 'search_patient':
        $query = $_POST['query'] ?? '';
        $searchTerm = "%{$query}%";
        
        $sql = "SELECT patient_id, patient_code, last_name, first_name 
                FROM {$PATIENT_TABLE} 
                WHERE last_name LIKE ? OR first_name LIKE ? OR patient_code LIKE ? GROUP BY patient_code";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $patients = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $patients[] = $row;
        }
        
        $response['success'] = true;
        $response['data'] = $patients;
        break;

    // --- GET A SINGLE PATIENT'S DETAILS ---
    case 'get_patient_details':
        $patient_id = (int)($_POST['patient_id'] ?? 0);
        
        $sql = "SELECT * FROM {$PATIENT_TABLE} WHERE patient_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $patient = mysqli_fetch_assoc($result);
        
        if ($patient) {
            $response['success'] = true;
            $response['data'] = $patient;
        } else {
            $response['message'] = 'Patient not found.';
        }
        break;

    // --- *** MODIFIED CASE *** ---
    // --- GET A PATIENT'S VISIT HISTORY ---
    case 'get_visit_history':
        $patient_id = (int)($_POST['patient_id'] ?? 0);
        
        // --- UPDATED SQL QUERY ---
        // Now selects all the S.O.A.P. columns
        $sql = "SELECT id as visit_id, visit_date, case_number, 
                       review_of_systems, objective, assessment, plans 
                FROM {$VISIT_TABLE} 
                WHERE patient_id = ? 
                ORDER BY visit_date DESC, created_at DESC";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $visits = [];
        while ($row = mysqli_fetch_assoc($result)) {
            if($row ['review_of_systems']=='' AND $row ['objective']=='' AND $row ['assessment']=='' AND $row ['plans']=='' ) {
                continue;
            }
             $visits[] = $row;
            
        }
        
        $response['success'] = true;
        $response['data'] = $visits;
        break;
    // --- *** END OF MODIFIED CASE *** ---

    // --- GET DETAILS FOR A SINGLE VISIT (FOR EDITING) ---
    case 'get_visit_details':
        $visit_id = (int)($_POST['visit_id'] ?? 0);
        
        $sql = "SELECT *, id as visit_id FROM {$VISIT_TABLE} WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $visit_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $visit = mysqli_fetch_assoc($result);
        
        if ($visit) {
            $response['success'] = true;
            $response['data'] = $visit;
        } else {
            $response['message'] = 'Visit not found.';
        }
        break;

    // --- SAVE (INSERT OR UPDATE) A VISIT ---
    case 'save_visit':
        // Get all POST data
        $visit_id = (int)($_POST['visit_id'] ?? 0);
        $patient_id = (int)($_POST['patient_id'] ?? 0);
        
        $visit_date = !empty($_POST['visit_date']) ? $_POST['visit_date'] : '';
        $case_number = $_POST['case_number'] ?? '';
        $review_of_systems = $_POST['review_of_systems'] ?? '';
        $objective = $_POST['objective'] ?? '';
        $assessment = $_POST['assessment'] ?? '';
        $plans = $_POST['plans'] ?? '';
        $next_visit = !empty($_POST['next_visit']) ? $_POST['next_visit'] : '';
        $notes = $_POST['notes'] ?? '';

        if (empty($patient_id)) {
            $response['message'] = 'Patient ID is missing.';
            break;
        }

        if ($visit_id > 0) {
            // --- UPDATE Existing Visit ---
            $sql = "UPDATE {$VISIT_TABLE} SET
                        visit_date = ?, case_number = ?, review_of_systems = ?,
                        objective = ?, assessment = ?, plans = ?,
                        next_visit = ?, notes = ?
                    WHERE id = ?";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssssi",
                $visit_date, $case_number, $review_of_systems,
                $objective, $assessment, $plans,
                $next_visit, $notes, $visit_id
            );
            
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'Visit updated successfully.';
            } else {
                $response['message'] = 'Error updating visit: ' . mysqli_error($conn);
            }

        } else {
            // --- INSERT New Visit ---
            
            // First, get the patient's redundant info
            $sql_pat = "SELECT user_id, patient_code, last_name, first_name, middle_name 
                        FROM {$PATIENT_TABLE} WHERE patient_id = ?";
            $stmt_pat = mysqli_prepare($conn, $sql_pat);
            mysqli_stmt_bind_param($stmt_pat, "i", $patient_id);
            mysqli_stmt_execute($stmt_pat);
            $result_pat = mysqli_stmt_get_result($stmt_pat);
            $patient = mysqli_fetch_assoc($result_pat);
            
            if (!$patient) {
                $response['message'] = 'Patient not found for creating visit.';
                break;
            }
            
            $sql = "INSERT INTO {$VISIT_TABLE} (
                        patient_id, user_id, patient_code, last_name, first_name, middle_name,
                        visit_date, case_number, review_of_systems, objective, assessment, plans,
                        next_visit, notes
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "isssssssssssss",
                $patient_id, $patient['user_id'], $patient['patient_code'], $patient['last_name'],
                $patient['first_name'], $patient['middle_name'],
                $visit_date, $case_number, $review_of_systems,
                $objective, $assessment, $plans,
                $next_visit, $notes
            );

            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'New visit saved successfully.';
            } else {
                $response['message'] = 'Error saving new visit: ' . mysqli_error($conn);
            }
        }
        break;

        // --- *** NEW CASE ADDED *** ---
    // --- GET THE MOST RECENT VISIT FOR A PATIENT ---
    case 'get_last_visit':
        $patient_id = (int)($_POST['patient_id'] ?? 0);
        
        $sql = "SELECT * FROM {$VISIT_TABLE} 
                WHERE patient_id = ? 
                ORDER BY visit_date DESC, id DESC 
                LIMIT 1";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $visit = mysqli_fetch_assoc($result); // Fetches one row or null
        
        $response['success'] = true;
        $response['data'] = $visit; // Send the visit object, or null if no previous visit
        break;
    // --- *** END OF NEW CASE *** ---

    default:
        $response['message'] = "Action '{$action}' not recognized.";
}

// Close connection and send response
mysqli_close($conn);
echo json_encode($response);
exit;
?>