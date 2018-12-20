//script for generate one by one questions
var timer;
// var qTime;
// go to next question
function gotoNextSlide()
 { 
   timer && clearTimeout(timer); 
    goToSlide(getCurrentSlide().index() + 1);
    // qTime =  "<?php echo $duration * 60000 / $num_questions; ?>";
   timer = setTimeout(gotoNextSlide, 1000 * 60);
   // timer = setTimeout(gotoNextSlide, '<?php echo $duration / $num_questions; ?>');
   // timer = setTimeout(gotoNextSlide, qTime);
}

//go to previous question
function gotoPrevSlide() 
{ 
  goToSlide(getCurrentSlide().index() - 1);
}

//jquery for changing the questions using keyboard left and right key press
$(document).keydown(function(e) {
    switch(e.which) 
     {
       case 39: // right
       gotoNextSlide();
    break;
       case 37: // left
       gotoPrevSlide();
    break;

        default: return; // exit this handler for other keys
    }
     e.preventDefault(); //to prevent the  action like scroll 
});

//show current question
function getCurrentSlide() 
{
  return $("#slides .slide:visible");
}            

//show  next item or element of the current  question
function gotoNextItem() 
{
  goToItem(getCurrentItem().index() + 1);
}

//show the previus item of the current  question
function gotoPrevItem() 
{
  goToSlide(getCurrentItem().index() - 1);
}

//geting current item of the current question
function getCurrentItem() 
{
  return $("#out .dot:visible");
}

//creating dots or bullets  equal to no.of questiions
function goToSlide(index) 
{
     var $slides = $("#slides .slide");
    if (index >= 0 && index < $slides.length) 
    {
      $slides
        .removeClass("active")
        .eq(index)
        .addClass("active");
      $(".dot")
       .removeClass("active")
       .eq(index)
       .addClass("active");
    }
}

// creating dots or buullet equal to  items in an expression
function goToItem(element) 
{
     var $ele = $(".dotin");
    if (element >= 0 && element < $ele.length)
    {
      $ele
        .removeClass("active")
        .eq(element)
        .addClass("active");
      $(".dots-cont")
        .removeClass("active")
        .eq(element)
        .addClass("active");
    }
}

//marking all checkboxes on clciking checkbox named All
function toggleCheckboxes(name) 
{
  var checked = $(this).prop("checked");
  $('[name="' + name + '"]').prop("checked", checked);
}

//showing next item afer 3 second
function showNextItem() 
{
   $nextItem && clearTimeout($nextItem);
      // $nextItem = setTimeout(showNextItem, timer / "<?php echo $num_operands; ?>");
      $nextItem = setTimeout(showNextItem, 3000);
       var $nextItem = getCurrentSlide().find('.slide-item:not(.visible)').eq(0);  
       if ($nextItem.length) 
       {
          $nextItem.addClass('visible');
           return;
       }  
     // show the answer
      getCurrentSlide().find('.answer').toggleClass('visible');
} 
             /*
            // logic for real time calcultion 
            $('document').ready(function(){ // run anytime the value changes
              var fvalue = $('.expression'),
                elements = getCurrentSlide().find('.slide-item:not(.visible)').eq(0),
                 totalvl = $('.totl');

                  //function to calculate total
                   var calculateTotal = function () {
                    var total = 0;

                     $.each(elements, function () {
                       var field = $(this),
                         newVal;

                          newVal = parseFloat(newVal);
                           total += newVal;
                           })
                            totalvl.text(total);
                            }

                            // bind events
                           elements.on('change keyup', calculateTotal);

                           document.getElementById('total').inner HTML
               */
    
//function for reset the form 
function resetForm()
 {
    return confirm("Are you sure you want to reset your choices?");
 }

function init() 
{
  $(".show-answer").click(showNextItem);
  //timer for next element
   // $nextItem = setTimeout(showNextItem, timer / "<?php echo $num_operands; ?>");
   $nextItem = setTimeout(showNextItem, 3000);
  $(".goto-next-slide").click(gotoNextSlide);
  //timer for next question slide
  timer = setTimeout(gotoNextSlide, 1000 * 60);
   // timer = setTimeout(gotoNextSlide, '<?php echo $duration / $num_questions; ?>');
  // timer = setTimeout(gotoNextSlide, qTime);
  $(".goto-prev-slide").click(gotoPrevSlide);

  goToSlide(0);
}

$(document).ready(init);

                   //script for generate and play button
                        $(document).ready(function(){
                          $("input[name=submit]").click(function(){
                            $("#play").show();
                              $("#img").show();
                               $("#re").show();
                                $("#gen").hide();
                                 });
                              });
              
             //disable all inputs when click on generate
               $("input[name=submit]").click(function(){
                            $("input[type=number],input[type=checkbox],select[name=num_operands],select[name=num_digits]").prop("disabled", true);  
                           });

               //enable all input when click on play 
                $("input[name=play]").click(function(){
                            $("input[type=number],input[type=checkbox],select[name=num_operands],select[name=num_digits]").prop("disabled", false);  
                           });
               
               //enable inputs after clicking on reset button
                $("input[name=reset]").click(function(){
                         $("input[type=number],input[type=checkbox],select[name=num_operands],select[name=num_digits]").prop("disabled", false);                     
                          });

                 //for reset button 
                         $(document).ready(function(){
                          $("#re").click(function(){
                           $("#gen").show();     
                               $("#play").hide();
                                 $("#re").hide();
                          });
                       });

               //checked all checkboxes on clicking  checkbox named All
                 $( '.col-75 .toggle-button' ).click( function () {
                     $( '.col-75 input[type="checkbox"]' ).prop('checked', this.checked)
                       });
                  
               // script for showing answer on clicking show answer button
                     $(".answer-content").hide();
                        $(".show-answer").click(function(){
                          $('.total').hide();   
                            $(".answer-content").show();
                              $(".answer-placeholder").hide();
                              });              

              //hide answer after going on next question and clicking next button
                     $(".goto-next-slide").click(function(){
                       $(".answer-content").hide();
                     });

              //script for timer countdown
                   function secondPassed() 
                      {
                           var minutes = Math.round((seconds - 30)/60),
                            remainingSeconds = seconds % 60;
                             if (remainingSeconds < 10) 
                              {
                               remainingSeconds = "0" + remainingSeconds;
                              }
                          document.getElementById("countdown").innerHTML = minutes + ":" + remainingSeconds;
                             if (seconds == 0) 
                               {
                                  clearInterval(countdownTimer); 
                                  window.location.href = 'http://localhost/copied/final_generate/slideshow.php';
                               } 
                           else
                              {
                               seconds--;
                              }
                      }
                         var countdownTimer = setInterval('secondPassed()', 1000);
               
               //adding count up timer after user select 0 as input value to duration field
                var minutesLabel = document.getElementById("minutes");
                var secondsLabel = document.getElementById("seconds");
                var totalSeconds = 0;
                setInterval(setTime, 1000);

               function setTime() {
                        ++totalSeconds;
                         secondsLabel.innerHTML = pad(totalSeconds % 60);
                         minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
                }

               function pad(val) {
                      var valString = val + "";
                       if (valString.length < 2) {
                          return "0" + valString;
                        } else {
                      return valString;
                        }
                }

           
           

                    /*var sec = 0;
                  function pad ( val ) { return val > 9 ? val : "0" + val; }
                 setInterval( function(){
                 document.getElementById("seconds").innerHTML=pad(++sec%60);
                 document.getElementById("minutes").innerHTML=pad(parseInt(sec/60,10));
                 }, 1000);*/