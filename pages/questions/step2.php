<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>  

  <!-- step 2 -->
                <section class="steps">
                  
                   <?php include "header.php" ?>
                    <div class="step-inner container">

                        <!-- step number -->
                        <div class="step-num"><span>Number 2</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">OTHER SYMPTOMS</h3>
                             <p class="p-text">
                                 Tick all boxes of symptoms you have/feel now
                            </p>
                        </article>

                        <!--form -->
                        <fieldset class="form" id="step2">
                            <div class="row">
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field">
                                        <input type="checkbox" name="other_symptoms[]" value="Fever">
                                        <label>Fever</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Vomiting">
                                        <label>Vomiting</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-200ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Weight Loss">
                                        <label>Weight Loss</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-300ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Decreased appetite">
                                        <label>Decreased appetite</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-400ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Fatigue/tiredness">
                                        <label>Fatigue/tiredness</label>
                                    </div>
                                </div>
                                <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Anemia">
                                        <label>Anemia</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Constipation">
                                        <label>Constipation </label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Urgency (sudden need to rush to the bathroom to poop)">
                                        <label>Urgency (sudden need to rush </br> to the  bathroom to poop)</label>
                                    </div>
                                </div>


                                  <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Soiling (passing of stool into underwear/clothing)">
                                        <label>Soiling (passing of stool into </br> underwear/clothing)</label>
                                    </div>
                                </div>

                                 <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Skin rashes">
                                        <label>Skin rashes</label>
                                    </div>
                                </div>


                                   <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Stunting/lmpaired growth">
                                        <label>Stunting/lmpaired growth</label>
                                    </div>
                                </div>


                                 <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="Stomatitis (singaw)">
                                        <label>Stomatitis (singaw)</label>
                                    </div>
                                </div>

                                  <div class="col-md-6 ps-3 pe-3">
                                    <div class="check-field delay-500ms">
                                        <input type="checkbox" name="other_symptoms[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>OTHERS</label>
                                        <input type="text" name="other_symptoms_others"  >
                                        
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
                                    <span class="bar-text">25% complete. keep it up!</span>
                                    <div class="w-25 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step2btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>