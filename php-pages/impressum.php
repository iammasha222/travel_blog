<?php

$file_path =  '../html-pages/impressum.html';

if (file_exists($file_path)) {
    include $file_path;
} else {
    echo "File $file_path not found.";
}
