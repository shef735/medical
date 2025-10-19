// var countDownDate = new Date("feb 28, 2023").getTime();

// var x = setInterval(function() 
// {

//   var now = new Date().getTime();
//   var distance = countDownDate - now;
//   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
//   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//   var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
//   document.getElementById("countdown").innerHTML = "<div class='timer'><div class='timer-inner'><div class='timer-text'>" + days + "</div></div><span>DAYS</span></div>" + "<div class='timer'><div class='timer-inner'><div class='timer-text'>" + hours + "</div></div><span>HOURS</span></div>"
//   + "<div class='timer'><div class='timer-inner'><div class='timer-text'>" + minutes + "</div></div><span>DAYS</span></div>" + "<div class='timer'><div class='timer-inner'><div class='timer-text'>" +  seconds + "</div></div><span>SECONDS</span></div>";
//   if (distance < 0) {
//     clearInterval(x);
//     document.getElementById("countdown").innerHTML = "EXPIRED";
//   }
// }, 1000);