<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>






  <!-- step 5 -->
                <section class="steps">

                   <?php include "header.php" ?>

                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 5</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">SMOKER HISTORY</h3>
                             <p class="p-text">
                               Check box with indication of your smoking history
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step5">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="smoker" value="Non-Smoker">
                                        <label>Non-Smoker</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="radio" name="smoker" value="Ex-Smoker">
                                        <label>Ex-Smoker</label>
                                    </div>
                                </div>    
                                

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="radio" name="smoker" value="Current Smoker">
                                        <label>Current Smoker</label>
                                    </div>
                                </div>  


                                  <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>If Ex-Smoker or Current Smoker, please indicate no. of : 
                                     <input type="text" name="years_smoking" placeholder="Years smoking"  >
                                     
                                      <input type="text" name="pack_per_day" placeholder="Pack/s per day "  ></label>
                                       
                                        
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
                                    <span class="bar-text">60% complete. keep it up!</span>
                                    <div class="w-60 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step5btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>
