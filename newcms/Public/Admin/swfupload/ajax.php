<?php
$src = $_SERVER['DOCUMENT_ROOT'].$_GET['src'];

if (file_exists($src)) {
	unlink($src);
}
