<?php
	function lang($phrase) {

		static $lang = array(

			// Dashboard page
			// ~ Navbat links ~ 
			
			'HOMEADMIN'    => 'Admin area',
			'CATEGORIES'   => 'Categories',
			'ITEMS'        => 'Items',
			'MEMEBERS'     => 'Users',
			'STATISTICS'   => 'Statistics',
			'LOGS'         => 'logs'
		);

		return $lang[$phrase];
	}
?>