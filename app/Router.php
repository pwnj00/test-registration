<?php

/**
 * Check path and route
 */
class Router
{
    /**
     * @var string Module
     */
    protected static $module = 'index';
    /**
     * @var string Action for module
     */
    protected static $action = 'index';
    /**
     * @var array Parameters from $_REQUEST
     */
    protected static $params = array();
    /**
     * @var array Parameters from $_SERVER
     */
    public static $server = array();

    /**
     * Protected constructor
     */
    protected function __construct()
    {
    }

    /**
     * Protected clone
     */
    protected function __clone()
    {
    }

    /**
     * Protected unserialize
     */
    protected function __wakeup()
    {
    }

    /**
     * @static Router launcher
     * @throws Exception
     */
    final public static function launch()
    {
        if ('' == session_id()) {
            session_start();
        }

        self::$server = $_SERVER;

        if ($module = self::getParam('module')) {
            self::$module = $module;
        }
        if ($action = self::getParam('action')) {
            self::$action = $action;
        }

        $controllerName = strtolower(self::$module) . 'Controller';
        $controllerAction = strtolower(self::$action) . 'Action';
        $controller = new $controllerName();
        if (!method_exists($controller, $controllerAction)) {
            throw new Exception('Method \'' . $controllerName . '::' . $controllerAction . '\' not found');
        }
        $controller->$controllerAction();
    }

    /**
     * @static Get parameter from $_REQUEST
     * @param string $param_name
     * @return null|mixed
     */
    final public static function getParam($param_name)
    {
        if (isset($_REQUEST[$param_name])) {
            if (!isset(self::$params[$param_name])) {
                self::$params[$param_name] = $_REQUEST[$param_name];
            }
            return self::$params[$param_name];
        }
        return NULL;
    }

    /**
     * @static Get request method
     * @return mixed
     */
    final public static function getMethod()
    {
        return self::$server['REQUEST_METHOD'];
    }

    /**
     * @static Get client ip
     * @return mixed
     */
    final public static function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return self::$server['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return self::$server['HTTP_X_FORWARDED_FOR'];
        } else {
            return self::$server['REMOTE_ADDR'];
        }
    }

    /**
     * @static Redirect to url
     * @param null|string $module
     * @param null|string $action
     * @param array $params
     */
    final public static function redirect($module = NULL, $action = NULL, $params = array())
    {
        $url = self::url($module, $action, $params);
        header('Location: ' . $url);
    }

    /**
     * @static Create url
     * @param null|string $module
     * @param null|string $action
     * @param array $params
     * @return string
     */
    final public static function url($module = 'index', $action = NULL, $params = array())
    {
        $query = array();
        $url = '/';
        if (!empty($module)) {
            $url .= ($module != 'index' ? $module . '/' : '');
        }

        if ($action) {
            $url .= ($action != 'index' ? $action . '/' : '');
        }
        foreach ($params as $pname => $pvalue) {
            $query[] = $pname . '=' . $pvalue;
        }
        return $url . (!empty($query) ? '?' . implode('&', $query) : '');
    }
}