<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



  <!-- step 4 -->
                <section class="steps">

                    <?php include "header.php" ?>

                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 4</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">FAMILY HISTORY</h3>
                             <p class="p-text">
                                Do you have family history of inflammatory bowel disease?
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step4">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="family_history" value="YES">
                                        <label>YES</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="radio" name="family_history" value="NO">
                                        <label>NO</label>
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
                                    <span class="bar-text">55% complete. keep it up!</span>
                                    <div class="w-55 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step4btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>
