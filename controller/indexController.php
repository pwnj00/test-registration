<?php

/**
 * Controller for front page
 */
class indexController extends CommonController
{
    /**
     * Sign up action method
     */
    public function signupAction()
    {
        // check request method
        if (Router::getMethod() == 'POST') {
            $username = Router::getParam('username');
            $password = Router::getParam('password');

            // fill user object with data and try to save
            $user = new User($username, $password, Router::getIp());
            if (!$user->save()) {
                // add errors to display
                $this->setMessage($user->getErrors(), 'error');
                $this->setVar('username', $user->getUsername());
            } else {
                Router::redirect('index', 'signin');
            }
        } elseif (isset($_SESSION['userId'])) {
            Router::redirect('index', 'index');
        }

        $this->setVar('title', 'Sign up page');
        $this->render('signup');
    }

    /**
     * Sign in (login) action method
     */
    public function signinAction()
    {
        // check request method
        if (Router::getMethod() == 'POST') {
            $username = Router::getParam('username');
            $password = Router::getParam('password');
            $remember = Router::getParam('remember') ? 1 : 0;

            $user = new User();
            // auth user with request params
            if (!$user->auth($username, $password)) {
                // add errors to display
                $this->setMessage($user->getErrors(), 'error');
                $this->setVars(array(
                    'username' => $username,
                    'remember' => $remember
                ));
            } else {
                // change session expire time
                $now = time();
                $expire = $remember ? ($now + 60 * 60 * 24 * 30 * 12) : ($now + 60 * 60 * 24); // 1 year : 1 day
                $params = session_get_cookie_params();
                setcookie(session_name(), $_COOKIE[session_name()], $expire, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

                // remember user id to session
                $_SESSION['userId'] = $user->getUserId();

                Router::redirect('index', 'index');
            }
        } elseif (isset($_SESSION['userId'])) {
            Router::redirect('index', 'index');
        }
        $this->setVar('title', 'Sign in page');
        $this->render('signin');
    }

    /**
     * Index action method (main page)
     */
    public function indexAction()
    {
        // is userId sets in session
        if (!isset($_SESSION['userId'])) {
            Router::redirect('index', 'signin');
        }
        $userId = $_SESSION['userId'];

        // load user by id
        $user = new User();
        if (!$user->load($userId)) {
            // flush session
            session_unset();
            Router::redirect('index', 'signin');
        }
        // set up view vars
        $this->setVars(array('user' => $user->toArray(), 'title' => 'User page'));
        $this->render('index');
    }

    /**
     * Logout action method
     */
    public function logoutAction()
    {
        // flush session and go to sign in page
        session_unset();
        Router::redirect('index', 'signin');
    }
}