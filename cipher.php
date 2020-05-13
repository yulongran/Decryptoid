<?php

function simpleSubstitutionEncryption($text){
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
    $carray = str_split($text);
    for ($i = 0; $i < count($carray); $i++){
      if (preg_match("/[a-zA-Z]+/", $carray[$i])) {
        $carray[$i] = $letter[$carray[$i]];
      }
    }
    return implode($carray);
}

function simpleSubstitutionDecryption($text){
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
  $carray = str_split($text);
  for ($i = 0; $i < count($carray); $i++){
    if (preg_match("/[a-zA-Z]+/", $carray[$i])) {
      $carray[$i] = $letter[$carray[$i]];
    }
  }
  return implode($carray);
}
