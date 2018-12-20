<?php

function get_random_item($array) 
{
    $array_length = count($array);
    if ($array_length) 
    {
        return $array[rand(0, $array_length - 1)];
    }
    return null;
}

function generate_random_digit() 
{
    return rand(1, 9);
}

function generate_random_operand($num_digits) 
{ 
   if($num_digits == 4)
   {
    return rand(1, 999);  
   }
    $operand = "";
    while ($num_digits > 0) 
    {
        $operand = $operand . generate_random_digit();
        if ($operand == "0") {
            $operand = "";
            continue;
        }
        $num_digits--;
    }
    return $operand;
}

function generate_expression($num_operands, $operators, $max_digits = 1) 
{
    $expression = array();
    while ($num_operands--) 
    {
        $operation = false;
        if (count($expression)) 
        {
            $operation = get_random_item($operators);
            $expression[] = $operation;
        }
        $operand = generate_random_operand($max_digits);

        if ($operation == "/" && $operand == "0") 
        {
            $operand = generate_random_operand($max_digits) + 1;
        }
        $expression[] = $operand;
    }
    return $expression;
}
?>
