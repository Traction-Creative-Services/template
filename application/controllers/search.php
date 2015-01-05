<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Search controller provides the website search and indexing functionality
 * bundled with TC Utils.
 * DO NOT delete or rename the search controller
 * - MMS 2014
 *
 */
class Search extends TC_Controller {

	/**
	 * Index
	 * loads the default search view of the website
	 * @author Martin Sheeks <martin@traction.media>
	 * @version 1.0.0
	 */
	public function index()
	{
            $data['title'] = 'Search';
            $data['activeTab'] = 'search';
            $this->_loadView('search');
	}
        
        public function admin() {
            $data['title'] = 'Search Admin';
            $data['activeTab'] = 'search-admin';
            $data['indexed'] = $this->_isIndexed();
            $this->_loadView('search/admin', $data);
        }
        
        /**
         * indexSite
         * initiates an indexing process that can run in the background
         * @author Martin Sheeks <martin@traction.media>
         * @version 1.0.0
         */
        public function indexSite() {
            //get the map of items to be indexed outside of static pages, if any
            $indexMap = $this->input->post('indexMap');
			$auto = $this->input->post('autoMap');
			if($auto == "on") {
				$auto = true;
			} else {
				$auto = false;
			}
            $map = json_decode($indexMap);
            
            $err_code = $this->_initIndex($map,$auto);
            switch($err_code) {
                case -1:
                    $msg = "Site Indexed successfully";
                    break;
                case 0:
                    $msg = "No map was provided to map";
            }
            
            echo json_encode($msg);
        }
        
        /**
         * searchResult
         * get the results of a search string
         * @author Martin Sheeks <martin@traction.media>
         * @var string Search String
         * @var bool AJAX or full return
         * @version 1.0.0
         * @return json Search Result Object
         */
        public function searchResult() {
            //get the search string
            $query = $this->input->post('query');
            
            //get the type of search to be performed
            $ajax = $this->input->post('ajax');
            
            $results = $this->_getSearchResultSet($query);
            
            if($ajax) {
                header("Content-type:application/JSON");
                echo json_encode($results);
            }
            else {
                $data['title'] = 'Search | '.$query;
                $data['activeTab'] = 'search';
                $data['results'] = $results;
                $this->_loadView('search',$data);
            }
        }
        
        /**
         * Is Indexed
         * check whether an index has been run on the site
         * @author Martin Sheeks <martin@traction.media>
         * @return bool Index exists, or not
         * @version 1.0.0
         */
        private function _isIndexed() {
            //check if the search_index_ready flag is set in the database
            //$flag = $this->db->get_where('tc_config',array('key' => 'search_index_ready'))->row();
            //
            //return $flag->value;
			return false;
        }
        
        private function _initIndex($map = null,$auto = false) {
            if($map !== null) {
                $this->_buildIndexTable();
				if($auto)
						$this->_buildAutoIndex();
                $this->_fillIndex($map,$auto);
                return -1;
            } else {
                //no map provided, so no indexing will be done.
                return 0;
            }
        }
        
        private function _buildIndexTable() {
            //load the db forge tool
            $this->load->dbforge();
            
            //drop the index if it exists
            $this->dbforge->drop_table('search_index');
            
            //define the index table
            $fields = array(
                'index_entry_id' =>
                    array(
                        'type' => 'INT',
                        'constraint' => 5,
                        'unsigned' => TRUE,
                        'auto_incriment' => TRUE
                    ),
                'display_title' =>
                    array(
                        'type' => 'VARCHAR',
                        'constraint' => '150'
                    ),
                'page_url' =>
                    array(
                        'type' => 'VARCHAR',
                        'constraint' => '255'
                    ),
                'searchable' =>
                    array(
                        'type' => 'LARGETEXT',
                        'null' => TRUE
                    )
            );
            
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('index_entery_id');
            $this->dbforge->create_table('search_index');
        }
        
        private function _fillIndex($map,$auto) {
            //loop through pages in the map and page sweep the files to build a search pool
			if(!$auto) {
				foreach($map->pages as $key => $page) {
						//build the entry array
						$entry = array(
							'display_title' => $key,
							'page_url' => site_url($key),
							'searchable' => ''
						);
						
						//get the DOM document
						$content = file_get_contents($entry['page_url']);
						$doc = new DOMDocument();
						$doc->loadHTML($content);
						
						//make an array of regions to search through
						$regions = explode(',',$page->regions);
						//grab the text from each region we need to search
						foreach($regions as $region) {
							$element = $doc->getElementById($region);
							$entry['searchable'] .= $element->textContent;
						}
						
						//insert the page into the index.
						$this->db->insert('search_index',$entry);
					}
			}
            
            
            //loop through the tables in the map and build a search pool
            foreach($map->tables as $key => $table ) {
                $query = $this->db->get($key);
                $titleField = $table->title_field;
                $slugField = $table->slug_field;
                
                $fieldList = explode(',',$table->fields);
                
                foreach($query->result as $row) {
                    //concat strings
                    $searchable = '';
                    foreach($fieldList as $field) {
                        $searchable .= $row->$field;
                    }
                    $title = $row->$titleField;
                    $url = str_replace('~SLUG~',$row->$slugField, $table->url_pattern);
                    
                    //build the entry array
                    $entry = array(
                        'display_title' => $title,
                        'page_url'      => site_url($url),
                        'searchable'    => $searchable
                    );
                    $this->db->insert('search_index',$entry);
                }
            }
        }
		
		private function _buildAutoIndex() {
				//build the loop pattern
				$pagesFolder = base_url('/application/views/pages');
				$pattern = $pagesFolder."*.php";
				
				foreach(glob($pattern) as $filename) {
						$doc = new DomDocument();
						$doc->loadHTML($filename);
						$regions = $doc->getElementByClassName("tc-searchable");
						$searchable = '';
						foreach($regions as $region) {
								$searchable .= $region->textContent;
						}
						
						$entry = array(
								'display_title' => $filename,
								'page_url' => $filename,
								'searchable' => $searchable
						);
						
						$this->db->insert('search_index',$entry);
				}
		}
}