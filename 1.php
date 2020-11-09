<?php


//Реализовать функцию findSimple ($a, $b). $a и $b – целые положительные числа. Результат ее выполнение: массив простых чисел от $a до $b.


function findSimple( $a, $b)
{



    for ($i = range($a, $b); ($arraySimple[] = array_shift($i)) && count($i) > 0;)
        foreach ($i as $key => $value)
            if ($value % end($arraySimple) == 0) {

                unset($key); }

            return $arraySimple;
}

print_r (findSimple(2,20));

//Реализовать функцию createTrapeze($a). $a – массив положительных чисел, количество элементов кратно 3. Результат ее выполнение: двумерный массив (массив состоящий из ассоциативных массива с ключами a, b, c). Пример для входных массива [1, 2, 3, 4, 5, 6] результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]].


function createTrapeze($a) {

	if (count($a) % 3 !== 0) {
		throw new lengthException("Введите массив кратный трём"); // проверка массива на соответствие условию
	} 

	$chunkArr = array_chunk($a, 3, false); // разделение массива на многомерный массив, по три элемента в каждом

	$newArr = array();			
	$count = 0; //нулевой индекс

	foreach ($chunkArr as $row) {   //замена ключа-индекса   в массиве на буквенное значение
		
		$newArr[$count]['a'] = $row[0];
		$newArr[$count]['b'] = $row[1];
		$newArr[$count]['c'] = $row[2];
		$count++;
	}
	return $newArr;
}
$a = [1,2,3,4,5,6,23,40,34];
createTrapeze($a);


//Реализовать функцию squareTrapeze($a). $a – массив результата выполнения функции createTrapeze(). Результат ее выполнение: в исходный массив для каждой тройки чисел добавляется дополнительный ключ s, содержащий результат расчета площади трапеции со сторонами a и b, и высотой c

function squareTrapeze($a) {
    for ($x = 0; $x < count($a); $x++) {
    	$sub_array = $a[$x];
        $a[$x]['s'] = (($sub_array['a'] + $sub_array['b'])/2) * $sub_array['c']; // вычисление и добавление в массив площади трапеции
    }
    
    return $a;
}

$result  = createTrapeze($a);
squareTrapeze($result);
print_r(squareTrapeze($result));



//Реализовать функцию getSizeForLimit($a, $b). $a – массив результата выполнения функции squareTrapeze(), $b – максимальная площадь. Результат ее выполнение: массив размеров трапеции с максимальной площадью, но меньше или равной $b.

function getSizeForLimit($a,$b) {

    $new_array = array();
    // создаем новый массив и заполняем его массивами площадь трапеций который удовлетворяет условию <= b
    for ($i = 0; $i < count($a); $i++) {
 		$sub_array = $a[$i];
 			if ($sub_array['s'] <= $b) { 
 				array_push($new_array, $sub_array);
 			}
    }
    // если нет ни одного массива удовлетворяющего условий задачи, то возвращаем выполнение функции
    if (count($new_array) == 0) {
        return;
    }

    $max_array = $new_array[0];
    // определяем массив с максимальной площадью трапеции
    foreach($new_array as $element) {
        if ($element['s'] > $max_array['s']) {
            $max_array = $element;
    }
 }
 
 return $max_array;
 
}
$b = 10;

$squerResult = squareTrapeze($result);
getSizeForLimit($squerResult,$b);
print_r(getSizeForLimit($squerResult,$b));

//Реализовать функцию getMin($a). $a – массив чисел. Результат ее выполнения: минимальное числа в массиве (не используя функцию min, ключи массив может быть ассоциативный).

function getMin($a) {

	
	$min = PHP_INT_MAX; // максимально возможное значение

	foreach ($a as $value) {
		
		if($value < $min ){ // определение минимального значения в массиве

			$min = $value;
		}
        
	}
	return $min;
}
getMin($a);

//Реализовать функцию printTrapeze($a). $a – массив результата выполнения функции squareTrapeze(). Результат ее выполнение: вывод таблицы с размерами трапеций, строки с нечетной площадью трапеции отметить любым способом.


function printTrapeze($a) {


echo '<table cellpadding="5" cellspacing="0" border="1">'; //отрисовка таблицы
echo '<tr> <td>Длина</td> <td>Ширина</td> <td>Высота</td> <td>Площадь</td>'; //шапка таблицы
foreach ($a as $key => $value) {
	
	echo "<tr>";
	foreach ($value as $key => $data)
       		if($data % 2 !==0 && $key == 's'){// определение нечетных площадей трапеции в таблице
			echo "<td style='color:red;'>$data</td>" ;

		}else {

		echo "<td>".$data."</td>";
	}
	echo "</tr>";
}

echo "</table>";
}

printTrapeze(squareTrapeze($result));


//Реализовать абстрактный класс BaseMath содержащий 3 метода: exp1($a, $b, $c) и exp2($a, $b, $c),getValue(). Метода exp1 реализует расчет по формуле a*(b^c). Метода exp2 реализует расчет по формуле (a/b)^c. Метод getValue() возвращает результат расчета класса наследника.

abstract class BaseMath {

	public function exp1($a,$b,$c){

		$formula = $a*($b^$c);

		return $formula;

	}

	public function exp2($a,$b,$c){

		$formula2 = ($a/$c)^$b;

		return $formula2;

	}

	abstract public function getValue();	

}


//Реализовать класс F1 наследующий методы BaseMath, содержащий конструктор с параметрами ($a, $b, $c) и метод getValue(). Класс реализует расчет по формуле f=(a*(b^c)+(((a/c)^b)%3)^min(a,b,c)).


class F1 extends BaseMath { 


	public function __construct($a,$b,$c ) {

   		$this->a = $a;

  	 	$this->b = $b;

   		$this->c =  $c;
 	}


 	public function getValue() {

            $exp1 =$this->exp1($this->a,$this->b,$this->c);
            $exp2 =$this->exp2($this->a,$this->b,$this->c);
            $f = $exp1+(($exp2)%3)^min($this->a,$this->b,$this->c);

   			return $f;
  }

}

$a = 100;
$b = 24;
$c = 40;

$count =  new F1($a,$b,$c);

var_dump($count-> getValue());




















