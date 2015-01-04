<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Home controller is the default used by this application if no route is provided.
 * Home also plays host to the 404 page path
 * DO NOT delete or rename the home controller
 * - MMS 2014
 *
 */
class Home extends TC_Controller {

	/**
	 * Index
	 * loads the default home view of the website
	 * @author Martin Sheeks <martin@traction.media>
	 * @version 1.0.0
	 */
	public function index()
	{
		$data['title'] = 'Home';
		$data['activeTab'] = 'home';
		$this->_loadView('home');
	}
    
}