<?php

error_reporting(E_ALL);

spl_autoload_register('autoloader');

function autoloader($className)
{
    $filename = $className . '.php';
    $paths = array('app', 'controller', 'model', 'view');
    foreach ($paths as $path) {
        $file = '../' . $path . '/' . $filename;
        if (FALSE !== file_exists($file)) {
            include $file;
        }
    }
    if (!class_exists($className, FALSE)) {
        throw new Exception("Class " . $className . " not found");
    }
}

try {
    Router::launch();
} catch (Exception $e) {
    try {
        $code = in_array($e->getCode(), array(404, 418)) ? $e->getCode() : 500;
        header("HTTP/1.0 " . $code);
        $view = new WebView();
        $view->render('error', array(
            'title' => 'Error ' . $code,
            'code' => $code,
            'message' => $e->getMessage() . ' [Error: ' . $e->getCode() . ']',
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ));
    } catch (Exception $ex) {
        $code = in_array($ex->getCode(), array(404, 418)) ? $ex->getCode() : 500;
        header("HTTP/1.0 " . $code);
        $message = <<<HERE
<div id="error">
  <h2 class="title">Error {$code}</h2>
  <div class="message">{$ex->getMessage()} [Error: {$ex->getCode()}]</div>
  <div class="file">In file <span>{$ex->getFile()}</span> on line <span>{$ex->getLine()}</span></div>
  <pre class="trace">{$ex->getTraceAsString()}</pre>
</div>
HERE;
        exit($message);
    }
}