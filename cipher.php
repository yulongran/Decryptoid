<?php

/**
 * Encrypt plaintext using simle substitution cipher
 * @param input the input string
**/
function simpleSubstitutionEncryption($input)
{
    $letter = array('a'=>'q', 'b'=>'w', 'c'=>'e', 'd'=>'r', 'e'=>'t',
          'f'=>'y', 'g'=>'u', 'h'=>'i', 'i'=>'o',
          'j'=>'p', 'k'=>'a', 'l'=>'s', 'm'=>'d',
          'n'=>'f', 'o'=>'g', 'p'=>'h', 'q'=>'j',
          'r'=>'k', 's'=>'l', 't'=>'z', 'u'=>'x',
          'v'=>'c','w'=>'v', 'x'=>'b', 'y'=>'n',
          'z'=>'m','A'=>'Q', 'B'=>'W', 'C'=>'E', 'D'=>'R', 'E'=>'T',
          'F'=>'Y', 'G'=>'U', 'H'=>'I', 'I'=>'O',
            'J'=>'P', 'K'=>'A', 'L'=>'S', 'M'=>'D',
                'N'=>'F', 'O'=>'G', 'P'=>'H', 'Q'=>'J',
                'R'=>'K', 'S'=>'L', 'T'=>'Z', 'U'=>'X',
                'V'=>'C','W'=>'V', 'X'=>'B', 'Y'=>'N',
                'Z'=>'M');
    $carray = str_split($input);
    for ($i = 0; $i < count($carray); $i++) {
        if (preg_match("/[a-zA-Z]+/", $carray[$i])) {
            $carray[$i] = $letter[$carray[$i]];
        }
    }
    return implode($carray);
}

/**
 * Decrypt plaintext using simple substitution cipher
 * @param input the input string
**/
function simpleSubstitutionDecryption($input)
{
    $letter = array('q'=>'a', 'w'=>'b', 'e'=>'c', 'r'=>'d', 't'=>'e',
        'y'=>'f', 'u'=>'g', 'i'=>'h', 'o'=>'i',
        'p'=>'j', 'a'=>'k', 's'=>'l', 'd'=>'m',
        'f'=>'n', 'g'=>'o', 'h'=>'p', 'j'=>'q',
        'k'=>'r', 'l'=>'s', 'z'=>'t', 'x'=>'u',
        'c'=>'v','v'=>'w', 'b'=>'x', 'n'=>'y',
        'm'=>'z','Q'=>'A', 'W'=>'B', 'E'=>'C', 'R'=>'D', 'T'=>'E',
              'Y'=>'F', 'U'=>'G', 'I'=>'H', 'O'=>'I',
              'P'=>'J', 'A'=>'K', 'S'=>'L', 'D'=>'M',
              'F'=>'N', 'G'=>'O', 'H'=>'P', 'J'=>'Q',
              'K'=>'R', 'L'=>'S', 'Z'=>'T', 'X'=>'U',
              'C'=>'V','V'=>'W', 'B'=>'X', 'N'=>'Y',
              'M'=>'Z');
    $carray = str_split($input);
    for ($i = 0; $i < count($carray); $i++) {
        if (preg_match("/[a-zA-Z]+/", $carray[$i])) {
            $carray[$i] = $letter[$carray[$i]];
        }
    }
    return implode($carray);
}


/**
 * Encrypt plaintext using double transposition cipher
 * @param input the input string
**/
function doubleTranspositionEncryption($input)
{
    $KEY =  "POTATO";
    $KEY2 = "SPARTA";
    $KEYMAP = array(0=>3, 1=>1, 2=>5, 3=>0, 4=>2, 5=>4);
    $KEYMAP2 = array(0=>2, 1=>5, 2=>1, 3=>3, 4=>0, 5=>4);

    $cipherArray = constructCipherArrayEncryption($input, $KEY);
    for ($row=0; $row<count($cipherArray); $row++) {
        $output=  "";
        for ($col=0; $col< count($cipherArray[0]); $col++) {
            $output = $output.$cipherArray[$row][$col];
        }
    }
    $firstTransposition = constructTextFromCipherArrayEncryption($cipherArray, $KEYMAP);
    $cipherArray2 = constructCipherArrayEncryption($firstTransposition, $KEY2);
    $secondTransposition = constructTextFromCipherArrayEncryption($cipherArray2, $KEYMAP2);
    return $secondTransposition;
}

/**
 * Decrypt cipher using double transposition cipher
 * @param input the cipher text
**/
function doubleTranspositionDecryption($input)
{
    $KEY =  "POTATO";
    $KEY2 = "SPARTA";
    $KEYMAP = array(0=>3, 1=>1, 2=>5, 3=>0, 4=>2, 5=>4);
    $KEYMAP2 = array(0=>2, 1=>5, 2=>1, 3=>3, 4=>0, 5=>4);

    $cipherArray = constructCipherArrayDecryption($input, $KEYMAP2);
    $cipherText  = constructTextFromCipherArrayDecryption($cipherArray);
    $cipherArray2 = constructCipherArrayDecryption($cipherText, $KEYMAP);
    return constructTextFromCipherArrayDecryption($cipherArray2);
}

/**
 * Convert a string to a 2D array with column length same as the given key
 * @param input the input string
 * @param key  cipher key
**/
function constructCipherArrayEncryption($input, $key)
{
    $totalChar = strlen($input);
    $keyLength = strlen($key);
    $columnLength = $keyLength;
    $rowLength = ceil($totalChar / $keyLength);
    $cipherArray = array();
    for ($i=0; $i<$totalChar; $i++) {
        $currentRow = $i / $columnLength;
        $currentCol = $i % $columnLength;
        $cipherArray[$currentRow][$currentCol] = $input[$i];
    }
    return $cipherArray;
}

/**
 * Convert 2D array to the cipher text by using transposition based on the keymap
 * @param input the input string
 * @param keymap a map represents the order of the column
**/
function constructTextFromCipherArrayEncryption($cipherArray, $keymap)
{
    $output = "";
    for ($i=0; $i<count($keymap); $i++) {
        for ($row=0; $row< count($cipherArray); $row++) {
            $output = $output. $cipherArray[$row][$keymap[$i]];
        }
    }
    return $output;
}

/**
 * Convert a string to a 2D array with column length same as the given key
 * @param input the input string
 * @param keymap  a map represents the order of the column
**/
function constructCipherArrayDecryption($input, $keymap)
{
    $totalChar = strlen($input);
    $keyLength = count($keymap);
    $columnLength = $keyLength;
    $rowLength = ceil($totalChar / $keyLength);
    $inputArray = str_split($input);
    $cipherArray = array();
    if ($totalChar % $keyLength != 0) {
        // Shift index by adding empty string
        for ($i=0; $i<$totalChar; $i++) {
            $currentCol= $i / $rowLength;
            $currentRow = $i % $rowLength + 1;
            $shiftedCol = $keymap[$currentCol]+1;
            if ($shiftedCol * $currentRow >= $totalChar) {
                $inputArray = array_insert($inputArray, "", $i);
            }
        }
    }
    $totalChar = count($inputArray);
    for ($i=0; $i<$totalChar; $i++) {
        $currentCol= $i / $rowLength;
        $currentRow = $i % $rowLength;
        $cipherArray[$currentRow][$keymap[$currentCol]] = $inputArray[$i];
    }
    return $cipherArray;
}

/**
 * Convert 2D array to the cipher text by using transposition based on the keymap
 * @param cipherArray  an array representation of the cipher text
**/
function constructTextFromCipherArrayDecryption($cipherArray)
{
    $output = "";
    for ($row=0; $row<count($cipherArray); $row++) {
        for ($col=0; $col<count($cipherArray[0]); $col++) {
            $output = $output.$cipherArray[$row][$col];
        }
    }
    return $output;
}

/**
 * Insert an element to the array at specific index
 * @param array Inserted Array
 * @param value Inserted value
 * @param pos Inserted position by index
**/
function array_insert($array, $value, $pos)
{
    return array_merge(
        array_slice($array, 0, $pos, true),
        array($value),
        array_slice($array, $pos, count($array), true)
    );
}

/**
 * Encrypt and Decrypt plaintext using RC4
 * The RC4 algorithm is taken from https://www.dcode.fr/rc4-cipher
 * @param input the input string
**/
function rc4EncryptionDecryption($input)
{
    $key = "SPARTAN";
    $t = array();
    $keyLength = strlen($key);
    for ($i=0; $i<256; $i++) {
        $t[$i] = $i;
    }
    $j= 0;
    for ($i=0; $i<256; $i++) {
        $j = ($j + $t[$i] + ord($key[$i % $keyLength])) % 256;
        $temp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $temp;
    }
    $a = 0;
    $b = 0;
    $j = strlen($input);
    $output = "";
    for ($i=0; $i<$j; $i++) {
        $a = ($a+1) % 256;
        $b = ($b + $t[$a]) % 256;
        $temp = $t[$a];
        $t[$a] = $t[$b];
        $t[$b] = $temp;
        $output .= $input[$i] ^ chr($t[($t[$a] + $t[$b]) % 256]);
    }

    return $output;
}
