<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>
  


    <!-- step-1 -->
                <section class="steps">
                 
                 <?php include "header.php" ?>

                 
                    <div class="step-inner container">

                        <!-- step number -->
                        <div class="step-num"><span>Number 1</span></div>
                        <article class="quiz-text">
                            <h3 class="main-heading">CHIEF COMPLAINT</h3>
                            <p class="p-text">
                                 Main reason for Consultation
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step1">
                            <div class="row">

                                  <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>Date of First attack:</label>
                                        <input type="date" name="first_attack"  >
                                        
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>If Abdominal pain, please specify frequency of pain per day (ex. 3x a day): </label>
                                        <input type="text" name="frequency_pain"  >
                                        
                                    </div>
                                </div>

                                 <div class="col-md-12 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>If Diarrhea, please specify frequency and amount of stools per day (ex.3x a day ; Small, Moderate, Large): </label>
                                        <input type="text" name="stool_per_day"  >
                                        
                                    </div>
                                </div>


                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="chief_complain[]" value="Abdominal pain">
                                        <label>Abdominal pain</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="chief_complain[]" value="Diarrhea">
                                        <label>Diarrhea</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms">
                                        <input type="checkbox" name="chief_complain[]" value="Blood in the stool">
                                        <label>Blood in the stool</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="chief_complain[]" value="Fistula/Discharge">
                                        <label>Fistula/Discharge</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="chief_complain[]" value="Second opinion">
                                        <label>Second opinion</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="check-field  delay-300ms">
                                        <input type="checkbox" name="chief_complain[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div>

                                 



                            </div>
                        </fieldset>
                    </div>
                    
                    <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <div class="bar-inner">
                                    <span class="bar-text">0% complete. keep it up!</span>
                                    <div class="bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step1btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>
