<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<style>
  .file-list_lab {
            margin-top: 10px;
        }
        .file-item_lab {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .preview-image_lab {
            max-width: 100px; /* Set a limit for the preview image size */
            margin-left: 10px;
            margin-right: 10px;
        }
        .remove-button_lab {
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
                                            <input type="file" name="files_lab[]" accept="*" multiple required id="fileInput_lab">           
                                        </label>                                       
                                    </div>

                                    <div class="file-list_lab" id="fileList_lab"></div>
                                </div>   



                                  <script>
   let selectedFiles_lab = []; // Array to hold selected files

    document.getElementById('fileInput_lab').addEventListener('change', function () {
        const fileList_lab = document.getElementById('fileList_lab'); // Get the file list element

        // Append newly selected files to the existing selectedFiles array
        const newFiles_lab = Array.from(this.files); // Get newly selected files
        selectedFiles_lab = [...selectedFiles_lab, ...newFiles_lab]; // Combine selected files

        // Update the file list display
        updateFileList_lab();
        updateFileInput_lab(); // Update the file input after changing selected files
    });

    function updateFileList_lab() {
        const fileList_lab = document.getElementById('fileList_lab'); // Get the file list element
        fileList_lab.innerHTML = ''; // Clear previous HTML elements in the file list

        selectedFiles_lab.forEach((file_lab, index_lab) => {
            const listItem_lab = document.createElement('div'); // Create a new list item
            listItem_lab.className = 'file-item_lab';
            listItem_lab.textContent = `File Name: ${file_lab.name}, File Size: ${file_lab.size} bytes`;

            // Create an image preview if the file is an image
            if (file_lab.type.startsWith('image/')) {
                const img_lab = document.createElement('img'); // Create an image element
                img_lab.src = URL.createObjectURL(file_lab); // Create a local URL for the image
                img_lab.className = 'preview-image_lab';
                listItem_lab.appendChild(img_lab); // Append image to the list item
            }

            // Create a Remove button
            const removeButton_lab = document.createElement('button'); // Create a button element
            removeButton_lab.textContent = 'Remove';
            removeButton_lab.className = 'remove-button_lab';
            removeButton_lab.onclick = () => {
                // Remove the file from the array
                selectedFiles_lab.splice(index_lab, 1); 
                updateFileList_lab(); // Refresh the file list display
                updateFileInput_lab(); // Update the file input
            };
            listItem_lab.appendChild(removeButton_lab); // Append button to the list item

            fileList_lab.appendChild(listItem_lab); // Append list item to the file list
        });
    }

    function updateFileInput_lab() {
        const input_lab = document.getElementById('fileInput_lab'); // Get the file input element
        const dataTransfer_lab = new DataTransfer(); // Create a new DataTransfer object
        
        // Add remaining files to the DataTransfer object
        selectedFiles_lab.forEach(file_lab => {
            dataTransfer_lab.items.add(file_lab);
        });
        
        // Update the input's files property
        input_lab.files = dataTransfer_lab.files; 
    }
</script>