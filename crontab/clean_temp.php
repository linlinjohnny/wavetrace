#!/usr/bin/php -q

<?php

    $path = "../data/temp";
    deleteDir($path);

    function deleteDir($path) {
        if ( substr($path, (strlen($path) - 1), 1) != '/' ) {
            $path .= '/';
        }
        $files = glob($path . '*', GLOB_MARK);
        foreach ( $files as $file ) {
            if ( is_dir($file) ) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($path);
    }
    