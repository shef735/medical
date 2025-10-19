<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


     <!-- step 3 -->
                <section class="steps">

                   <?php include "header.php" ?>

                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 3</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">PAST MEDICAL HISTORY</h3>
                             <p class="p-text">
                                Check all boxes with indication of your past medical history
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step3">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="medical_history[]" value="Amoebiasis">
                                        <label>Amoebiasis</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medical_history[]" value="Boil or Carbuncle (pigsa sa puwet)">
                                        <label>Boil or Carbuncle (pigsa sa puwet) </label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms">
                                        <input type="checkbox" name="medical_history[]" value="Hemorrhoids">
                                        <label>Hemorrhoids</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="medical_history[]" value="Arthritis">
                                        <label>Arthritis</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="medical_history[]" value="Tuberculosis">
                                        <label>Tuberculosis</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="medical_history[]" value="Fatty liver">
                                        <label>Fatty liver</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="medical_history[]" value="Diabetes">
                                        <label>Diabetes</label>
                                    </div>
                                </div>

                                   

                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field  delay-300ms">
                                        <input type="checkbox" name="medical_history[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>OTHERS</label>
                                        <input type="text" name="others_medical_history"  >
                                        
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>Any operation/surgery done previously</label>
                                        <input type="text" name="any_operation" placeholder="Name of the procedure"  >
                                        
                                    </div>
                                </div>

                        
                            </div>

                        </fieldset>
                    </div>
                    
                    <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <button class="prev" type="button"><span>Previous Question</span></button>
                                <div class="bar-inner">
                                    <span class="bar-text">50% complete. keep it up!</span>
                                    <div class="w-50 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step3btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>