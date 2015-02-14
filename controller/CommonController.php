<?php

/**
 * Base controller class
 */
abstract class CommonController
{
    /**
     * @var array Messages for render
     */
    protected $messages = array();

    /**
     * @var array Variables for render template
     */
    private $vars = array();

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * @param string $type
     * @return array Messages
     */
    public function getMessages($type = null)
    {
        if (!empty($type) && isset($this->messages[$type])) {
            return $this->messages[$type];
        }
        return $this->messages;
    }

    /**
     * @param array|string $messages Messages
     * @param string $type Type of messages
     */
    protected function setMessage($messages, $type = 'status')
    {
        if (!is_array($messages)) {
            $messages = array($messages);
        }
        if (!isset($this->messages[$type])) {
            $this->messages[$type] = array();
        }
        $this->messages[$type] = array_merge($this->messages[$type], $messages);
    }

    /**
     * @param string $name Name of variable
     * @param mixed $value Value of variable
     */
    protected function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * @param array $vars Variables
     */
    protected function setVars($vars)
    {
        $this->vars = array_merge($this->vars, $vars);
    }

    /**
     * @param string $template Template name
     */
    protected function render($template)
    {
        $view = new WebView($this);
        $view->render($template, $this->vars, $this->getMessages());
    }
}
