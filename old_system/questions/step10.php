<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

 
  <!-- step 10 -->
                <section class="steps">

                  <?php include "header.php" ?>
                    <div class="step-inner container">

                        <!-- step number-->
                        <div class="step-num"><span>Number 10</span></div>
                        <article class="step2 quiz-text">
                            <h3 class="main-heading">Medications taken</h3>
                             <p class="p-text">
                               (within 6 mos or most recent)
                            </p>
                        </article>

                        <!-- form-->
                        <fieldset class="form" id="step10">
                            <div class="row">
 
                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-200ms" >
                                        <input type="checkbox" name="medications[]" value="5-ASA">
                                        <label>5-ASA</label>
                                    </div>
                                </div>

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Steroids">
                                        <label>Steroids</label>
                                    </div>
                                </div>     

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input title="(Infliximab / Adalimumab / Ustekinumab / Vedolizumab / Guselkumab / Rizankizumab)" type="checkbox" name="medications[]" value="Biologics">
                                        <label  >Biologics
                                          
                                        
                                        </label>
                                    </div>
                                </div>       

                                  <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Azathioprine">
                                        <label>Azathioprine</label>
                                    </div>
                                </div>        

                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Methotrexate">
                                        <label>Methotrexate</label>
                                    </div>
                                </div>        


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Upadacitinib">
                                        <label>Upadacitinib</label>
                                    </div>
                                </div>       


                                 <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Antibiotics">
                                        <label>Antibiotics</label>
                                    </div>
                                </div>         

                                   <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="Anti-TB">
                                        <label>Anti-TB</label>
                                    </div>
                                </div>     

                                
 

                                  

                                <div class="col-md-6 ps-3 pe-3 tab-100">
                                    <div class="check-field delay-100ms">
                                        <input type="checkbox" name="medications[]" value="NONE">
                                        <label>NONE</label>
                                    </div>
                                </div> 
                        
                            </div>
                            
                             <?php include "step10-file.php" ?>   
                             
                        </fieldset>
                    </div>
                    
                    <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <button class="prev" type="button"><span>Previous Question</span></button>
                                <div class="bar-inner">
                                    <span class="bar-text">90% complete. keep it up!</span>
                                    <div class="w-90 bar-move"></div>
                                </div>
                                <button class="next" type="button" id="step10btn"><span>Next Question</span></button>
                            </div>
                        </div>
                    </footer>
                </section>
