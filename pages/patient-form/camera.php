 
    <style>
        /* Custom styles for the modal */
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
        #cameraPreview, #photoPreview {
            width: 80%;
            border-radius: 10px;
             display: block; /* Ensures the element is treated as a block-level element */
    margin: 0 auto; /* Centers the element horizontally */
            
        }
        #photoPreview {
            display: none; /* Hidden by default */
            margin-top: 10px;
        }
    </style>
 
   <div >
    <div class="col-md-12 col-sm-12">
        <label for="photofile">Profile Photo</label>
        
          <div class="col-md-10 col-sm-10">
    <!-- Container to hold the file input and button -->
    <div class="input-group">
        <!-- File input -->
        <input class="form-control" type="file" style="border-radius: 10px;" 
                id="photofile" name="photofile" 
               accept="image/*" style="display: none;">
        
        <!-- Button to open the camera popup -->
        <div class="input-group-append">
            <button type="button" id="openCameraBtn" class="btn btn-danger">
                <i class="fa fa-camera"></i>
            </button>
        </div>
    </div>
</div>
           
       
        
        <!-- Photo preview -->
        <br>
        <img id="photoPreview" src="#" alt="Captured Photo Preview" class="img-fluid mt-3">
         <hr>
    </div>
</div>

    <!-- Camera Popup Modal -->
    <div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalLabel">Take a Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Video element to display camera stream -->
                    <video id="cameraPreview" autoplay></video>
                    
                    <!-- Canvas to capture the photo -->
                    <canvas id="photoCanvas" style="display: none;"></canvas>
                </div>
                <div class="modal-footer">
                    <!-- Button to capture the photo -->
                    <button type="button" id="capturePhotoBtn" class="btn btn-success">Capture Photo</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        const openCameraBtn = document.getElementById('openCameraBtn');
        const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
        const cameraPreview = document.getElementById('cameraPreview');
        const capturePhotoBtn = document.getElementById('capturePhotoBtn');
        const photoCanvas = document.getElementById('photoCanvas');
        const photoInput = document.getElementById('photofile');
        const photoPreview = document.getElementById('photoPreview');
        let stream;

        // Open camera when the button is clicked
        openCameraBtn.addEventListener('click', async () => {
            try {
                // Access the camera
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraPreview.srcObject = stream;
                cameraModal.show(); // Show the modal
            } catch (error) {
                console.error('Error accessing the camera:', error);
                alert('Unable to access the camera. Please ensure you have granted permission.');
            }
        });

        // Capture photo when the capture button is clicked
        capturePhotoBtn.addEventListener('click', () => {
            const context = photoCanvas.getContext('2d');
            photoCanvas.width = cameraPreview.videoWidth;
            photoCanvas.height = cameraPreview.videoHeight;

            // Draw the current frame from the video onto the canvas
            context.drawImage(cameraPreview, 0, 0, photoCanvas.width, photoCanvas.height);

            // Convert the canvas image to a data URL
            const photoDataURL = photoCanvas.toDataURL('image/png');

            // Show the photo preview
            photoPreview.src = photoDataURL;
            photoPreview.style.display = 'block';

            // Convert the canvas image to a Blob (image file)
            photoCanvas.toBlob((blob) => {
                // Create a File object from the Blob
                const file = new File([blob], 'captured-photo.png', { type: 'image/png' });

                // Create a DataTransfer object to simulate a file input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                // Assign the file to the input element
                photoInput.files = dataTransfer.files;

                // Stop the camera stream
                stream.getTracks().forEach(track => track.stop());

                // Close the modal
                cameraModal.hide();
            }, 'image/png');
        });

        // Stop the camera stream when the modal is closed
        document.getElementById('cameraModal').addEventListener('hidden.bs.modal', () => {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
 