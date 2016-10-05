<?php

	$webTitle = ( $webTitle ) ? $webTitle : $this->lang->line('webName');
	$webImage = ( $webImage ) ? $webImage : "{$this->baseUrl}assets/imgs/logo.png";

	$jsFiles = $this->myjs->getAllFiles();
	$cssFiles = $this->mycss->getAllFiles();


    $start = <<<HTML
	<!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
			<meta id='viewport' name='viewport' content='width=580, user-scalable=0' />

			<title>{$webTitle}</title>
			<meta name='keywords' content='{$webKeywords}'>
			<meta name='description' content='{$webDescription}'>
			<meta property='fb:app_id' content=''/>
			<meta property='og:url' content='{$this->currentFullUrl}'/>
			<meta property='og:site_name' content='{$webTitle}'/>
			<meta property='og:title' content='{$webTitle}'>
			<meta property='og:description' content='{$webDescription}'/>
			<meta property='og:type' content='website'/>
			<meta property='og:image' content='{$webImage}'/>
            <link rel='apple-touch-icon' href='{$this->baseUrl}assets/imgs/app_logo.png' />
			<link rel='SHORTCUT ICON' href='{$this->baseUrl}favicon.ico' />
			<link rel='icon' href='{$this->baseUrl}favicon.ico' type='image/ico' />
			<link rel='stylesheet' href='{$this->baseUrl}assets/css/third_party/bootstrap.css' />
			<link rel='stylesheet' href='{$this->baseUrl}assets/css/application/my_base.css' />
			{$cssFiles}
			<script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/jquery.js'></script>
            <script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/bootstrap.js'></script>
            <script type='text/javascript' src='{$this->baseUrl}assets/js/third_party/tmpl.min.js'></script>
            <script type='text/javascript' src='{$this->baseUrl}assets/js/application/mylibrary.js'></script>
			{$jsFiles}
		</head>
		<body>
			<div style='position:relative;'>
HTML;
	echo $start;


	$this->mylayout->show();


	$end = "</div>
		</body>
	</html>";
	echo $end;


	$this->myjs->active();
