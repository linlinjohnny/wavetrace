<?php

class Mod_patch extends CI_Model {

	 function __construct() {
        parent::__construct();
    }

	public function patchAll() {
		$allFunctions = get_class_methods($this);

		foreach ( $allFunctions as $item ) {
			if ( in_array($item, array('create', 'patchAll', '__construct', '__get', 'fixColumn', 'dropColumn', 'hasDone')) ) {
				continue;
			}

			if ( $item == 'initTable' ) {
				$this->$item();
				continue;
			}

			if ( $this->hasDone($item) ) {
				continue;
			}

			$this->$item();
			$this->create($item);

			echo "Patch {$item}.\r\n";
		}

		echo "All patch have done.\r\n";
	}


	public function initTable() {
		$this->mylibrary->mkdir(FCPATH . 'data/home');
		$this->mylibrary->mkdir(FCPATH . 'data/media');
		$this->mylibrary->mkdir(FCPATH . 'data/temp');
		$this->mylibrary->mkdir(FCPATH . 'data/concept');


		$this->db->query("CREATE TABLE IF NOT EXISTS `user` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`account` varchar(255) NOT NULL,
			`password` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`name` varchar(255) NOT NULL,
			`ip` varchar(255) NOT NULL,
			`loginTime` datetime DEFAULT NULL,
			`createTime` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");
		$adminExist = $this->Mod_manage->getUser('admin@admin.com', 'account');
		if ( !$adminExist ) {
			$param = array( 'account'    => 'admin@admin.com',
							'password'   => md5(md5('password')),
							'name'		 => 'Admin',
							'email'	   	 => 'admin@admin.com',
							'createTime' => date("Y-m-d H:i:s"),
							'ip'		 => $this->input->ip_address() );

			$this->Mod_manage->createUser($param);
		}


		$this->db->query("CREATE TABLE IF NOT EXISTS `email_record` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`to` text NOT NULL,
			`subject` text NOT NULL,
			`message` text NOT NULL,
			`createTime` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");





		$this->db->query("CREATE TABLE IF NOT EXISTS `patch_record` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(128) NOT NULL,
			`createTime` datetime NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");


		$this->db->query("CREATE TABLE IF NOT EXISTS `sysconfig` (
			`name` varchar(50) NOT NULL,
			`value` text,
			`createTime` datetime NOT NULL,
			`updateTime` datetime NOT NULL,
			UNIQUE KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		$sysconfigs = $this->mylibrary->getAllSysconfigs();
		if ( !$sysconfigs ) {
			$this->db->insert('sysconfig', array('name' => 'home_carouselMask', 'value' => '{"title":"title","subTitle":"subTitle","active":"0"}', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_conceptTitle', 'value' => 'Home concept Title', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_conceptDescription', 'value' => 'Home concept Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_lookbookTitle', 'value' => 'Home lookbook Title', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_lookbookSubTitle', 'value' => 'Home lookbook SubTitle', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_lookbookDescription', 'value' => 'Home lookbook Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_lookbookUrl', 'value' => 'http://www.umic.co/', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_editorialTitle', 'value' => 'Home editorial Title', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_editorialDescription', 'value' => 'Home editorial Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'home_editorialUrl', 'value' => 'http://www.umic.co/', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'customercare', 'value' => 'Customercare Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'concept', 'value' => 'Concept Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'mind_title', 'value' => 'Mind Title', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
			$this->db->insert('sysconfig', array('name' => 'mind_description', 'value' => 'Mind Description', 'createTime' => date("Y-m-d H:i:s"), 'updateTime' => date("Y-m-d H:i:s")));
		}


		$this->db->query("CREATE TABLE IF NOT EXISTS `contact` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(255) NOT NULL,
			`email` varchar(255) NOT NULL,
			`subject` varchar(255) NOT NULL,
			`message` text NOT NULL,
			`response` text DEFAULT NULL,
			`status` tinyint(4) DEFAULT '0',
			`updateTime` datetime DEFAULT NULL,
			`createTime` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");


		$this->db->query("CREATE TABLE IF NOT EXISTS `media` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) DEFAULT NULL,
			`allowType` text DEFAULT NULL,
			`maxCnt` tinyint(4) DEFAULT '0',
			`recommendSize` varchar(32) DEFAULT NULL,
			`resize` text DEFAULT NULL,
			`sortable` tinyint(4) DEFAULT '0',
			`path` varchar(255) NOT NULL,
			`createTime` datetime NOT NULL,
			`updateTime` datetime DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;");


		$this->db->query("CREATE TABLE IF NOT EXISTS `media_content` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`mediaID` int(11) NOT NULL,
			`title` varchar(255) DEFAULT NULL,
			`description` text DEFAULT NULL,
			`url` text DEFAULT NULL,
			`fileName` varchar(255) NOT NULL,
			`fileType` varchar(16) NOT NULL,
			`sn` int(11) DEFAULT '0',
			`createTime` datetime NOT NULL,
			`updateTime` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `mediaID` (`mediaID`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
		$query = $this->db->query("SELECT * FROM media");
		if ( !$query->result_array() ) {
			// for ckeditor
			$this->mylibrary->mkdir((FCPATH . "data/media/ckeditor"));

			// for home carousel
			$md5Type = substr(md5(rand(1, 9999) . date("Y-m-d H:i:s")), 0, 1);
	        $md5Dir = md5(rand(1, 9999) . date("Y-m-d H:i:s"));
	        $path = "data/media/{$md5Type}/{$md5Dir}";
	        $this->mylibrary->mkdir((FCPATH . $path));
			$this->db->query("INSERT INTO media SET `id`='2', `allowType`='bmp,jpeg,jpg,png,svg', `recommendSize`='w1920xh1080', `sortable`='1', `path`='{$path}', `createTime`=NOW()");

			// for mind
			$md5Type = substr(md5(rand(1, 9999) . date("Y-m-d H:i:s")), 0, 1);
	        $md5Dir = md5(rand(1, 9999) . date("Y-m-d H:i:s"));
	        $path = "data/media/{$md5Type}/{$md5Dir}";
	        $this->mylibrary->mkdir((FCPATH . $path));
			$this->db->query("INSERT INTO media SET `id`='4', `allowType`='bmp,jpeg,jpg,png,svg', `recommendSize`='', `sortable`='1', `path`='{$path}', `createTime`=NOW()");
		}


	}

	public function create($name) {
		$this->db->insert('patch_record', array('name' => $name, 'createTime' => date("Y-m-d H:i:s")));
	}

	public function hasDone($name) {
		$query = $this->db->query("SELECT * FROM patch_record WHERE name=?", array($name));

		$query = $query->result_array();

		return ( $query ) ? TRUE : FALSE;
	}

	private function fixColumn($table, $col, $sql) {
		$exists = $this->db->field_exists($col, $table);
        if ( !$exists ) {
            echo "Update table: {$table}/col: {$col}...\r\n";
            $this->db->query($sql);
        } else {
            echo "Column {$table} > {$col} already exist.\r\n";
        }
    }

	private function dropColumn($table, $col, $sql) {
        $exists = $this->db->field_exists($col, $table);
        if ($exists) {
            echo "Drop table: {$table}/col: {$col}...\r\n";
            $this->db->query($sql);
        } else {
            echo "Column {$table} > {$col} not exist.\r\n";
        }
    }

}
