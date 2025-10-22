<?php
session_start();
ob_start();
include "db.php";

// Get patient ID from URL
$patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch patient data
$query = "SELECT * FROM patient_info WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    die("Patient not found.");
}

// Store current values
$current_values = [
    'date' => $patient['date'],
    'last_name' => $patient['last_name'],
    'first_name' => $patient['first_name'],
    'middle_name' => $patient['middle_name'],
    'address' => $patient['address'],
    'email' => $patient['email'],
    'birthday' => $patient['birthday'],
    'phone' => $patient['phone'],
    'sex' => $patient['sex'],
    'height_cm' => $patient['height_cm'],
    'weight_kg' => $patient['weight_kg'],
    'blood_group' => $patient['blood_group'],
    'civil_status' => $patient['civil_status'],
    'psgc_region' => $patient['psgc_region'],
    'psgc_province' => $patient['psgc_province'],
    'psgc_municipality' => $patient['psgc_municipality'],
    'psgc_barangay' => $patient['psgc_barangay'],
    'ZipCode' => $patient['ZipCode'],
    'NoBldgName' => $patient['NoBldgName'],
    'StreetName' => $patient['StreetName'],
    'photo' => $patient['photo']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* Your existing CSS styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .home-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .home-btn:hover {
            background-color: #218838;
        }
        
        .page-title {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
        }
        
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: white;
            cursor: pointer;
        }
        
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            width: 100%;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            background-color: #2980b9;
        }
        
        .camera-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .camera-preview {
            width: 320px;
            height: 240px;
            border: 2px solid #3498db;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #000;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .camera-preview img, 
        .camera-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .camera-controls {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .camera-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .camera-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .capture-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .start-camera-btn {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .stop-camera-btn {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .upload-btn {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
        }

        .switch-camera-btn {
            background: #6c757d;
            color: white;
        }

        .camera-status {
            margin-top: 8px;
            font-size: 13px;
            color: #6c757d;
            text-align: center;
            min-height: 20px;
        }

        .camera-preview::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            height: 80%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            pointer-events: none;
            z-index: 1;
        }
        
        .upload-btn {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        
        .patient-info-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .patient-info-banner h3 {
            margin: 0;
            font-size: 18px;
        }
        
        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <a href="../patient-list.php" class="home-btn">
                <i class="fas fa-arrow-left"></i> BACK TO LIST
            </a>
            <h1 class="page-title">Edit Patient Information</h1>
        </div>
        
        <div class="patient-info-banner">
            <h3>Editing: <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?> (<?php echo htmlspecialchars($patient['patient_code']); ?>)</h3>
        </div>
        
        <form id="patientForm" method="post" action="update_patient.php" enctype="multipart/form-data">
            <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">
            
            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label" for="date">Date:</label>
                        <input class="form-control" type="date" name="date" id="date" value="<?php echo htmlspecialchars($current_values['date']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="last_name">Last Name:</label>
                        <input class="form-control" required type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($current_values['last_name']); ?>" placeholder="Last Name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="first_name">First Name:</label>
                        <input class="form-control" required type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($current_values['first_name']); ?>" placeholder="First Name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="middle_name">Middle Name:</label>
                        <input class="form-control" required type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($current_values['middle_name']); ?>" placeholder="Middle Name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address:</label>
                        <input class="form-control" required type="email" name="email" id="mail-email" value="<?php echo htmlspecialchars($current_values['email']); ?>" placeholder="Email address">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="birthday">Birthday:</label>
                        <input class="form-control" type="date" name="birthday" id="birthday" value="<?php echo htmlspecialchars($current_values['birthday']); ?>">
                    </div>
                </div>

                <!-- Middle Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label" for="civil_status">Civil Status:</label>
                        <select class="form-select" name="civil_status" id="civil_status">
                            <option value="Single" <?php echo $current_values['civil_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                            <option value="Married" <?php echo $current_values['civil_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="sex">Gender:</label>
                        <select class="form-select" name="sex" id="sex">
                            <option value="Male" <?php echo $current_values['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $current_values['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="phone">Phone:</label>
                        <input class="form-control" type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($current_values['phone']); ?>" placeholder="Contact / Phone Number">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="blood_group">Blood Type:</label>
                        <select class="form-select" name="blood_group" id="blood_group">
                            <option value="N/A" <?php echo $current_values['blood_group'] == 'N/A' ? 'selected' : ''; ?>>N/A</option>
                            <option value="A+" <?php echo $current_values['blood_group'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                            <option value="A-" <?php echo $current_values['blood_group'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                            <option value="B+" <?php echo $current_values['blood_group'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                            <option value="B-" <?php echo $current_values['blood_group'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                            <option value="O+" <?php echo $current_values['blood_group'] == 'O+' ? 'selected' : ''; ?>>O+</option>
                            <option value="O-" <?php echo $current_values['blood_group'] == 'O-' ? 'selected' : ''; ?>>O-</option>
                            <option value="AB+" <?php echo $current_values['blood_group'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                            <option value="AB-" <?php echo $current_values['blood_group'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="height_cm">Height (cm):</label>
                        <input class="form-control" type="number" step="0.1" name="height_cm" id="height_cm" value="<?php echo htmlspecialchars($current_values['height_cm']); ?>" placeholder="Height in centimeters">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="weight_kg">Weight (kg):</label>
                        <input class="form-control" type="number" step="0.1" name="weight_kg" id="weight_kg" value="<?php echo htmlspecialchars($current_values['weight_kg']); ?>" placeholder="Weight in kilograms">
                    </div>
                </div>
                
                <!-- Right Column - Address Section -->
                <div class="form-column">
                    <?php
                    // Pass current values to address.php using global variables or extract
                    $address_values = [
                        'psgc_region' => $current_values['psgc_region'],
                        'psgc_province' => $current_values['psgc_province'],
                        'psgc_municipality' => $current_values['psgc_municipality'],
                        'psgc_barangay' => $current_values['psgc_barangay'],
                        'ZipCode' => $current_values['ZipCode'],
                        'NoBldgName' => $current_values['NoBldgName'],
                        'StreetName' => $current_values['StreetName'],
                        'address' => $current_values['address']
                    ];
                    
                    // Include address.php with the values
                    include "address.php";
                    ?>
                </div>
            </div>
            
            <!-- Camera Section -->
            <div class="camera-section">
                <h3 class="camera-title">Patient Photo</h3>
                <div class="camera-container">
                    <div class="camera-preview" id="cameraPreview">
                        <?php if(!empty($current_values['photo']) && file_exists($current_values['photo'])): ?>
                            <img src="<?php echo $current_values['photo']; ?>" alt="Current Patient Photo">
                        <?php else: ?>
                            <span>No image selected</span>
                        <?php endif; ?>
                    </div>
                    <div class="camera-controls">
                        <button type="button" class="camera-btn start-camera-btn" id="startCameraBtn">
                            <i class="fas fa-camera"></i> Start Camera
                        </button>
                        <button type="button" class="camera-btn capture-btn" id="captureBtn" disabled>
                            <i class="fas fa-camera-retro"></i> Capture Photo
                        </button>
                        <button type="button" class="camera-btn stop-camera-btn" id="stopCameraBtn" disabled>
                            <i class="fas fa-stop-circle"></i> Stop Camera
                        </button>
                        <input type="file" id="cameraInput" accept="image/*" name="patient_photo_file" style="display: none;">
                        <button type="button" class="camera-btn upload-btn" id="uploadBtn">
                            <i class="fas fa-upload"></i> Upload Photo
                        </button>
                    </div>
                    <div class="camera-status" id="cameraStatus">Camera is not active</div>
                    <input type="hidden" name="patient_photo_base64" id="patientPhotoBase64" value="">
                </div>
            </div>
            
            <!-- Submit Button -->
            <button class="submit-btn" type="submit" id="sub">
                <i class="fas fa-save"></i> &nbsp;UPDATE PATIENT INFORMATION
            </button>
        </form>
    </div>
    
    <script>
        // Camera functionality
        let stream = null;
        let video = null;
        let canvas = null;

        document.getElementById('startCameraBtn').addEventListener('click', async function() {
            try {
                // Request camera access
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        width: { ideal: 640 },
                        height: { ideal: 480 },
                        facingMode: 'environment'
                    }, 
                    audio: false 
                });
                
                // Create video element if it doesn't exist
                if (!video) {
                    video = document.createElement('video');
                    video.autoplay = true;
                    video.playsInline = true;
                }
                
                // Set video source to camera stream
                video.srcObject = stream;
                
                // Clear preview and add video
                const preview = document.getElementById('cameraPreview');
                preview.innerHTML = '';
                preview.appendChild(video);
                
                // Update UI
                document.getElementById('startCameraBtn').disabled = true;
                document.getElementById('captureBtn').disabled = false;
                document.getElementById('stopCameraBtn').disabled = false;
                document.getElementById('cameraStatus').textContent = 'Camera is active - Ready to capture';
                document.getElementById('cameraStatus').style.color = '#28a745';
                
            } catch (error) {
                console.error('Error accessing camera:', error);
                document.getElementById('cameraStatus').textContent = 'Error accessing camera: ' + error.message;
                document.getElementById('cameraStatus').style.color = '#dc3545';
            }
        });

        document.getElementById('captureBtn').addEventListener('click', function() {
            if (!video) return;
            
            // Create canvas if it doesn't exist
            if (!canvas) {
                canvas = document.createElement('canvas');
            }
            
            const context = canvas.getContext('2d');
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw current video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert canvas to data URL (lower quality to reduce size)
            const imageDataUrl = canvas.toDataURL('image/jpeg', 0.7);
            
            // Create image element and display captured photo
            const img = document.createElement('img');
            img.src = imageDataUrl;
            
            // Update preview
            const preview = document.getElementById('cameraPreview');
            preview.innerHTML = '';
            preview.appendChild(img);
            
            // Store the base64 encoded image in a hidden field
            document.getElementById('patientPhotoBase64').value = imageDataUrl;
            
            // Clear any file input
            document.getElementById('cameraInput').value = '';
            
            // Update status
            document.getElementById('cameraStatus').textContent = 'Photo captured successfully!';
            document.getElementById('cameraStatus').style.color = '#28a745';
        });

        document.getElementById('stopCameraBtn').addEventListener('click', function() {
            if (stream) {
                // Stop all tracks in the stream
                stream.getTracks().forEach(track => track.stop());
                stream = null;
                
                // Update UI
                document.getElementById('startCameraBtn').disabled = false;
                document.getElementById('captureBtn').disabled = true;
                document.getElementById('stopCameraBtn').disabled = true;
                document.getElementById('cameraStatus').textContent = 'Camera stopped';
                document.getElementById('cameraStatus').style.color = '#6c757d';
            }
        });

        // Handle photo upload as fallback
        document.getElementById('uploadBtn').addEventListener('click', function() {
            document.getElementById('cameraInput').click();
        });

        document.getElementById('cameraInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Please select an image smaller than 5MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('cameraPreview');
                    preview.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    preview.appendChild(img);
                    
                    // Clear base64 data when using file upload
                    document.getElementById('patientPhotoBase64').value = '';
                    
                    // Update status
                    document.getElementById('cameraStatus').textContent = 'Photo uploaded successfully!';
                    document.getElementById('cameraStatus').style.color = '#28a745';
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation
        document.getElementById('patientForm').addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = document.querySelectorAll('input[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                } else {
                    field.style.borderColor = '#ddd';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    </script>
</body>
</html>