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


/**Реализовать функцию importXml($a). $a – путь к xml файлу (структура файла приведена ниже).
 * Результат ее выполнения: прочитать файл $a и импортировать его в созданную БД.
 */


function importXml($a)
{
    require_once("dataB_conn.php");
    $xmlDoc = file_get_contents($a);
    $data = new SimpleXmlElement($xmlDoc);

    try {

        for ($i = 0, $z = 0, $parentId = 0; $i < $data->{'Товар'}->count(); $i++) {

            $productName = $data->{'Товар'}[$i]->attributes()->{'Название'};
            $kod = $data->{'Товар'}[$i]->attributes()->{'Код'};
            $price = $data->{'Товар'}[$i]->{'Цена'};
            $property = $data->{'Товар'}[$i]->{'Свойства'};


            $findData = $pdo->query("SELECT * FROM  a_product WHERE название LIKE '$productName'");

            if ($findData->fetch()) {
                $addProduct = $pdo->prepare("INSERT INTO a_product VALUES (NULL,?,?)");
                if ($data->{'Товар'}[$i]->attributes()->{'Код'}) {

                    $addProduct->execute([$kod, $productName]);

                } else {
                    $addProduct->execute([NULL, $productName]);
                }

                $productId = $pdo->lastInsertId();

                $addPrice = $pdo->prepare("INSERT INTO a_price VALUES ($productId,?,?)");
                foreach ($price as $val) {
                    $addPrice->execute([$val['Тип'], $val]);
                }

                $addProperties = $pdo->prepare("INSERT INTO a_property VALUES ($productId,?,?)");
                foreach ($property as $propsName) {

                    foreach ($propsName as $prop => $val) {

                        if ($property) {
                            $addProperties->execute([$prop], [$val]);
                        }

                    }

                }

                $addCategory = $pdo->prepare("INSERT INTO a_category VALUES (NULL,?,?,?)");
                $productInCategory = $pdo->prepare("INSERT INTO a_product_category VALUES (?,?)");
                foreach ($data->{'Товар'}[$i]->{'Разделы'}->{'Раздел'} as $categoryName) {

                    $queryCategory = $pdo->query("SELECT * FROM a_category WHERE название LIKE '$categoryName'");
                    $category = $queryCategory->fetch(PDO::FETCH_ASSOC);
                    if ($category["Название"] == $categoryName) {

                        $parentId = $category["категория_ид"];
                        $productInCategory->execute([$productId, $category["категория_ид"]]);

                    } else {

                        $addCategory->execute([$z, $categoryName, $parentId]);
                        $parentId = $pdo->lastInsertId();
                        $productInCategory->execute([$productId, $pdo->lastInsertId()]);
                        $z++;


                    }

                }

                $parentId = 0;
            }
        }
    } catch (PDOException $e) {

        echo "Ошибка загрузки " . $e->getMessage();
    }


}

//$a = "2.xml";
//importXml($a);

/** Реализовать функцию exportXml($a, $b). $a – путь к xml файлу вида (структура файла приведена ниже), $b – код рубрики.
 * Результат ее выполнения: выбрать из БД товары (и их характеристики, необходимые для формирования файла)
 * выходящие в рубрику $b или в любую из всех вложенных в нее рубрик, сохранить результат в файл $a.
 */


function exportXml($a, $b)
{
    require_once("dataB_conn.php");
    $dom = new domDocument(1, "utf-8");
    $dom->formatOutput = true;
    $root = $dom->createElement('Товары');
    $dom->appendChild($root);


    $qu_category = $pdo->query("SELECT * FROM a_category WHERE код = $b");
    $category = $qu_category->fetch(PDO::FETCH_ASSOC);

    $data_category_q = $pdo->query("SELECT * FROM a_product_category WHERE категория_ид = $category[категория_ид]");

    while ($data_category = $data_category_q->fetch(PDO::FETCH_ASSOC)) {
        $data_q = $pdo->query("SELECT * FROM a_product WHERE товар_ид = $data_category[товар_ид]");
        $data = $data_q->fetch(PDO::FETCH_ASSOC);
        $dataTag = $dom->createElement('Товар');
        $dataTag->setAttribute('Код', $data['код']);
        $dataTag->setAttribute('Название', $data['Название']);


        $price_q = $pdo->query("SELECT * FROM a_price WHERE товар_ид = $data[товар_ид]");
        while ($price = $price_q->fetch(PDO::FETCH_ASSOC)) {
            $priceTag = $dom->createElement('Цена', $price['цена']);
            $priceTag->setAttribute('Тип', $price['тип']);
            $dataTag->appendChild($priceTag);
        }


        $propertiesTag = $dom->createElement('Свойства');
        $property_q = $pdo->query("SELECT * FROM a_property WHERE товар_ид = $data[товар_ид]");
        while ($property = $property_q->fetch(PDO::FETCH_ASSOC)) {
            $propertyTag = $dom->createElement($property['Название'], $property['Свойства']);
            $propertiesTag->appendChild($propertyTag);
            $dataTag->appendChild($propertiesTag);
        }


        $catalogsTag = $dom->createElement('Разделы');
        $catalogTag = $dom->createElement('Раздел', $category['Название']);
        $catalogsTag->appendChild($catalogTag);
        $dataTag->appendChild($catalogsTag);

        $root->appendChild($dataTag);


    }

    $dom->save($a);

}

//$a = 'some.xml';
//$b = 1;
//exportXml($a,$b);