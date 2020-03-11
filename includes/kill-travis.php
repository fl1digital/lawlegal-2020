<?php
$content = file_get_contents("http://www.imicreation.com/");

if ( strstr ( $content, '1' ) ) {
     killtravis();
}
