<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


                <!-- step 6 -->
                <section class="steps">

                    <?php include "header.php" ?>
                    <div class="step-inner container">

                        <!-- step number -->
                        <div class="step-num"><span>Number 6</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">PAIN ASSESSMENT SCALE</h3>
                        </article>

                        <!-- form -->
                        <fieldset class="form" id="step6">
                            <div class="row">

                                <div class="col-md-12 ps-3 tab-100">
                                    <div class="input-field">

                                      
                                          
                                    <label>Please rate your pain on a scale from 0 to 10, with 10 being the worst possible pain and 0 being no pain : 
                                     
                                  </label>

                                  <div class="radio-group">
    <label class="radio-button">
        <input type="radio" checked name="pain_rate" value="0">
        <img src="../questions/assets/images/rate/0.png" >
    </label>

    <label class="radio-button">
        <input type="radio" name="pain_rate" value="1">
        <img src="../questions/assets/images/rate/1.png" ">
    </label>

     <label class="radio-button">
        <input type="radio" name="pain_rate" value="2">
        <img src="../questions/assets/images/rate/2.png" ">
    </label>

     <label class="radio-button">
        <input type="radio" name="pain_rate" value="3">
        <img src="../questions/assets/images/rate/3.png" ">
    </label>

   

    <label class="radio-button">
        <input type="radio" name="pain_rate" value="4">
        <img src="../questions/assets/images/rate/4.png" ">
    </label>

     <label class="radio-button">
        <input type="radio" name="pain_rate" value="5">
        <img src="../questions/assets/images/rate/5.png" ">
    </label>
    
     <label class="radio-button">
        <input type="radio" name="pain_rate" value="6">
        <img src="../questions/assets/images/rate/6.png" ">
    </label>

    <label class="radio-button">
        <input type="radio" name="pain_rate" value="7">
        <img src="../questions/assets/images/rate/7.png" ">
    </label>

    <label class="radio-button">
        <input type="radio" name="pain_rate" value="8">
        <img src="../questions/assets/images/rate/8.png" ">
    </label>

     <label class="radio-button">
        <input type="radio" name="pain_rate" value="9">
        <img src="../questions/assets/images/rate/9.png" >
    </label>

     <label class="radio-button">
        <input type="radio" name="pain_rate" value="10">
        <img src="../questions/assets/images/rate/10.png" >
    </label>


</div>
                                       
                                        
                                    </div>
                                </div> 

                                  <article class="step2 quiz-text">
                            <h3 class="main-heading">GENERAL WELL BEING</h3>
                        </article>         

                             <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="general_well" value="Excellent">
                                        <label>Excellent</label>
                                    </div>
                                </div>

                                    <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="general_well" value="Very Good">
                                        <label>Very Good</label>
                                    </div>
                                </div>

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="general_well" value="Good">
                                        <label>Good</label>
                                    </div>
                                </div>

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="radio" name="general_well" value="Not Okay">
                                        <label>Not Okay</label>
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
                                    <span class="bar-text">70% complete. keep it up!</span>
                                    <div class="w-70 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step6btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>

                
                </section>