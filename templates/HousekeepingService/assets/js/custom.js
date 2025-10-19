// next prev
var divs = $('.show-section section');
var now = 0; // currently shown div
divs.hide().first().show(); // hide all divs except first

function next()
{
    divs.eq(now).hide();
    now = (now + 1 < divs.length) ? now + 1 : 0;
    divs.eq(now).show(); // show next
}

$(".prev").click(function() {
    divs.eq(now).hide();
    now = (now > 0) ? now - 1 : divs.length - 1;
    divs.eq(now).show(); // show previous
});


// focus input
$(document).ready(function()
{
    $(".text_input input[type=text]").focus(function()
    {
        $(this).closest(".text_input").addClass('focused');
    })
    .blur(function()
    {
        $(this).closest(".text_input").removeClass('focused');
    })
})

$(document).ready(function()
{
    $(".package-custom-field input").focus(function()
    {
        $(this).closest(".package-custom-field").addClass('focused-text');
    })
    .blur(function()
    {
        $(this).closest(".package-custom-field").removeClass('focused-text');
    })
});

$(document).ready(function()
{
    $(".cc-number input").focus(function()
    {
        $(this).closest(".cc-number").addClass('focused-field');
    })
    .blur(function()
    {
        $(this).closest(".cc-number").removeClass('focused-field');
    })
});

$(document).ready(function()
{
    $(".exp-date input").focus(function()
    {
        $(this).closest(".exp-date").addClass('focused-field');
    })
    .blur(function()
    {
        $(this).closest(".exp-date").removeClass('focused-field');
    })
});


// change name when file is selected
$("#image").on('change', function(e){
    // alert("file is selected");
    var filename = e.target.files[0].name;
    $(".upload-area-inner label p").text(filename);
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
        
        // check last step
       $("#sub").on('click' , function()
       {
            
            // //phone validiation
            // var phoneno = /^\d{11}$/;
            
            formvalidate(4);
            
    
            if(inputschecked == false)
            {
                formvalidate(4);
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









   $("#cc-number").on('input',function()
   {
    var number = $("#cc-number").val();
    // visa
    var visa = new RegExp("^4");
    var discover = new RegExp("^6");
    var jcb = new RegExp("^35");
    var mastercard = new RegExp("^5");
    
    if (number.match(visa) != null)
    {
        console.log("Visa");

        $(".cc-type-list i").removeClass("highlight");
        $(".cc-type-list .fa-cc-visa").addClass("highlight");
        $(".cc-type i").hide();
        $(".fa-cc-visa").show();

    }
        

    // Mastercard 
    if (number.match(mastercard) != null)
        
     {
        console.log("Mastercard");

        $(".cc-type-list i").removeClass("highlight");
        $(".cc-type-list .fa-cc-mastercard").addClass("highlight");
        $(".cc-type i").hide();
        $(".fa-cc-mastercard").show();
    }

    // Discover
    if (number.match(discover) != null)
    {
        console.log("Discover");

        $(".cc-type-list i").removeClass("highlight");
        $(".cc-type-list .fa-cc-discover").addClass("highlight");
        $(".cc-type i").hide();
        $(".fa-cc-discover").show();

    }
        

    // JCB
    if (number.match(jcb) != null)
    {
        console.log("JCB");

        $(".cc-type-list i").removeClass("highlight");
        $(".cc-type-list .fa-cc-jcb").addClass("highlight");
        $(".cc-type i").hide();
        $(".fa-cc-jcb").show();
    }
   });

    