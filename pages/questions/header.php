<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

  
<?php
  $full_name=strtoupper($_SESSION['last_name'].', '.$_SESSION['first_name'].' '.$_SESSION['middle_name']);
?>

                      <header>
                        <h2>
                           <?php echo  $full_name ?>
                        </h2>
                     
                            <div class="d-flex justify-content-center">
                            <div class="w-50">
                                <a style="border-radius: 30px;" href="saving.php" class="btn btn-success btn-lg btn-block text-white">SAVE INFO AND SKIP QUESTIONS</a>
                            </div>
                            </div>
                    </header>