<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<style>
  .file-list_vac {
            margin-top: 10px;
        }
        .file-item_vac {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .preview-image_vac {
            max-width: 100px; /* Set a limit for the preview image size */
            margin-left: 10px;
            margin-right: 10px;
        }
        .remove-button_vac {
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
                                            <input type="file" name="files_vac[]" accept="*" multiple required id="fileInput_vac">           
                                        </label>                                       
                                    </div>

                                    <div class="file-list_vac" id="fileList_vac"></div>
                                </div>   



                                  <script>
   let selectedFiles_vac = []; // Array to hold selected files

    document.getElementById('fileInput_vac').addEventListener('change', function () {
        const fileList_vac = document.getElementById('fileList_vac'); // Get the file list element

        // Append newly selected files to the existing selectedFiles array
        const newFiles_vac = Array.from(this.files); // Get newly selected files
        selectedFiles_vac = [...selectedFiles_vac, ...newFiles_vac]; // Combine selected files

        // Update the file list display
        updateFileList_vac();
        updateFileInput_vac(); // Update the file input after changing selected files
    });

    function updateFileList_vac() {
        const fileList_vac = document.getElementById('fileList_vac'); // Get the file list element
        fileList_vac.innerHTML = ''; // Clear previous HTML elements in the file list

        selectedFiles_vac.forEach((file_vac, index_vac) => {
            const listItem_vac = document.createElement('div'); // Create a new list item
            listItem_vac.className = 'file-item_vac';
            listItem_vac.textContent = `File Name: ${file_vac.name}, File Size: ${file_vac.size} bytes`;

            // Create an image preview if the file is an image
            if (file_vac.type.startsWith('image/')) {
                const img_vac = document.createElement('img'); // Create an image element
                img_vac.src = URL.createObjectURL(file_vac); // Create a local URL for the image
                img_vac.className = 'preview-image_vac';
                listItem_vac.appendChild(img_vac); // Append image to the list item
            }

            // Create a Remove button
            const removeButton_vac = document.createElement('button'); // Create a button element
            removeButton_vac.textContent = 'Remove';
            removeButton_vac.className = 'remove-button_vac';
            removeButton_vac.onclick = () => {
                // Remove the file from the array
                selectedFiles_vac.splice(index_vac, 1); 
                updateFileList_vac(); // Refresh the file list display
                updateFileInput_vac(); // Update the file input
            };
            listItem_vac.appendChild(removeButton_vac); // Append button to the list item

            fileList_vac.appendChild(listItem_vac); // Append list item to the file list
        });
    }

    function updateFileInput_vac() {
        const input_vac = document.getElementById('fileInput_vac'); // Get the file input element
        const dataTransfer_vac = new DataTransfer(); // Create a new DataTransfer object
        
        // Add remaining files to the DataTransfer object
        selectedFiles_vac.forEach(file_vac => {
            dataTransfer_vac.items.add(file_vac);
        });
        
        // Update the input's files property
        input_vac.files = dataTransfer_vac.files; 
    }
</script>