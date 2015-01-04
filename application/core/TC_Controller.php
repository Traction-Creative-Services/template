<?

class TC_Controller extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Not Found
     * @author Martin Sheeks <martin@traction.media>
     * @version 1.0.0
     */
    public function notFound() {
        $data['title']      = "Uh oh! We can't find that";
        $data['activeTab']  = 'not-found';
        
        $this->_loadView('notfound',$data);
    }
    
    /**
     * Load View
     * @author Martin Sheeks <martin@traction.media>
     * @var string Name of page to be loaded
     * @var array data to be passed to the views
     * @version 1.0.0
     */
    protected function _loadView($view,$data = array()) {
        //set the things
        if(!isset($data['title']))
            $data['title'] = $this->config->item('project_name');
        if(!isset($data['activeTab']))
            $data['activeTab'] = strtolower(str_replace(' ','-',$data['title']));
            
        //set the core utility variables
        $data['projName'] = $this->config->item('project_name');
        $data['logoSrc'] = base_url($this->config->item('logo_source'));
        
        //load any TC_utils that might have been requested.
        $data['utilStrings'] = $this->_loadTcUtils();
        
        $this->load->view('components/header',$data);
        $this->load->view('pages/'.$view,$data);
        $this->load->view('components/footer',$data);
    }
    
    /**
     * Load Tc Utils
     * @author Martin Sheeks <martin@traction.media>
     * @return object Object containing header and footer strings
     * @version 1.0.0
     */
    private function _loadTcUtils() {
        $utils = $this->config->item('tc_utils');
        $headerString = '<!-- BEGIN TC UTILS HEADER -->'.PHP_EOL;
        $footerString = '<!-- BEGIN TC UTILS FOOTER -->'.PHP_EOL;
        
        //define strings to be appended to header
        $headerStrings = array(
            'slider'    => '<link rel="stylesheet" href="'.base_url('/assets/tc_utils/slider/slippry.css').'" />'.PHP_EOL,
            'lightbox'  => '<link href="//cdn.rawgit.com/noelboss/featherlight/1.0.3/release/featherlight.min.css" type="text/css" rel="stylesheet" title="Featherlight Styles" />'.PHP_EOL,
            'flipcards' => '<!-- Flipcards Loaded -->'.PHP_EOL,
            'search'    => '<!-- Search Loaded -->'.PHP_EOL,
        );
        
        //define strings to be appended to footer
        $footerStrings = array(
            'slider'    => '<script src="'.base_url('/assets/tc_utils/slider/slippry.min.js').'"></script>'.PHP_EOL,
            'lightbox'  => '<script src="//cdn.rawgit.com/noelboss/featherlight/1.0.3/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>'.PHP_EOL,
            'flipcards' => '<script src="'.base_url('/assets/tc_utils/flip/jquery.flip.min.js').'"></script>'.PHP_EOL,
            'search'    => '<script src="'.base_url('/assets/tc_utils/search/jquery.search.min.js').'"></script>'.PHP_EOL,
        );
        
        //populate the header and footer strings
        foreach($utils as $utility) {
            $headerString .= $headerStrings[$utility];
            $footerString .= $footerStrings[$utility];
        }
        
        //append close to wrapper
        $headerString .= '<!-- END TC UTILS HEADER -->'.PHP_EOL;
        $footerString .= '<!-- END TC UTILS FOOTER -->'.PHP_EOL;
        
        //load them into an object
        $strings = new stdClass();
        $strings->header = $headerString;
        $strings->footer = $footerString;
        
        return $strings;
    }
}