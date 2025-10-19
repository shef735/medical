// next prev

//show active step
function showActiveStep()
{
    if ($('#step1').is(':visible'))
    {
        $(".step-type-inner .step-type-single").removeClass("active");
        $(".step-type-inner .step-type-single").eq(0).addClass("active");
        $(".step-bar-inner .step-bar-move").css('width', '0%');
        $(".step-bar-inner .step-bar-move").html('0%');
    }
    else if ($('#step2').is(':visible'))
    {
        $(".step-type-inner .step-type-single").removeClass("active");
        $(".step-type-inner .step-type-single").eq(1).addClass("active");
        $(".step-bar-inner .step-bar-move").css('width', '20%');
        $(".step-bar-inner .step-bar-move").html('20%');
    }
    else if ($('#step3').is(':visible'))
    {
        $(".step-type-inner .step-type-single").removeClass("active");
        $(".step-type-inner .step-type-single").eq(2).addClass("active");
        $(".step-bar-inner .step-bar-move").css('width', '40%');
        $(".step-bar-inner .step-bar-move").html('40%');
    }
    else if ($('#step4').is(':visible'))
    {
        $(".step-type-inner .step-type-single").removeClass("active");
        $(".step-type-inner .step-type-single").eq(2).addClass("active");
        $(".step-bar-inner .step-bar-move").css('width', '60%');
        $(".step-bar-inner .step-bar-move").html('60%');
    }
    else if ($('#step5').is(':visible'))
    {
        $(".step-type-inner .step-type-single").removeClass("active");
        $(".step-type-inner .step-type-single").eq(3).addClass("active");
        $(".step-bar-inner .step-bar-move").css('width', '80%');
        $(".step-bar-inner .step-bar-move").html('80%');
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
    $(".radio-field input").on('change', function()
    {
        $(".radio-field").removeClass("checked");
        $(this).parent().addClass("checked");
    })
})


// preview image within div
image.onchange = evt => {
    const [file] = this.image.files
    if (file) {
        this.proifle.src = URL.createObjectURL(file)
    }
  }




// change name when file is selected
$("#file").on('change', function(e){
    // alert("file is selected");
    var filename = e.target.files[0].name;
    $(".file .file-inner span").text(filename);
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
        $('.skip').on('click', function()
        {
            next();
        })

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
            formvalidate(2);
            
    
            if(inputschecked == false)
            {
                formvalidate(2);
            }
            else
            {
                next();
            }
        })

        // check step3
        $("#step3btn").on('click', function()
        {
            formvalidate(3);
            
    
            if(inputschecked == false)
            {
                formvalidate(3);
            }
            else
            {
                next();
            }
        })
        // check step4
        $("#step4btn").on('click', function()
        {
            formvalidate(4);
            
    
            if(inputschecked == false)
            {
                formvalidate(4);
            }
            else
            {
                next();
            }
        })

        // check last step
       $("#sub").on('click' , function()
       {
            
        
            // get input value
            var email = $("#mail-email").val();
            
            //email validiation
            var re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email);


            
            //number validiation
            var numbers = /^[0-9]+$/;
            
            formvalidate(5);
            
    
            if(inputschecked == false)
            {
                formvalidate(5);
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
            }
            
            else
            {
                $("#sub").html("<img src='assets/images/loading.gif'>");
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

                            $("#sub").html("Success!");
                            
                            window.location = "thankyou.html";
                            
                         },
                         error: function(data, status)
                         {
                            $("#sub").html("failed!");
                         }
                      });
            }

        });
   });

