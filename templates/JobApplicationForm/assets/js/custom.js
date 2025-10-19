// next prev


// showActiveStep
function showActiveStep()
{
    if ($('.step-1').is(':visible'))
    {
        $(".step-counter-inner div").removeClass("active");
        $(".step-counter-inner div").eq(0).addClass("active");
    }
    else if ($('.step-2').is(':visible'))
    {
        $(".step-counter-inner div").removeClass("active");
        $(".step-counter-inner div").eq(1).addClass("active");
    }
    else if ($('.step-3').is(':visible'))
    {
        $(".step-counter-inner div").removeClass("active");
        $(".step-counter-inner div").eq(2).addClass("active");
    }
    else
    {
    console.log("error");
    }
}


// next prev
var divs = $('.show-section section');
var now = 0; // currently shown div
divs.hide().first().show(); // hide all divs except first

function next()
{
    divs.eq(now).hide();
    now = (now + 1 < divs.length) ? now + 1 : 0;
    divs.eq(now).show(); // show next
    showActiveStep();
}

$(".prev").click(function() {
    divs.eq(now).hide();
    now = (now > 0) ? now - 1 : divs.length - 1;
    divs.eq(now).show(); // show previous
    showActiveStep();
});


$(document).ready(function()
{
    $('.text_input input').focus(function()
     {
        $(this).closest('.focus').toggleClass("focused");
          })
    .blur(function(){
       
        $(this).closest('.focus').toggleClass("focused");
    });
});

// show step button on radio select
$(document).ready(function(){
    $(".job-single input[type=radio]").change(function()
    {
        $(this).closest(".step-1").find('.next-prev').removeClass("hide")
        $(this).closest(".step-1").find('.next-prev').addClass("show")
    })
})

// change name when file is selected
$("#cv").on('change', function(e){
    // alert("file is selected");
    var filename = e.target.files[0].name;
    $(".upload label p").text(filename);
});



// disable on enter
$('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
  
  

  // form validiation
var inputschecked = false;


function formvalidate(stepnumber)
{
  // check if the required fields are empty
  inputvalue = $("#step"+stepnumber+" :input").not("button").map(function()
  {
    if(this.value.length > 0)
    {
      $(this).removeClass('invalid');
      return true;

    }
    else
    {
      
      if($(this).prop('required'))
      {
        $(this).addClass('invalid');
        return false
      }
      else
      {
        return true;
      }
      
    }
  }).get();
  

  // console.log(inputvalue);

  inputschecked = inputvalue.every(Boolean);

  // console.log(inputschecked);
}




// form validiation
$(document).ready(function()
   {
        // check step1
        $("#step1btn").on('click', function()
        {
            formvalidate(1);
            
    
            if(inputschecked == false)
            {
                formvalidate(1);
            }
            else
            {
                next();
            }
        })

        // check step2
        $("#step2btn").on('click', function()
        {
            var email = $("#mail-email").val();

            //email validiation
            var re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email);
            
            formvalidate(2);
            
    
            
            
            if(inputschecked == false)
            {
                formvalidate(2);
            }

            // check if email is valid
            else if(emailFormat == false)
            {
                // console.log("enter valid email address");
                (function (el) {
                    setTimeout(function () {
                        el.children().remove('.reveal');
                    }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Enter Valid email address!</div>')));
                if(emailFormat == true)
                {
                  $("#mail-email").removeClass('invalid');
                }
                else
                {
                  $("#mail-email").addClass('invalid');
                }
            }
            else
            {
                next();
            }
        })

       $("#sub").on('click' , function()
       {
                    // // validiate numbers
            // var numbers = /^[0-9]+$/;
            // check laststep
                formvalidate(3);
                
        
            if(inputschecked == false)
            {
                formvalidate(3);
            }
            else
            {

                // var attachment = {cv: $("#step3 input[type=file]").val()};
                // var dataString = $("#step1, #step2, #step3").serialize() + '&' + $.param(attachment);
                
                var dataString = new FormData(document.getElementById("steps"));


                // console.log(dataString);
                
                // send form to send.php
                $.ajax({
                            type: "POST",
                        url: "form handling/send.php",
                        data: dataString,
                            processData: false,
                            contentType: false,
                            success: function(data,status)
                            {


                                $("#sub").html("Sent!");
                                // window.location = 'thankyou.html';
                            
                            },
                            error: function(data, status)
                            {
                            $("#sub").html("failed!");
                            }
                        });
            }


            
            


        });
   });

