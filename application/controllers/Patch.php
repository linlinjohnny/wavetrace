<?php 

class Patch extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->model('patch/Mod_patch');
		$this->load->model('manage/Mod_manage');
	}
	
	/**  
	**** $functionName will call Mod_patch's function
	**** example: 127.0.0.1/facetrade/patch/single/initTable
	**/
	function single($functionName) {
		if ( !$functionName ) {
			return;
		}
	
	
		if ( $this->Mod_patch->hasDone($functionName) ) {
			echo "{$functionName} already done.\r\n";
			return;
		}
	
		$this->Mod_patch->$functionName();
		$this->Mod_patch->create($functionName);
		
		echo "Patch {$functionName}.\r\n";
	}
	
	function all() {
		$this->Mod_patch->patchAll();
	}

    
    
	
}