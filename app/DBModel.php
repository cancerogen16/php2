<?php

namespace App;

require_once __DIR__ . '/../config/config.php';

class DBModel {
    protected $conn = null;
    private $_hostname = DB_HOSTNAME;
    private $_database = DB_DATABASE;
    private $_username = DB_USERNAME;
    private $_password = DB_PASSWORD;
    private $_error;

    public function __construct() {
        try {
            $this->conn = @mysqli_connect($this->_hostname, $this->_username, $this->_password, $this->_database) or die("Connection's error" . mysqli_connect_error());
        } catch (\Throwable $th) {
            $this->conn = null;
            $this->_error = $th->getMessage();
        }
    }

    public function protect($val) {
        return strip_tags(htmlspecialchars(mysqli_real_escape_string($this->conn, $val)));
    }

    public function getDbResult($request) {
        $result = @mysqli_query($this->conn, $request) or die(mysqli_error($this->conn));
        $array_result = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $array_result[] = $row;
        }
        return $array_result;
    }

    public function getDbRow($request) {
        $result = @mysqli_query($this->conn, $request) or die(mysqli_error($this->conn));
        $array_result = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $array_result = $row;
        }
        return $array_result;
    }

    public function getLastId() {
        return mysqli_insert_id($this->conn);
    }

    public function getError() {
        return $this->_error;
    }
}