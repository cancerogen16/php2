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
        $query = "SELECT user_id FROM user WHERE username = '" . protect($username) . "'";

        $results = get_db_result($query);

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

        $query = "SELECT * FROM user"; // получение из базы всех пользователей

        $results = get_db_result($query);

        if (count($results) == 0) { // если пользователь первый
            $user_role = 'admin';
        } else {
            $user_role = 'customer';
        }

        $query = "INSERT INTO user (username, password, user_role, ip) VALUES ('" . protect($username) . "', '" . $password_hash . "', '" . $user_role . "', '" . $ip . "')";

        return update_db($query);
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