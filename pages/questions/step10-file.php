<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<style>
  .file-list_med {
            margin-top: 10px;
        }
        .file-item_med {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .preview-image_med {
            max-width: 100px; /* Set a limit for the preview image size */
            margin-left: 10px;
            margin-right: 10px;
        }
        .remove-button_med {
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
</style>


<div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                        <label>UPLOAD FILES :   
                                            <input type="file" name="files_med[]" accept="*" multiple required id="fileInput_med">           
                                        </label>                                       
                                    </div>

                                    <div class="file-list_med" id="fileList_med"></div>
                                </div>   



                                  <script>
   let selectedFiles_med = []; // Array to hold selected files

    document.getElementById('fileInput_med').addEventListener('change', function () {
        const fileList_med = document.getElementById('fileList_med'); // Get the file list element

        // Append newly selected files to the existing selectedFiles array
        const newFiles_med = Array.from(this.files); // Get newly selected files
        selectedFiles_med = [...selectedFiles_med, ...newFiles_med]; // Combine selected files

        // Update the file list display
        updateFileList_med();
        updateFileInput_med(); // Update the file input after changing selected files
    });

    function updateFileList_med() {
        const fileList_med = document.getElementById('fileList_med'); // Get the file list element
        fileList_med.innerHTML = ''; // Clear previous HTML elements in the file list

        selectedFiles_med.forEach((file_med, index_med) => {
            const listItem_med = document.createElement('div'); // Create a new list item
            listItem_med.className = 'file-item_med';
            listItem_med.textContent = `File Name: ${file_med.name}, File Size: ${file_med.size} bytes`;

            // Create an image preview if the file is an image
            if (file_med.type.startsWith('image/')) {
                const img_med = document.createElement('img'); // Create an image element
                img_med.src = URL.createObjectURL(file_med); // Create a local URL for the image
                img_med.className = 'preview-image_med';
                listItem_med.appendChild(img_med); // Append image to the list item
            }

            // Create a Remove button
            const removeButton_med = document.createElement('button'); // Create a button element
            removeButton_med.textContent = 'Remove';
            removeButton_med.className = 'remove-button_med';
            removeButton_med.onclick = () => {
                // Remove the file from the array
                selectedFiles_med.splice(index_med, 1); 
                updateFileList_med(); // Refresh the file list display
                updateFileInput_med(); // Update the file input
            };
            listItem_med.appendChild(removeButton_med); // Append button to the list item

            fileList_med.appendChild(listItem_med); // Append list item to the file list
        });
    }

    function updateFileInput_med() {
        const input_med = document.getElementById('fileInput_med'); // Get the file input element
        const dataTransfer_med = new DataTransfer(); // Create a new DataTransfer object
        
        // Add remaining files to the DataTransfer object
        selectedFiles_med.forEach(file_med => {
            dataTransfer_med.items.add(file_med);
        });
        
        // Update the input's files property
        input_med.files = dataTransfer_med.files; 
    }
</script>