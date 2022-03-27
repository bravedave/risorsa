<?php
/*
 * David Bray
 * BrayWorth Pty Ltd
 * e. david@brayworth.com.au
 *
 * MIT License
 *
*/

namespace risorsa\dao;

use dao\_dbinfo;

class dbinfo extends _dbinfo {
	/*
	 * it is probably sufficient to copy this file into the
	 * <application>/app/dao folder
	 *
	 * from there store you structure files in
	 * <application>/dao/db folder
	 *
	*/
	protected function check() {
		parent::check();

		\sys::logger( 'checking ' . dirname( __FILE__ ) . '/db/*.php' );

		if ( glob( dirname( __FILE__ ) . '/db/*.php')) {
			foreach ( glob( dirname( __FILE__ ) . '/db/*.php') as $f ) {
				\sys::logger( 'checking => ' . $f );
				include_once $f;

			}

		}

	}

}

