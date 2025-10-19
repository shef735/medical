// next prev

//show active step
function showActiveStep()
{
    if ($('#step1').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '0%');
        $(".progress-counter .progress-pin").html('0%');
    }
    else if ($('#step2').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '16%');
        $(".progress-counter .progress-pin").html('16%').css('margin-left', '16%');
    }
    else if ($('#step3').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '32%');
        $(".progress-counter .progress-pin").html('32%').css('margin-left', '32%');
    }
    else if ($('#step4').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '48%');
        $(".progress-counter .progress-pin").html('48%').css('margin-left', '48%');
    }
    else if ($('#step5').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '64%');
        $(".progress-counter .progress-pin").html('64%').css('margin-left', '64%');
    }
    else if ($('#step6').is(':visible'))
    {
        $(".progress-counter .counter-inner").css('width', '80%');
        $(".progress-counter .progress-pin").html('80%').css('margin-left', '80%');
        
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

//active

$(document).ready(function()
{
    $(".field-c input").focus(function()
    {
        $(this).parent().addClass("focused");
    })
    .blur(function()
    {
        $(this).parent().removeClass("focused");

    })
})

    // count all fields
    var counter = 2;
    // text type
    var textboxID = 2;
    // select type
    var selectboxID = 1;


// create custom fields
$(document).ready(function()
{
		
    $("#TextField").click(function () 
    {
        var textbox =   "<div class='input-field'>\
                            <label for=\"textfield" + textboxID + "\">\
                            Name\
                            </label>\
                            <input required type='text' name=\"textfield" + textboxID + "\" id=\"textfield" + textboxID + "\" placeholder=\"textfield" + textboxID + "\">\
                        </div>";
                            


    var TextBoxDiv = $(document.createElement('div'))
    .attr({
            id: 'fieldnum' + counter,
            class: 'col-md-6'
        });
                
	TextBoxDiv.after().html(textbox);
            
	TextBoxDiv.appendTo("#customForm");

	counter++;			
	textboxID++;
     });


     $("#selectFeild").click(function () 
     {
         var selectbox =   "<div class='input-field select-field'>\
                                <label for=\"SelectField" + selectboxID + "\">\
                                    SelectField" + selectboxID + "\
                                </label>\
                                <select required name=\"SelectField" + selectboxID + "\" id=\"SelectField" + selectboxID + "\">\
                                    <option value='1'>1</option>\
                                    <option value='2'>2</option>\
                                    <option value='3'>3</option>\
                                </select>\
                                <span></span>\
                            </div>";
                             
 
        var SelectBoxDiv = $(document.createElement('div'))
        .attr({
                id: 'fieldnum' + counter,
                class: 'col-md-6'
            });
                    
        SelectBoxDiv.after().html(selectbox);
                
        SelectBoxDiv.appendTo("#customForm");

        counter++;			
        selectboxID++;
      });




     $("#remove").click(function () 
     {  
	    
        if(counter==1)
        {
            alert("No more textbox to remove");
            return false;
         }
            counter--;
            $("#fieldnum" + counter).remove();

        
     });
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
            //email validiation
            var email = $("#mail-email").val();
            var re = /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
            var emailFormat = re.test(email);
            
            
            
            formvalidate(2);
            
    
            if(inputschecked == false)
            {
                formvalidate(2);
            }

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

        // check step4
        $("#step4btn").on('click', function()
        {
            // get all custom fields value
            for(i = 2; i<=textboxID; i++)
            {
                var textfield = $("#textfield" + i).val();
            }
            for(i = 1; i<=selectboxID; i++)
            {
                var selectfield = $("#SelectField" + i).val();
            }
            
            
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
        
        // check step5
        $("#step5btn").on('click', function()
        {
            formvalidate(5);
            
    
            if(inputschecked == false)
            {
                formvalidate(5);
            }
            else
            {
                next();
            }
        })

        // check last step
       $("#sub").on('click' , function()
       {
                    //number validiation
                    // var numbers = /^[0-9]+$/;
            formvalidate(6);
            
    
            if(inputschecked == false)
            {
                formvalidate(6);
            }      
            
            else
            {
                $("#sub").html("<img src='assets/images/loading.gif'>");

                var customfeild = {textboxID: textboxID, selectboxID: selectboxID};
                var dataString = $("#steps").serialize() + '&' + $.param(customfeild);
                console.log(dataString);
                
                // var dataString = new FormData(document.getElementById("steps"));


                // console.log(dataString);
                
                // send form to send.php
                $.ajax({
                         type: "POST",
                        url: "form handling/send.php",
                        data: dataString,
                        //   processData: false,
                        //  contentType: false,
                         success: function(data,status)
                         {

                            $("#sub").html("Success!");
                            console.log(data);
                            
                            // window.location = "thankyou.html";
                            
                         },
                         error: function(data, status)
                         {
                            $("#sub").html("failed!");
                         }
                      });
            }

        });
   }
   );






























