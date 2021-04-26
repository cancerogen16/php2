<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    private $user_id;

    public $username;

    public function __construct()
    {
        parent::__construct();

        $this->user_id = isset($_SESSION['user_id']) && $_SESSION['loggedin'] == true ? $_SESSION['user_id'] : 0;
        $this->username = isset($_SESSION['username']) && $_SESSION['loggedin'] == true ? $_SESSION['username'] : '';
    }

    /**
     * Определение пользователя по роли в сессии
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ? true : false;
    }

    /**
     * Определение авторизации
     *
     * @return bool
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ? true : false;
    }

    /**
     * Найден пользователь в базе по имени
     *
     * @param string $username
     * @return bool
     */
    public function existUser($username): bool
    {
        $userExist = false;

        $sql = "SELECT user_id FROM user WHERE username = '$username'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $userExist = true;
        }

        return $userExist;
    }

    /**
     * Добавление пользователя в базу
     *
     * @param string $username
     * @param string $password
     * @return int insert_id
     */
    public function addUser($username, $password)
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM user"; // получение из базы всех пользователей

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $user_role = 'customer';
        } else { // если пользователь первый
            $user_role = 'admin';
        }

        $sql = "INSERT INTO user (username, password, user_role, ip) VALUES (:username, :password, :user_role, :ip)";

        $this->db->query($sql, [
            'username' => $username,
            'password' => $password_hash,
            'user_role' => $user_role,
            'ip' => $ip,
        ]);

        return 1;
    }

    /**
     * Получение пользователей из базы по имени
     *
     * @param string $username
     * @return array
     */
    public function getUsersByName($username)
    {
        $users = [];

        $sql = "SELECT * FROM user WHERE username = '$username'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $users = $query->rows;
        }

        return $users;
    }

    /**
     * Получение данных пользователя из базы по его ID
     *
     * @param int $user_id
     * @return array
     */
    public function getUser($user_id = 0)
    {
        $userData = [];

        $sql = "SELECT * FROM user WHERE user_id = '" . (int)$user_id . "'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            $userData = $query->row;
        }

        return $userData;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}