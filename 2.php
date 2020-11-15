<?php


/** функцию convertString($a, $b).
 * Результат ее выполнение: если в строке $a содержится 2 и более подстроки $b,
 * то во втором месте заменить подстроку $b на инвертированную подстроку. */


function convertString($a, $b)
{

    $check = mb_substr_count($a, $b);
    if ($check >= 2) {


        $pos1 = stripos($a, $b, 2);

        $b2 = strrev($b);
        $b2Length = mb_strlen($b2);


        $pos3 = substr_replace($a, $b2, $pos1, $b2Length);

        return $pos3;

    } else {

        return $a;

    }
}

//$a = 'abcd abcd abcd abcd  ';
//$b = 'abc';

//print_r(convertString($a, $b));


