<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>
   
  <!-- step 9 -->
                <section class="steps">

                   <?php include "header.php" ?>
                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 9</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">Vaccines done</h3>
                             <p class="p-text">
                               (within 6 mos or most recent)
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step9">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="vaccines[]" value="Varicella zoster">
                                        <label>Varicella zoster Rate (ESR)</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Herpes Zoster">
                                        <label>Herpes Zoster</label>
                                    </div>
                                </div>     

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="MMR">
                                        <label>MMR</label>
                                    </div>
                                </div>       

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="TDaP/DTaP">
                                        <label>TDaP/DTaP</label>
                                    </div>
                                </div>        

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="HPV">
                                        <label>HPV</label>
                                    </div>
                                </div>        


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Hepatitis A">
                                        <label>Hepatitis A</label>
                                    </div>
                                </div>       


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Hepatitis B">
                                        <label>Hepatitis B</label>
                                    </div>
                                </div>         

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Meningitis">
                                        <label>Meningitis</label>
                                    </div>
                                </div>     

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Pneumonia (PCV13 & PPSV23)">
                                        <label>Pneumonia (PCV13 & PPSV23)</label>
                                    </div>
                                </div>   


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="Seasonal Influenza">
                                        <label>Seasonal Influenza</label>
                                    </div>
                                </div>   

                                  

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="vaccines[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div> 
                        
                            </div>

                            <?php include "step9-file.php" ?>    

                        </fieldset>
                    </div>
                    
                    <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <button class="prev" type="button"><span>Previous Question</span></button>
                                <div class="bar-inner">
                                    <span class="bar-text">85% complete. keep it up!</span>
                                    <div class="w-85 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step9btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>