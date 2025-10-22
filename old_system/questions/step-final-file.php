<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<style>
  .file-list_ima {
            margin-top: 10px;
        }
        .file-item_ima {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .preview-image_ima {
            max-width: 100px; /* Set a limit for the preview image size */
            margin-left: 10px;
            margin-right: 10px;
        }
        .remove-button_ima {
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
                                            <input type="file" name="files_ima[]" accept="*" multiple required id="fileInput_ima">           
                                        </label>                                       
                                    </div>

                                    <div class="file-list_ima" id="fileList_ima"></div>
                                </div>   



                                  <script>
   let selectedFiles_ima = []; // Array to hold selected files

    document.getElementById('fileInput_ima').addEventListener('change', function () {
        const fileList_ima = document.getElementById('fileList_ima'); // Get the file list element

        // Append newly selected files to the existing selectedFiles array
        const newFiles_ima = Array.from(this.files); // Get newly selected files
        selectedFiles_ima = [...selectedFiles_ima, ...newFiles_ima]; // Combine selected files

        // Update the file list display
        updateFileList_ima();
        updateFileInput_ima(); // Update the file input after changing selected files
    });

    function updateFileList_ima() {
        const fileList_ima = document.getElementById('fileList_ima'); // Get the file list element
        fileList_ima.innerHTML = ''; // Clear previous HTML elements in the file list

        selectedFiles_ima.forEach((file_ima, index_ima) => {
            const listItem_ima = document.createElement('div'); // Create a new list item
            listItem_ima.className = 'file-item_ima';
            listItem_ima.textContent = `File Name: ${file_ima.name}, File Size: ${file_ima.size} bytes`;

            // Create an image preview if the file is an image
            if (file_ima.type.startsWith('image/')) {
                const img_ima = document.createElement('img'); // Create an image element
                img_ima.src = URL.createObjectURL(file_ima); // Create a local URL for the image
                img_ima.className = 'preview-image_ima';
                listItem_ima.appendChild(img_ima); // Append image to the list item
            }

            // Create a Remove button
            const removeButton_ima = document.createElement('button'); // Create a button element
            removeButton_ima.textContent = 'Remove';
            removeButton_ima.className = 'remove-button_ima';
            removeButton_ima.onclick = () => {
                // Remove the file from the array
                selectedFiles_ima.splice(index_ima, 1); 
                updateFileList_ima(); // Refresh the file list display
                updateFileInput_ima(); // Update the file input
            };
            listItem_ima.appendChild(removeButton_ima); // Append button to the list item

            fileList_ima.appendChild(listItem_ima); // Append list item to the file list
        });
    }

    function updateFileInput_ima() {
        const input_ima = document.getElementById('fileInput_ima'); // Get the file input element
        const dataTransfer_ima = new DataTransfer(); // Create a new DataTransfer object
        
        // Add remaining files to the DataTransfer object
        selectedFiles_ima.forEach(file_ima => {
            dataTransfer_ima.items.add(file_ima);
        });
        
        // Update the input's files property
        input_ima.files = dataTransfer_ima.files; 
    }
</script>