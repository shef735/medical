<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

  <!-- step 8 -->
                <section class="steps">

                    <?php include "header.php" ?>
                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 8</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">Laboratories done</h3>
                             <p class="p-text">
                               (within 6 mos or most recent)
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step8">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="laboratories[]" value="Erythrocyte Sedimentation Rate (ESR)">
                                        <label>Erythrocyte Sedimentation Rate (ESR)</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="C-Reactive Protein (CRP)">
                                        <label>C-Reactive Protein (CRP)</label>
                                    </div>
                                </div>     

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Hemoglobin (HGB)">
                                        <label>Hemoglobin (HGB)</label>
                                    </div>
                                </div>       

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Hematocrit (HGT)">
                                        <label>Hematocrit (HGT)</label>
                                    </div>
                                </div>        

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Platelet count">
                                        <label>Platelet count</label>
                                    </div>
                                </div>        


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Fecal Calprotectin">
                                        <label>Fecal Calprotectin</label>
                                    </div>
                                </div>       


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Fecal occult blood test (FIT)">
                                        <label>Fecal occult blood test (FIT)</label>
                                    </div>
                                </div>         

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Vitamin D">
                                        <label>Vitamin D</label>
                                    </div>
                                </div>     

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Vitamin B12">
                                        <label>Vitamin B12</label>
                                    </div>
                                </div>   


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="Serum Iron">
                                        <label>Serum Iron</label>
                                    </div>
                                </div>   

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="C. difficile infection">
                                        <label>C. difficile infection</label>
                                    </div>
                                </div> 

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="laboratories[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div> 
                                
                        
                            </div>

                               <?php include "step8-file.php" ?>    

                       
                        </fieldset>
                        
                    </div>

                    
                    
                    <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <button class="prev" type="button"><span>Previous Question</span></button>
                                <div class="bar-inner">
                                    <span class="bar-text">80% complete. keep it up!</span>
                                    <div class="w-80 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step8btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>

       