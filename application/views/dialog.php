<?php

	$jsFiles = $this->myjs->getAllFiles();
	$cssFiles = $this->mycss->getAllFiles();
	
	$start = <<<HTML
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<meta name='viewport' content='width=1200' />
			<link rel='stylesheet' href='{$this->baseUrl}assets/css/third_party/bootstrap.css' />
			<link rel='stylesheet' href='{$this->baseUrl}assets/css/third_party/jquery-ui.css' />
			<link rel='stylesheet' href='{$this->baseUrl}assets/css/application/my_base.css' />
			{$cssFiles}
			<script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/jquery.js'></script>
			<script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/bootstrap.js'></script>
			<script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/jquery-ui.js'></script>
			{$jsFiles}
		</head>
		<body>
HTML;
	echo $start;
	

	$this->mylayout->show();
	
	
	$end = <<<HTML
		</body>
	</html>
HTML;
	echo $end;
	
	
	$js = <<<JAVASCRIPT
	
		if ( window.top == window ) {
			window.location.href = '{$this->baseUrl}';
		}
	
JAVASCRIPT;
	$this->myjs->add($js);
	
	
	$this->myjs->active();
