<?php

/**
 * Class User
 */
class User
{
    /**
     * @var string username
     */
    private $username;

    /**
     * @var string password hash
     */
    private $password;

    /**
     * @var int user id
     */
    private $userId;

    /**
     * @var string user ip address
     */
    private $ip;

    /**
     * @var int last visited timestamp
     */
    private $visited;

    /**
     * @var int user creation timestamp
     */
    private $created;

    /**
     * @var array Users errors
     */
    private $errors = array();

    /**
     * User password salt
     */
    const PASSWORD_SALT = 's78dF696sdTtwSA';

    /**
     * User constructor
     * @param string $username
     * @param string $password
     * @param string $ip
     */
    public function __construct($username = null, $password = null, $ip = null)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setIp($ip);
    }

    /**
     * Internal methos to check if username is taken
     * @return bool
     * @throws Exception
     */
    private function _checkUsername()
    {
        $sql = 'SELECT get_user_id_by_username(:username) as userId;';
        $result = Db::getInstance()->prepare($sql);
        $result->execute(array(
            ':username' => $this->username
        ));
        $userId = $result->fetch(PDO::FETCH_COLUMN);
        return empty($userId);
    }

    /**
     * Internal method to validate user fields before creation
     * @return bool
     */
    private function _validate()
    {
        if (!empty($this->username)) {
            if (preg_match("/^[0-9a-z-]+$/ui", $this->username)) {
                if (!$this->_checkUsername()) {
                    $this->errors['username'] = 'This username is already taken';
                }
            } else {
                $this->errors['username'] = 'Username should contain only latin chars and numbers';
            }
        } else {
            $this->errors['username'] = 'Username field is empty';
        }
        if (empty($this->password)) {
            $this->errors['password'] = 'Password field is empty';
        }
        if (empty($this->errors)) {
            return true;
        }
        return false;
    }

    /**
     * Set username to user
     * @param $username
     * @return $this user
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get user username
     * @return string username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set user password hash
     * @param $password
     * @return $this user
     */
    public function setPassword($password)
    {
        if (!empty($password)) {
            $this->password = sha1($password . self::PASSWORD_SALT);
        }
        return $this;
    }

    /**
     * Set user ip address
     * @param $ip
     * @return $this user
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * Get user ip address
     * @return string ip
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Get user id
     * @return int user id
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * User authentication method
     * @param $username
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function auth($username, $password)
    {
        $sql = 'SELECT * FROM auth_user(:username, :password, :timestamp);';
        $result = Db::getInstance()->prepare($sql);
        $result->execute(array(
            ':username' => $username,
            ':password' => sha1($password . self::PASSWORD_SALT),
            ':timestamp' => time()
        ));
        $user = $result->fetch(PDO::FETCH_OBJ);
        if (empty($user)) {
            $this->errors['username'] = 'Invalid username or password';
            return false;
        }
        // fill user object with loaded data
        $this->userId = $user->id;
        $this->username = $user->username;
        $this->ip = $user->ip;
        $this->visited = $user->visited;
        $this->created = $user->created;
        return true;
    }

    /**
     * Save user method
     * @return bool
     * @throws Exception
     */
    public function save()
    {
        // validate user data
        if ($this->_validate()) {
            $sql = 'SELECT create_user(:username, :password, :ip, :timestamp) as user_id;';
            $result = Db::getInstance()->prepare($sql);
            $result->execute(array(
                ':username' => $this->username,
                ':password' => $this->password,
                ':ip' => $this->ip,
                ':timestamp' => time()
            ));
            $this->userId = $result->fetch(PDO::FETCH_COLUMN);
            return true;
        }
        return false;
    }

    /**
     * Load user by user id
     * @param $userId user id
     * @return bool
     * @throws Exception
     */
    public function load($userId)
    {
        $sql = 'SELECT * FROM get_user_by_id(:userId);';
        $result = Db::getInstance()->prepare($sql);
        $result->execute(array(
            ':userId' => intval($userId)
        ));
        $user = $result->fetch(PDO::FETCH_OBJ);
        if (empty($user)) {
            return false;
        }
        $this->userId = $user->id;
        $this->username = $user->username;
        $this->ip = $user->ip;
        $this->visited = $user->visited;
        $this->created = $user->created;
        return true;
    }

    /**
     * Fetch user object to array
     * @return array user data
     */
    public function toArray()
    {
        return array(
            'username' => $this->username,
            'ip' => $this->ip,
            'created' => $this->created,
            'visited' => $this->visited
        );
    }

    /**
     * Get user data validation errors
     * @return array errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}