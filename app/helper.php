<?php

function slug($string) {
    return preg_replace('/\s+/u', env('SLUG',"-"), trim($string));
}
