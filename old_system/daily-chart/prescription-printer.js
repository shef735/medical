// Filename: prescription-printer.js

function printPrescription(patientName, visitDate, medications = []) {
    if (medications.length === 0) {
        alert('No medication data provided to print.');
        return;
    }

    let medicationsHTML = '';
    medications.forEach(med => {
        // Ensure we have a valid medication name before adding
        if (med.name && med.name.trim() !== '' && med.name.trim() !== 'No data provided.') {
            medicationsHTML += `
                <div class="med-item">
                    <div class="med-name"><strong>${med.name}</strong></div>
                    <div class="med-details">Sig: ${med.dosage || 'N/A'} / ${med.frequency || 'N/A'}</div>
                    <div class="med-instructions">${med.instructions || ''}</div>
                </div>
            `;
        }
    });

    if (medicationsHTML === '') {
        alert('No valid medications found to print.');
        return;
    }

    // --- IMPORTANT: Replace placeholder doctor/clinic info ---
    const printContent = `
        <html>
        <head>
            <title>Prescription for ${patientName}</title>
            <style>
                @page {
                    size: 4.25in 6.5in;
                    margin: 0.4in;
                }

                body {
                    margin: 0;
                    font-family: Arial, sans-serif;
                    font-size: 9pt;
                    position: relative; /* Needed for absolute positioning of footer if desired, but flexbox is better */
                    min-height: 100vh; /* Ensures body takes full viewport height for footer to stick to bottom */
                    display: flex;
                    flex-direction: column; /* Allows content and footer to stack */
                }
                .header {
                    text-align: center;
                    margin-bottom: 15px;
                }
                .patient-info {
                    border-top: 1px solid #ccc;
                    border-bottom: 1px solid #ccc;
                    padding: 8px 0;
                    margin-bottom: 20px;
                    display: flex;
                    justify-content: space-between;
                    font-size: 8.5pt;
                }
                .rx-symbol {
                    font-size: 36px;
                    font-weight: bold;
                    float: left;
                    margin-right: 15px;
                    line-height: 1;
                }
                .med-item {
                    margin-bottom: 12px;
                    border-bottom: 1px dashed #eee;
                    padding-bottom: 10px;
                    page-break-inside: avoid;
                }
                .med-name {
                    font-size: 11pt;
                }
                .med-details, .med-instructions {
                    margin-left: 20px;
                }
                .med-instructions {
                    font-style: italic;
                    color: #333;
                }

                /* --- NEW FOOTER STYLES --- */
                .footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end; /* Aligns content to the bottom */
                    width: 100%;
                    margin-top: auto; /* Pushes footer to the bottom */
                    padding-top: 10px;
                    border-top: 1px solid #eee; /* Optional: adds a subtle line above the footer */
                    font-size: 8pt;
                    page-break-inside: avoid; /* Prevents footer from splitting across pages */
                }
                .footer-left {
                    text-align: center;
                    margin-right: 10px;
                }
                .qr-code {
                    width: 60px; /* Adjust QR code size as needed */
                    height: auto;
                    display: block; /* Remove extra space below image */
                    margin-bottom: 2px;
                }
                .qr-text {
                    font-size: 7pt;
                    font-weight: bold;
                }
                .footer-right {
                    text-align: right;
                    line-height: 1.2;
                }
                .doctor-name-footer {
                    font-weight: bold;
                    font-size: 9pt;
                    margin-bottom: 3px;
                }
                .doctor-details-footer {
                    font-size: 7.5pt;
                    margin-bottom: 5px;
                }
                .license-ptr span {
                    font-weight: bold;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="../../uploads/images/gh_header.png" alt="Clinic Prescription Header" style="width: 100%; height: auto;">
            </div>

            <div class="patient-info">
                <div><strong>Patient:</strong> ${patientName}</div>
                <div><strong>Date:</strong> ${visitDate}</div>
            </div>
            
            <div style="flex-grow: 1;"> <span class="rx-symbol">℞</span>
                ${medicationsHTML}
            </div>

            <div class="footer">
               <div class="footer-left">
                  <!--   <img src="../../uploads/images/qr.png" alt="QR Code" class="qr-code">
                    <div class="qr-text">3JSOL7</div>-->
                </div> 
                <div class="footer-right">
                    <div class="doctor-name-footer">JOSE D. SOLLANO, MD</div>
                    <div class="doctor-details-footer">
                        THERAPEUTIC ENDOSCOPY<br>
                        GastroHep Endoscopy Unit, Commonwealth, QC
                    </div>
                    <div class="license-ptr">
                        Lic. No.: <span>48951</span><br>
                        PTR No.: <span class="dynamic-ptr">____________</span>
                    </div>
                </div>
            </div>

        </body>
        </html>
    `;
    
    const printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write(printContent);
  
    printWindow.document.close();

    setTimeout(function () {
        printWindow.focus();
        printWindow.print();
    }, 500); // Wait 0.5 seconds before printing
}