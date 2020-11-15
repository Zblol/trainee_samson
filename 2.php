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


/** функию mySortForKey($a, $b). $a – двумерный массив вида [['a'=>2,'b'=>1],['a'=>1,'b'=>3]], $b – ключ вложенного массива.
 * Результат ее выполнения: двумерном массива $a отсортированный по возрастанию значений для ключа $b.
 * В случае отсутствия ключа $b в одном из вложенных массивов, выбросить ошибку класса Exception с индексом неправильного массива.
 */


function mySortForKey($a, $b)
{

    foreach ($a as $key => $value) {
        if ($value[$b] == null) {
            throw new OutOfBoundsException("$a[$value][$key] - неверный индекс массива");
        }
    }

    $keys = array_column($a, $b);

    array_multisort($keys, SORT_ASC, $a);

    return $a;

}

/*$a = [
    ['a' => 2, 'b' => 3],
    ['a' => 1, 'b' => 2],
    ['a' => 6, 'b' => 1]
];

print_r(mySortForKey($a, 'b'));*/