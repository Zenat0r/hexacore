<?php

if ( ! function_exists('convMonth')){
	function month($monthId){
		$tab = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
		return $tab[$monthId];
	}
}

if ( ! function_exists('convMonth'))
{
	// renvoie les messages d'erreurs selon leurs codes
	function convMonth($game) {
		$game->ga_date = new DateTime($game->ga_date);
		$game->ga_dateEnd = new DateTime($game->ga_date->format('Y-m-d'));

		$game->ga_dateEnd->modify('+6 day');

		$month = $game->ga_date->format('m');
		$monthEnd = $game->ga_dateEnd->format('m');

		$day = $game->ga_date->format('d');
		$dayEnd = $game->ga_dateEnd->format('d');

		if($month == $monthEnd){
			$game->ga_date_text = $day . "-" . $dayEnd . " " . month((int)$month);
		}else{
			$game->ga_date_text = $day . " " . month((int)$month) . " au " . $dayEnd . " " . month((int)$monthEnd);
		}
		return $game;
	}
}