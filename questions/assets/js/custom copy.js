
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

$('.radio-field-2 input').on('change', function()
{
    $(".radio-field-2").removeClass('active');
    $(this).parent().addClass('active');
})

$('.radio-field-3 input').on('change', function()
{
    $(".radio-field-3-inner").removeClass('active');
    $(this).parent().find('.radio-field-3-inner').addClass('active');
})







// quiz validation
var checkedradio = false;

function radiovalidate(stepnumber)
{
    var checkradio = $("#step"+stepnumber+" input").map(function()
    {
    if($(this).is(':checked'))
    {
        return true;
    }
    else
    {
        return false;
    }
    }).get();

    checkedradio = checkradio.some(Boolean);
}
$('.skip').on('click', function()
{
    next();
})


$(document).ready(function()
{
  setTimeout(function()
  {
    $("form input").parent().each(function()
    {
      $(this).addClass('revealfield');
    })
  }, 1000)

  setTimeout(function()
  {
    $("#step2 .radio-field-2").each(function()
    {
      $(this).addClass('revealfield');
    })
  }, 1000)

})




// disable on enter
$('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
  
  



// form validiation
$(document).ready(function()
   {
        // check step1
        $("#step1btn").on('click', function()
        {
            radiovalidate(1);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(1);

            }

            else
            {
                next();
            }
        })

        // check step2
        $("#step2btn").on('click', function()
        {
            radiovalidate(2);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(2);

            }

            else
            {
                next();
            }
        })

                // check step2
        $("#step3btn").on('click', function()
        {
            radiovalidate(3);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(3);

            }

            else
            {
                next();
            }
        })



             // check step4
        $("#step4btn").on('click', function()
        {
            radiovalidate(4);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(4);

            }

            else
            {
                next();
            }
        })


            // check step5
        $("#step5btn").on('click', function()
        {
            radiovalidate(5);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(5);

            }

            else
            {
                next();
            }
        })


           // check step5
        $("#step6btn").on('click', function()
        {
            radiovalidate(6);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(6);

            }

            else
            {
                next();
            }
        })


   // check step5
        $("#step7btn").on('click', function()
        {
            radiovalidate(7);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(7);

            }

            else
            {
                next();
            }
        })


           // check step5
        $("#step8btn").on('click', function()
        {
            radiovalidate(8);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(8);

            }

            else
            {
                next();
            }
        })

   // check step5
        $("#step9btn").on('click', function()
        {
            radiovalidate(9);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(9);

            }

            else
            {
                next();
            }
        })

           // check step5
        $("#step10btn").on('click', function()
        {
            radiovalidate(10);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(10);

            }

            else
            {
                next();
            }
        })


   // check step5
        $("#step11btn").on('click', function()
        {
            radiovalidate(11);

            if(checkedradio == false)
            {
                
            (function (el) {
                setTimeout(function () {
                    el.children().remove('.reveal');
                }, 3000);
                }($('#error').append('<div class="reveal alert alert-danger">Choose an option!</div>')));
                
                radiovalidate(11);

            }

            else
            {
                next();
            }
        })

        // check last step
       $("#sub").on('click' , function()
       {
            
        


            $("#sub").html("<img src='assets/images/loading.gif'>");

                            
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
                        
                        window.location = 'thankyou.php';
                        
                        },
                        error: function(data, status)
                        {
                        $("#sub").html("<span>failed!</span>");
                        }
                    });

        });
   });












