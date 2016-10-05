<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyLayout {

    private $sysHeaderBox = array();
    private $sysContentBox = array();
	private $sysFooterBox = array();
	private $sysDialogBox = array();
	
	public function add($type, $content) {
		switch ( $type ) {
			case SYS_DIALOG_BOX:
				$this->sysDialogBox[] = $content;
			break;

			case SYS_HEADER_BOX:
				$this->sysHeaderBox[] = $content;
			break;

			case SYS_FOOTER_BOX:
				$this->sysFooterBox[] = $content;
			break;
			
			case SYS_CONTENT_BOX:
			default:
				$this->sysContentBox[] = $content;
			break;
		}
	}
	
	public function show() {
		$result = array();
	
		if ( $this->sysHeaderBox ) {
			$result[] = "<div id='sysHeaderBox'>" . join('', $this->sysHeaderBox) . "</div>";
		}
		
		if ( $this->sysContentBox ) {
			$result[] = "<div id='sysContentBox'>" . join('', $this->sysContentBox) . "</div>";
		}

		if ( $this->sysFooterBox ) {
			$result[] = "<div id='sysFooterBox'>" . join('', $this->sysFooterBox) . "</div>";
		}
		
		if ( $this->sysDialogBox ) {
			$result[] = "<div id='sysDialogBox'>" . join('', $this->sysDialogBox) . "</div>";
		}

		
		echo join('', $result);
	}
	
}