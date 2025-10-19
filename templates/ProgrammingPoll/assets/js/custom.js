// Set the date we're counting down to
var countDownDate = new Date("Jan 30, 2023").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("countdown").innerHTML = days + " Days Left" ;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "EXPIRED";
  }
}, 1000);







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







$(document).ready(function()
{
  setTimeout(function()
  {
    $("fieldset .radiofield").each(function()
    {
      $(this).addClass('revealfield');
    })
  }, 1000)

})




// next prev
var divs = $('.show-section fieldset');
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

        // check last step
       $("#sub").on('click' , function()
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

                // $(document).ready(function()
                // {
                //     var totalprcnt = 0;
                //     var op1 = 0, op2 = 0, op3 = 0, op4 = 0;
                //     var totalfield = $('fieldset').length;
                //     console.log(totalfield);

                //     $('fieldset input').each(function()
                //         {
                //             if($(this).val() == 'Python')
                //             {
                //                 $(this).addClass('op1');
                //             }
                //             else if($(this).val() == 'Javascript')
                //             {
                //                 $(this).addClass('op2');
                //             }
                //             else if($(this).val() == 'Go')
                //             {
                //                 $(this).addClass('op3');
                //             }
                //             else
                //             {
                //                 $(this).addClass('op4');
                //             }
                //         })


                //         // checkoption 1
                //         $('.op1').each(function()
                //         {
                //             if($(this).is(':checked'))
                //             {
                //                 op1 = op1 + 1;
                //             } 
                //         })

                //         totalprcnt = (op1/totalfield) *100;
                //         console.log(totalprcnt);
                //         $('.opt1 .prnct-bar').css({width: totalprcnt+'%'})
                //         value = Math.trunc( totalprcnt );
                //         $('.opt1 .prnct').html(value +'%');


                //         // check option 2
                //         $('.op2').each(function()
                //         {
                //             if($(this).is(':checked'))
                //             {
                //                 op2 = op2 + 1;
                //             } 
                //         })

                //         totalprcnt = (op2/totalfield) *100;
                //         console.log(totalprcnt);
                //         $('.opt2 .prnct-bar').css({width: totalprcnt+'%'})
                //         value = Math.trunc( totalprcnt );
                //         $('.opt2 .prnct').html(value +'%');

                //         // check option 3
                //         $('.op3').each(function()
                //         {
                //             if($(this).is(':checked'))
                //             {
                //                 op3 = op3 + 1;
                //             } 
                //         })

                //         totalprcnt = (op3/totalfield) *100;
                //         console.log(totalprcnt);
                //         $('.opt3 .prnct-bar').css({width: totalprcnt+'%'})
                //         value = Math.trunc( totalprcnt );
                //         $('.opt3 .prnct').html(value+ '%');

                //         // check option 4
                //         $('.op4').each(function()
                //         {
                //             if($(this).is(':checked'))
                //             {
                //                 op4 = op4 + 1;
                //             } 
                //         })

                //         totalprcnt = (op4/totalfield) *100;
                //         console.log(totalprcnt);
                //         $('.opt4 .prnct-bar').css({width: totalprcnt+'%'})
                //         value = Math.trunc( totalprcnt );
                //         $('.opt4 .prnct').html(value+ '%');

                // })

                

                            
                            $('.thankyoupage').css({display: 'block'})

                            $('#goback').on('click', function()
                            {
                                $('.thankyoupage').css({display: 'none'});
                
                            })
                            
                         
            }

        });
   });












