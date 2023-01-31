<?php 
namespace App\Services;

use App\Models\User;
use App\Models\Entry;


class UserHandler 
{   

    public $param;
    public $user;
    public $entry;
    public function __construct() {
        $this->user = new User();
        $this->entry = new Entry();
    }
    public function setRegisterParam($param) {
        if ($param != null) {
            $this->param = $param[0]['params'];
            $this->param['email'] = filter_var($this->param['email'], FILTER_SANITIZE_EMAIL);
            $this->param['phone_number'] = filter_var($this->param['phone_number'], FILTER_SANITIZE_NUMBER_INT);
            $this->param['first_name'] = htmlspecialchars($this->param['first_name']);
            $this->param['last_name'] = htmlspecialchars($this->param['last_name']);
            $this->param['password'] = htmlspecialchars($this->param['password']);
        }   
    }
    public function setLoginParam($param) {
        if ($param != null) {
            $this->param = $param[0]['params'];
            $this->param['email'] = filter_var($this->param['email'], FILTER_SANITIZE_EMAIL);
            $this->param['password'] = htmlspecialchars($this->param['password']);
        }   
    }
    public function validateNewUser() {

        $usersColumns = array('first_name', 'last_name', 'email', 'password', 'phone_number','terms');
        foreach ($usersColumns as $value) { 
            if ($this->param[$value] == null) {
                return false;
            }
        }
        
        if ($this->user->getUserEmail($this->param['email']) != null){
            return false;
        }
        if (!filter_var($this->param['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (!empty($this->param['phone_number'])) {
            $this->param['phone_number'] = str_replace('-','',$this->param['phone_number']);
        }
        if(!preg_match('/^[0-9]{10}+$/', $this->param['phone_number'])) {

            return false;
        }
        if ($this->param['terms'] == false) {
            return false;
        } 
        return true;    
    }
    public function validateUser() {
        if ($this->user->getUserEmail($this->param['email']) == null){
            return false;
        }
        $dbPassword = $this->user->getUserPassword($this->param['password']);
        if (!password_verify($this->param['password'], $dbPassword)){
            
            return false;
        }
        return true;
    }
    public function registerUser() {
        if (self::validateNewUser()) {
            $this->param['password'] = password_hash($this->param['password'], PASSWORD_DEFAULT);
            $this->user->addUser($this->param);
            self::startUserSession();
            return true;
        } else {
            return false;
        }
    }
    public function loginUser() {
        if (self::validateUser()) {
            self::startUserSession();
            return true;
        } else {
            return false;
        }
    }
    public function startSession() {
        if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
            session_start();
            return true;
        } else {
            return false;
        }
    }
    public function startUserSession() {
        self::startSession();
        $userID = $this->user->getUserID($this->param['email']);
        if (!empty($userID)) {
            $_SESSION['userID'] = $userID;
        }
    }

    public function confirmEntry() {
        self::startSession();
        $userID = $_SESSION['userID'];
        if ($this->entry->checkAllowedEntry($userID)) {
            $this->entry->addEntry($userID);
            return true;
        } else {
            return false;
        }
       
    }
}