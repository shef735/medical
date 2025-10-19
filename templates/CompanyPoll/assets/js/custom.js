
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
                //     // var totalprcnt = 0;
                //     // var op1 = 0, op2 = 0, op3 = 0;
                //     // var totalfield = $('fieldset').length;
                //     // console.log(totalfield);

                //     // $('fieldset input').each(function()
                //     //     {
                //     //         if($(this).val() == 'MayBe, in the right context')
                //     //         {
                //     //             $(this).addClass('op1');
                //     //         }
                //     //         else if($(this).val() == 'MayBe, in the left context')
                //     //         {
                //     //             $(this).addClass('op2');
                //     //         }
                //     //         else
                //     //         {
                //     //             $(this).addClass('op3');
                //     //         }
                //     //     })


                //     //     // checkoption 1
                //     //     $('.op1').each(function()
                //     //     {
                //     //         if($(this).is(':checked'))
                //     //         {
                //     //             op1 = op1 + 1;
                //     //         } 
                //     //     })

                //     //     totalprcnt = (op1/totalfield) *100;
                //     //     console.log(totalprcnt);
                //     //     $('.opt1result .resultbefore').css({width: totalprcnt+'%'})
                //     //     value = Math.trunc( totalprcnt );
                //     //     $('.opt1result p').html(value +'%');


                //     //     // check option 2
                //     //     $('.op2').each(function()
                //     //     {
                //     //         if($(this).is(':checked'))
                //     //         {
                //     //             op2 = op2 + 1;
                //     //         } 
                //     //     })

                //     //     totalprcnt = (op2/totalfield) *100;
                //     //     console.log(totalprcnt);
                //     //     $('.opt2result .resultbefore').css({width: totalprcnt+'%'})
                //     //     value = Math.trunc( totalprcnt );
                //     //     $('.opt2result p').html(value +'%');

                //     //     // check option 3
                //     //     $('.op3').each(function()
                //     //     {
                //     //         if($(this).is(':checked'))
                //     //         {
                //     //             op3 = op3 + 1;
                //     //         } 
                //     //     })

                //     //     totalprcnt = (op3/totalfield) *100;
                //     //     console.log(totalprcnt);
                //     //     $('.opt3result .resultbefore').css({width: totalprcnt+'%'})
                //     //     value = Math.trunc( totalprcnt );
                //     //     $('.opt3result p').html(value+ '%');

                // })
                $("#sub").html("Success!");
                            
                $('.thankyoupage').css({display: 'block'})
                
            }
            $('#goback').on('click', function()
            {
                $('.thankyoupage').css({display: 'none'});
                $("#sub").html("Submit!");

            })

        });
   });












