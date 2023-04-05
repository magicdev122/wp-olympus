<?php

/**
 * All helpers functions.
 *
 * @category   PHP
 * @author     Achraf Chouk <achrafchouk@gmail.com>
 * @license    https://github.com/GetOlympus/Olympus/blob/master/LICENSE MIT
 * @link       https://github.com/GetOlympus/Olympus
 * @since      0.0.23
 */

function displayError($title, $message, $type, $code = 500)
{
    // Check ErrorDebugger `error500` function
    if (class_exists('\\Olympus\\Components\\Error\\ErrorDebugger')) {
        $ctn = \Olympus\Components\Error\ErrorDebugger::error500($title, $message, $type);
        die($ctn);
    }

    // Add 500 header
    header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, $code);

    // Linear background
    $lbg = 'to right,rgba(191,38,255,.3) 0,rgba(31,107,255,.3) 100%';

    // Add contents
    $ctn  = '<!DOCTYPE html>';
    $ctn .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-EN" lang="en-EN">';
    $ctn .= '<head>';
    $ctn .= '<title>'.$title.'</title>';
    $ctn .= '<meta charset="utf-8"/><meta name="robots" content="noindex"/><meta name="generator" content="Olympus"/>';
    $ctn .= '<style>';
    $ctn .= <<<CSS
#olympus-error{background:#fff;margin:100px auto 0;max-width:98%;width:800px}
#olympus-error h1{color:#333;font:700 42px/40px sans-serif;margin:30px 0 0}
#olympus-error p{color:#333;font:20px/28px Georgia,serif;margin:30px 0 0}
#olympus-error code{color:#333;display:inline-block;font:16px/28px monospace;padding:0 10px}
#olympus-error code{background:rgba(31,107,255,.3);background:linear-gradient($lbg)}
#olympus-error small{color:#333;display:block;font:14px/16px Georgia,serif;margin:30px 0 0}
a{color:#1f6bff}a:hover{color:#475aff}
CSS;
    $ctn .= '</style>';
    $ctn .= '</head>';
    $ctn .= '<body>';
    $ctn .= '<div id="olympus-error">';
    $ctn .= '<h1>'.$title.'</h1><p>'.$message.'</p><small>'.$type.'<br/>--<br/>Please, find more details on the ';
    $ctn .= '<a href="https://github.com/GetOlympus" target="_blank">Olympus framework</a> repository.</small>';
    $ctn .= '</div>';
    $ctn .= '</body>';
    $ctn .= '</html>';

    // Display all and stop
    die($ctn);
}
