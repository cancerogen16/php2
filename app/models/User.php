<?php

namespace app\models;

use app\lib\Db;
use app\core\Model;

class User extends Model
{
    private $user_id;

    public $username;
    public $password;
    public $acl;

    /**
     * Определение пользователя по роли в сессии
     *
     * @return bool
     */
    public function isAdmin(): bool {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ? true : false;
    }

    /**
     * Определение авторизации
     *
     * @return bool
     */
    public function isLogged(): bool {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ? true : false;
    }

    /**
     * Найден пользователь в базе по имени
     *
     * @param  string $username
     * @return bool
     */
    public function existUser($username): bool {
        $sql = "SELECT user_id FROM user WHERE username = '$username'";

        $results = $this->db->all($sql);

        return (count($results) == 1) ? false : true;
    }

    /**
     * Добавление пользователя в базу
     *
     * @param  string $username
     * @param  string $password
     * @return int insert_id
     */
    public function addUser($username, $password) {
        $ip = $_SERVER['REMOTE_ADDR'];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM user"; // получение из базы всех пользователей

        $results = $this->db->all($sql);

        if (count($results) == 0) { // если пользователь первый
            $user_role = 'admin';
        } else {
            $user_role = 'customer';
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
     * Получение данных пользователя из базы по его имени
     *
     * @param  string $username
     * @return array
     */
    public function getUser($username) {
        $sql = "SELECT * FROM user WHERE username = '$username'";

        return $this->db->all($sql);
    }
}