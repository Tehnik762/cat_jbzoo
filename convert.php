<?php

// SETTINGS

$filename = $_GET['file'] ? $_GET['file'] : 'test.csv';
$delimeter = $_GET['del'] ? $_GET['del'] : '^';
$cit = $_GET['cit'] ? $_GET['cit'] : '~';
$cat = $_GET['cat'] ? $_GET['cat'] : 'Категория';


require_once "parsecsv.php";

$f = new parseCSV();
$f->delimiter = $delimeter;
$f->enclosure = $cit;
$f->parse($filename);


class CatJbZOO {
    private $cats = []; // name, alias, paremt
  
public function __construct($data, $cat) {
    foreach ($data as $value) {
        $this->parseCat($value[$cat]);
    }
    // now $cats is full - write it in new csv
    
}
    private function parseCat($cat) {
        
        if (!$this->checkCat($cat)) {
            $cats_in_array = explode("///", $cat);
            $cat_in_line = $cats_in_array[0];
            foreach ($cats_in_array as $key => $one_cat) {
               if (!$this->checkCat($cat_in_line)) {
                   $hash = md5($cat_in_line);
                   $alias = $this->translit($one_cat);
                   if ($key == 0) {
                       $parent = '';
                   } else {
                       $parent = $this->translit($cats_in_array[$key-1]);
                   }
                   
                   $this->cats[$hash]=[
                       'name' => $one_cat,
                       'alias' => $alias,
                       'parent' => $parent
                   ];
                   print_r($this->cats[$hash]);
                   echo "<br/>";
                   $cat_in_line = "///".$one_cat; 
               
               } else {
                  $cat_in_line = "///".$one_cat; 
               }
            }
            
            
            
            
        }
        
        
        
        
        
        
        
    }
    private function checkCat($cat) {
        $hash_cat = md5($cat);
        if (in_array($hash_cat, $this->cats)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ');
        $lat = array('a', 'b', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya', '_');
        return strtolower(str_replace($rus, $lat, $str));
    }
    
}

$z = new CatJbZOO($f->data, $cat);


/*
foreach ($f->data as $key => $value) {
    echo $key.PHP_EOL;
    echo $value[$cat].PHP_EOL;
}*/