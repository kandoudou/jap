<?php
//Liste toute les fonctions utilisées sur le site
function encode($chaine) {
    $chaine = trim($chaine);
    $chaine = htmlentities($chaine, ENT_NOQUOTES, 'UTF-8');
    $patterns = array(
        /* lettres speciales : 'é' => 'e', 'ç' => 'c' */
        '#&([A-Za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#',
        /* ligatures : 'œ' => 'oe' */
        '#&([A-Za-z]{2})(?:lig);#',
        /* caracteres speciaux restant : '&' => '', '?' => '' */
        '#&[^;]+;#',
        '#([^a-z0-9/]+)#i',
    );
    $remplacements = array(
        '\1',
        '\1',
        '',
        '-',
    );
    $chaine = preg_replace($patterns, $remplacements, $chaine);
    $chaine = strtolower($chaine);
    return $chaine;
}