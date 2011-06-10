<?php
/**
 * magentaHelper - a specific Magenta Form helper
 *
 * @author Marc Friederich
 */
 
/** 
* coupe_str - Coupe les chaines de caractères à une certaine longueur, puis rajoute trois ptits pts 
* 
* @param  string  str    Obligatoire - La chaine de caractères 
* @param  integer max    Obligatoire - longueur de la chaine de sortie 
* @param  integer type   Faculitatif - indique si il faut prendre en considération les mots ou pas (val 0 ou 1) 
* @return result  str    Chaine coupée + ... 
**/ 
function coupe_str($str,$max, $type=0){ 
    // Si la longueur de la chaine dépasse la valeur max alors ... 
    if(strlen($str)>$max){ 
        // suppression des espaces au début 
        $str = ltrim($str); 
        switch ($type){ 
        case 0: 
            // en prennant consideration des mots. 
             
            // on applique la fonction wordwrap qui essaye 
            // de couper juste après la fin d'un mot. 
            // j'utilise comme séparateur >|| (pquoi pas...) 
            $str = wordwrap($str,$max-3,'>||',1); 
            // séparation de la chaine par délimit >|| 
            $str = explode('>||',$str); 
            // on prend le premier bout et on rajoute les ptit pts 
            $str = $str[0].'...'; 
            break; 
        case 1: 
            // sans prendre en consideration les mots 
            $str = substr($str,0,$max-3); 
            $str = $str.'...'; 
            break; 
        } 
    } 
    return $str; 
}