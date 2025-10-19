<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>




        <!-- step 7 -->
                <section class="steps">

                     <?php include "header.php" ?>

                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 7</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">BEHAVIORAL HEALTH</h3>
                             <p class="p-text">
                              For the past 6 months, please check all boxes to indicate how you feel:
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step7">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="behavioral_health[]" value="No/Low energy">
                                        <label>No/Low energy</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Unable to concentrate">
                                        <label>Unable to concentrate</label>
                                    </div>
                                </div>       

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Anxiety">
                                        <label>Anxiety</label>
                                    </div>
                                </div>   

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Irritable">
                                        <label>Irritable</label>
                                    </div>
                                </div>        

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Unable to stop worrying">
                                        <label>Unable to stop worrying</label>
                                    </div>
                                </div>    

                                    <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Insomnia">
                                        <label>Insomnia</label>
                                    </div>
                                </div>       

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Restlessness">
                                        <label>Restlessness</label>
                                    </div>
                                </div>      

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Helplessness">
                                        <label>Helplessness</label>
                                    </div>
                                </div>       

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Hopelessness">
                                        <label>Hopelessness</label>
                                    </div>
                                </div>        


                                    <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Unable to relax">
                                        <label>Unable to relax </label>
                                    </div>
                                </div>     

                                       <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Stressed">
                                        <label>Stressed</label>
                                    </div>
                                </div>     

                                    <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Feeling of impending doom">
                                        <label>Feeling of impending doom</label>
                                    </div>
                                </div>   


                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Sadness ">
                                        <label>Sadness </label>
                                    </div>
                                </div>  


                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Attacks of Fear">
                                        <label>Attacks of Fear</label>
                                    </div>
                                </div>  

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Feeling of being alone">
                                        <label>Feeling of being alone</label>
                                    </div>
                                </div>  


                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Depression">
                                        <label>Depression</label>
                                    </div>
                                </div>  

                                       <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="behavioral_health[]" value="Thoughts of hurting self">
                                        <label>Thoughts of hurting self</label>
                                    </div>
                                </div>  


                        


                                  <div class="col-md-6 ps-3 tab-100">
                                    <div class="input-field">
                                    <label>Others (Specify):  
                                     <input type="text" name="behavioral_health_others"   >
                                     
                                    </label>
                                       
                                        
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
                                    <span class="bar-text">75% complete. keep it up!</span>
                                    <div class="w-75 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step7btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>
