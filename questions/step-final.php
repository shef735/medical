<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

                    <header>
                        <h2>
                          PATIENT FORM
                        </h2>
                    </header>

                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 11</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">Imaging and Procedures done</h3>
                             <p class="p-text">
                                (within 6 mos or most recent)
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step11">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Magnetic Resonance Imaging (MRI)">
                                        <label>Magnetic Resonance Imaging (MRI)</label>
                                         
                                    </div>


                                     <!--   <div class="input-field delay-200ms" >
                                            <label>Date :  
                                                    <input type="date" name="imaging_date1"   >
                                            
                                            </label>

                                            <label>Diagnosis:   
                                                    <input type="text" name="imaging_diagnosis1"   >
                                            
                                            </label>
                                        </div> -->
                                    
                                </div>

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Magnetic Resonance Enterography (MRE)">
                                        <label>Magnetic Resonance Enterography (MRE)</label>
                                         
                                    </div>

                                </div>

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Computed Tomography (CT scan)">
                                        <label>Computed Tomography (CT scan)</label>
                                         
                                    </div>

 
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Pelvic MRI">
                                        <label>Pelvic MRI</label>
                                         
                                    </div>

 
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Intestinal Ultrasound">
                                        <label>Intestinal Ultrasound</label>                                       
                                    </div>
                                </div>

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Colonoscopy">
                                        <label>Colonoscopy</label>                                       
                                    </div>
                                </div>

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Biopsy">
                                        <label>Biopsy</label>                                       
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="imaging[]" value="Upper GI Endoscopy (EGD)">
                                        <label>Upper GI Endoscopy (EGD)</label>                                       
                                    </div>
                                </div>


                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>Others (Specify):  
                                     <input type="text" name="imaging_others"   >
                                     
                                    </label>
                                       
                                        
                                    </div>
                                </div>       


                                                         
                        
                            </div>

                               <?php include "step-final-file.php" ?>  

                        </fieldset>
                    </div>
                    