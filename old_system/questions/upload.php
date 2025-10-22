<?php  $targetDir = "../../uploads/"; // Directory to save uploaded files

    // Create the directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $uploadStatus = [];

    // Loop through each uploaded file
    foreach ($_FILES['files_lab']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['files_lab']['name'][$key]);
        $targetFile = $targetDir . $file_name;
        $uploadOk = 1;

        // Limit file size (for example, up to 5MB each)
        if ($_FILES['files_lab']['size'][$key] > 5000000) {
            $uploadStatus[] = "$file_name: Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Check for file name collisions
        if (file_exists($targetFile)) {
            $uploadStatus[] = "$file_name: Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Only allow certain file formats (optional)
        $fileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt']; // Customize allowed types
        if (!in_array($fileType, $allowedTypes)) {
            $uploadStatus[] = "$file_name: Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, and TXT files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $uploadStatus[] = "$file_name: Sorry, your file was not uploaded.";
        } else {
            // Try to upload file
            if (move_uploaded_file($tmp_name, $targetFile)) {
                $uploadStatus[] = "$file_name: The file has been uploaded.";
            } else {
                $uploadStatus[] = "$file_name: Sorry, there was an error uploading your file.";
            }
        }
    }

    // Display upload status for each file
    foreach ($uploadStatus as $status) {
        echo $status . "<br>";
    }
 
?>