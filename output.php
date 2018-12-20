<?php 

require_once 'expression.php';

function get_input_data() {
    $seed = $_POST['seed'] ?? rand();
    $play = $_POST['play'];
    $num_digits = intval($_POST['num_digits']) ?? 1;
    $num_questions = intval($_POST['num_questions']) ?? 1;
    $num_operands = intval($_POST['num_operands']) ?? 1;
    $duration = $_POST['duration'] ?? 0;

    // Read operations from the POST params and map the array that looks like 
    //    ['Addition', 'Multiplication'] as  ['+', '*']
     
    $operations_map = array(
        'Addition'       => '+',
        'Subtraction'    => '-',
        'Multiplication' => '*',
        'Division'       => '/',
    ); 

    $operations = array_map(function($operation_name) use ($operations_map){
        return $operations_map[$operation_name];
    }, $_POST['operation'] ?? []);  

    // generate expressions using the specified random seed
    srand($seed);
    $expressions = array();
    for ($i = 1; $i <= $num_questions; $i++) {
        $expression = generate_expression($num_operands, $operations, $num_digits);
        $expression_string = implode(" ", $expression);
        $result = eval("return ($expression_string);");
        $expressions[] = compact("expression", "result");
    }

    return compact(
        'play',
        'seed',
        'num_digits',
        'num_questions',
        'num_operands',
        'operations',
        'expressions',
        'duration'
    );
}        

function output_slideshow_header($data) {
    extract($data);
    if (!empty($operations)) {
        $num_operations = count($operations); //count selected operation
        ?>
<div class="row">
        <div class="col-sm-4">
              <select class="choices">
                <option value="1">Your choices are here !</option>
                <option value="2"><div style= 'font-size: 25px; color:  #ffe6e6;'><i>You have selected <?php echo count($operations) ?> operation(s): <?php echo implode(', ', $operations); ?></i></div><br></option>
                <option value="3"><div style= 'font-size: 25px;color:  #ffe6e6;'><i>No. of questions: <?php echo $num_questions ?></i></div></option>
                <option value="4"><div style= 'font-size: 25px;color:  #ffe6e6;'><i>Numbers you want: <?php echo $num_operands ?></i></div></option>
                <option value="5"><div style= 'font-size: 25px;color:  #ffe6e6;'><i>No. of digits: <?php echo $num_digits ?></i></div></option>
             </select>
       </div>
          
        <div class="col-sm-4">
       
        <div class="timer" style= 'font-size: 25px;color:  #ffe6e6;'>
          <?php if($duration == 0) 
                { ?> 
                  Duration:<label id="minutes">00</label>:<label id="seconds">00</label>
                 <!-- <span id="minutes"></span>:<span id="seconds"></span>   -->
                 <?php  
                } 
                  else 
                {
                 echo "Duration:" ?><time id="countdown"><script> 
                  var seconds = <?php echo  $duration * 60; ?>;</script>     
                              <?php echo $duration; 
                } 
             ?>
                 </time>
              </div>
        </div>

       <div class="col-sm-4"><!--exit button-->
           <button type="button" class="exit" 
        onclick="window.location.href='http://localhost/copied/final_generate/slideshow.php'">X</button>
       </div>
</div>
     <?php
    }
}

function output_slide($slide_data, $index=1) {
    $expression = $slide_data['expression'];
    $result = $slide_data['result'];
    ?>

  <!-- <div class="col"> -->
    <div class="slide" id="out">
        <div class="head">Q(<?php echo $index+1.?>).</div><br>
                <div class="expression  flex-row" id="exp">
          <?php
          $iCount = count($expression);
             foreach($expression as $key => $item) { ?>
                <span class="slide-item" id="visible"><center> <?php 

      //logic 1  for operand and operator togather
                if($item == "*")
                    {
                     echo "x".$expression[$key+1];
                    }
                elseif($key == 0  &&  $key < $iCount -1)
                    { 
                      echo $item;     
                    }
                elseif($key % 2 !== 0)
                    {
                      echo $item.$expression[$key+1];
                      //$key++;
                    } 
                else
                    {
                      //
                    } 
        ?></span><!--displaying each item at a time-->
    <?php  }  ?>
         <center><span class="answer" id="place">
                    <span class="answer-placeholder">
                             =****
                    </span>

                    <span class="answer-content"><!--displaying result-->
                      <!-- remove 00 from result if ex result =  100,00 then it becomes 100 -->
                      <?php echo str_replace(',00', '', number_format($result, 2, ',', '')); ?>
                    </span>
                
                </span></center>   
            <!-- </span> -->
        </div><br><br><br><br><br><br><br><br><br><br>
         <center><div class="dotin"><?php
            for ($j=0; $j<count($expression); $j++) {
                ?><a class="dots-cont" onclick="goToItem(<?php echo $j ?>)"></a><?php
            }
        ?></div></center>
      </center>
    
    <a class="show-answer button" onclick="goToItem(<?php echo $j ?>)">SHOW ANSWER</a><br>
     <div class="total"> Total: 
      <input id='realtime' type="text"  name="calculate"  placeholder="Total ..."/>         
    </div>
</div>
    <?php
}

function output_slideshow_controls($data) {
?>
    <!--  go to next element of expression , for inner slider-->
    <a class="goto-next-slide overlay-button overlay-right">Next</a>    
    <a class="goto-prev-slide overlay-button overlay-left">Previous</a>
    
    <div class="slideshow-controls center">
       <div class="flex flex-center"><?php
            for ($i=0; $i<count($data['expressions']); $i++) 
            {
                ?><a class="dot" onclick="goToSlide(<?php echo $i ?>)"></a><?php
            }
        ?></div>
    </div>

<?php
}

function output_slideshow($data) {
?>
    <div class="slideshow flex flex-column flex-center">
        <?php output_slideshow_header($data); ?>
        <div id="slides" class="slideshow-stage flex flex-center flex-column"><?php
            for ($i=0; $i<count($data['expressions']); $i++) 
            {
                output_slide($data['expressions'][$i], $i);
            }
            ?>
        </div>

        <?php output_slideshow_controls($data); ?>
    </div><?php
}

function output_form($data) {
    extract($data);
?>  
   <div class="flex flex-center flex-column">
        <h2><i>GENERATE HERE !</i></h2>
        <form action="" method="POST" id="generator">
        <input name="seed" value="<?php echo $seed ?>" type="hidden" />
            <div class="row">
                <div class="col-25">
                    <label for="num_questions">Select No. of questions:</label>
                </div>
                <div class="col-75">
                    <input type="number" id="num_questions" name="num_questions" value="1" min="1" max="100">
                </div>
            </div>
            <br><br>

            <div class="row">
                <div class="col-25">
                    <label for="int">How many numbers you want in a sequence? :</label>
                </div>
                <div class="col-75">
                    <select name="num_operands">
                        <option value="2"> 2 </option>
                        <option value="3"> 3 </option>
                        <option value="4"> 4 </option>
                        <option value="5"> 5 </option>
                        <option value="6"> 6 </option>
                        <option value="7"> 7 </option>
                        <option value="8"> 8 </option>
                        <option value="9"> 9 </option>
                        <option value="10"> 10 </option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-25">
                    <label for="dig">Select no. of digits:</label>
                </div>
                <div class="col-75">
                    <select name="num_digits">
                        <option value="1"> 1 Digit </option>
                        <option value="2"> 2 Digits </option>
                        <option value="3"> 3 Digits </option>
                        <option value="4"> 4  - Mix Digits </option>
                       
                    </select>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-25">
                    <label>Select operations:</label>
                </div>
                <div class="col-75">
                    <label>
                        <input type="checkbox" value="all" onChange="toggleCheckboxes.call(this, 'operation[]')">
                             All
                   </label><br>
                    <label>
                        <input type="checkbox" name="operation[]" value="Addition" checked>
                         Addition
                    </label><span class="checkmark"></span><br>
                    <label>
                        <input type="checkbox" name="operation[]" value="Subtraction">
                           Subtraction
                    </label><span class="checkmark"></span><br>
                    <label>
                        <input type="checkbox" name="operation[]" value="Multiplication">
                          Multiplication
                    </label><span class="checkmark"></span><br>
                    <label>
                        <input type="checkbox" name="operation[]" value="Division">
                           Division
                   </label> <span class="checkmark"></span><br>
                </div>
            </div>
             <br>

             <div class="row">
                <div class="col-25">
                    <label>Duration:</label>
                </div>
                <div class="col-75">
                    <input type="number" id="duration" name="duration" value="0" min="0">
                     <!-- <input type="checkbox" name="notime" value="no" id="countup"> No Duration -->
                </div>
            </div>
            <br>
             <input type="button" name="submit" value="GENERATE" id="gen">
             <input type="submit" name="play" value="PLAY" id="play" />
             <!-- <input type="image"  src="images/play_img.png" name="img"> -->
             <input name="reset" id="re" type="reset" value="RESET" onclick="return resetForm();" />  
            
        </form><br><br>
            </div>
    <?php 
//onclicking generate button show reset button also 
    if(!isset($_POST['submit'])){
        ?>
         <script>
            $(document).ready(function(){
               $("#re").hide();
             });
         </script>
         <?php
    }
}

function output() {
    $data = get_input_data();
    if (!isset($data['play'])) {
        output_form($data);
    } else {
        output_slideshow($data);
    }
}
?>

