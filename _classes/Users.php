<?phpinclude_once '_config/db.php';/** * Class Users */class Users{    /**     * attributes of the class     */    /**     * @var int     */    private $idU;    /**     * @var string     */    private $name;    /**     * @var string     */    private $firstname;    /**     * @var string     */    private $email;    /**     * @var string     */    private $phone;    /**     * @var string     */    private $password;    /**     * @var int     */    private $friends;    /*================== Getters and Setters =====================*/    /**     * @return int     */    public function getIdU()    {        return $this->idU;    }    /**     * @param int $idU     * @return Users     */    public function setIdU($idU)    {        $this->idU = $idU;        return $this;    }    /**     * @return string     */    public function getName()    {        return $this->name;    }    /**     * @param string $name     * @return Users     */    public function setName($name)    {        $this->name = $name;        return $this;    }    /**     * @return string     */    public function getFirstname()    {        return $this->firstname;    }    /**     * @param string $firstname     * @return Users     */    public function setFirstname($firstname)    {        $this->firstname = $firstname;        return $this;    }    /**     * @return string     */    public function getEmail()    {        return $this->email;    }    /**     * @param string $email     * @return Users     */    public function setEmail($email)    {        $this->email = $email;        return $this;    }    /**     * @return string     */    public function getPhone()    {        return $this->phone;    }    /**     * @param string $phone     * @return Users     */    public function setPhone($phone)    {        $this->phone = $phone;        return $this;    }    /**     * @return string     */    public function getPassword()    {        return $this->password;    }    /**     * @param string $password     * @return Users     */    public function setPassword($password)    {        $this->password = $password;        return $this;    }    /**     * @return int     */    public function getFriends()    {        return $this->friends;    }    /**     * @param int $friends     * @return Users     */    public function setFriends($friends)    {        $this->friends = $friends;        return $this;    }/*========================================================== Creation of CRUD C:insert  R:select U:update D:delete==========================================================*/    /**     * Function display user     * @return false|PDOStatement     */    function getAllUsers()    {       global $db ;        $userListe = $db->query('SELECT idU, name , firstname , email , phone  , password , friends FROM users');        return $userListe;    }    /**     * Update user function     */    function updateUser()    {        global $db;        $requete = $db->prepare('UPDATE users SET password = ?');        $requete->execute(array(            $this->password,        ));    }    /**     * Check the existence of an user     * @param $email     * @return bool     */    function isUserExiste($email)    {       global $db ;        $existe = false;        $requser = $db->prepare('SELECT * FROM users WHERE email = ?');        $requser->execute(array($email));        if ($requser->rowCount() == 1) {            $existe = true;        }        return $existe;    }    /**     * Check the existence of an user     * @param $email     * @param $friend     * @return bool     */    function isExactUserData($email , $friend){        global $db;        $existe = false;        $requser = $db->prepare('SELECT * FROM users WHERE email = ? AND friends = ?');        $requser->execute(array($email , $friend));        if ($requser->rowCount() == 1) {            $existe = true;        }        return $existe;    }}