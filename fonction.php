

<?php

/**
 * Fonction qui permet de traiter de différentes manières un texte
 * @param  string $str     Chaine de caractères à traiter
 * @param  array  $options Listes des options à effectuées sous forme de tableau
 * @return string          Chaine de caractères transformées en fonction des options
 */
function clean_text($str,$options = array()){

	if(in_array('TOUT',$options)):
		$options = array('HTML','TRIM','MAJUSCULE','MINUSCULE','ACCENT','PONCTUATION','TABULATION','ENTER','DOUBLE');
	endif;

	foreach($options as $option):
		switch($option){

			// Suppression des espaces vides en debut et fin de chaque ligne
			case 'TRIM':
				$str = preg_replace("#^[\t\f\v ]+|[\t\f\v ]+$#m",'',$str);
			break;

			// Remplacement des caractères accentués par leurs équivalents non accentués
			case 'ACCENT':
				$str = htmlentities($str, ENT_NOQUOTES, 'utf-8');
				$str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
				$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. 'œ'
				$str = html_entity_decode($str); 
			break;

			// Transforme tout le texte en minuscule
			case 'MINUSCULE':
				$str = mb_strtolower($str, 'UTF-8');
			break;

			// Transforme tout le texte en majuscule
			case 'MAJUSCULE':
				$str = mb_strtoupper($str, 'UTF-8');
			break;

			// Remplace toute la ponctuation par des espaces
			case 'PONCTUATION':
				$str = preg_replace('#([[:punct:]])#',' ',$str);
				$exceptions = array("’");
				$str = str_replace($exceptions,' ',$str);
			break;

			// Remplace les tabulations par des espaces
			case 'TABULATION':
				$str = preg_replace("#\h#u", " ", $str);
			break;

			// Remplace les espaces multiples par des espaces simples
			case 'DOUBLE':
				$str = preg_replace('#[" "]{2,}#',' ',$str);
			break;

			// Remplace 1 entrée (\r\n) par 1 espace
			case 'ENTER':
				$str = str_replace(array("\r","\n"),' ',$str);
			break;

			// Supprime toutes les balises html
			case 'HTML':
				$str = strip_tags($str);
			break;
		}
	endforeach;
	
	return $str;
}

