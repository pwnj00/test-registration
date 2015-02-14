<?php

/**
 * Web view class
 */
class WebView
{
    /**
     * @var array Variables for template
     */
    private $vars = array();

    /**
     * Render template or return content
     * @param string $name
     * @param null|array $vars
     * @param bool $display
     * @return string|null
     * @throws Exception
     */
    public function renderTemplate($name, $vars = NULL, $display = TRUE)
    {
        $template_path = '../template/' . $name . '.tpl.php';

        if (!file_exists($template_path)) {
            throw new Exception('Template \'' . $name . '\' not found');
        }

        if ($vars && is_array($vars)) {
            foreach ($vars as $key => $value) {
                $this->vars[$key] = $value;
            }
        }

        extract($this->vars);

        if ($display) {
            include $template_path;
            return NULL;
        } else {
            ob_start();
            include $template_path;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
    }

    /**
     * Render template with HTML wrapper
     * @param string $name
     * @param array $vars
     * @param array $messages
     */
    public function render($name, $vars = array(), $messages = array())
    {
        $vars['messages'] = $messages;
        $this->renderTemplate('html', array(
            'title' => isset($vars['title']) ? $vars['title'] : '',
            'content' => $this->renderTemplate($name, $vars, FALSE),
            'messages' => $messages
        ));
    }
}