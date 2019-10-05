<?php

/**
 * Class Address
 */
class Address
{
    /**
     * attributes of the class
     */
    /**
     * @var integer
     */
    private $idA;
    /**
     * @var string
     */
    private $way;
    /**
     * @var integer
     */
    private $postalcode;
    /**
     * @var string
     */
    private $city;
    /*================== Getters and Setters =====================*/
    /**
     * @return int
     */
    public function getIdA()
    {
        return $this->idA;
    }

    /**
     * @param int $idA
     * @return Address
     */
    public function setIdA($idA)
    {
        $this->idA = $idA;
        return $this;
    }

    /**
     * @return string
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * @param string $way
     * @return Address
     */
    public function setWay($way)
    {
        $this->way = $way;
        return $this;
    }

    /**
     * @return int
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * @param int $postalcode
     * @return Address
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return int
     */
    /*==========================================================
Creation of CRUD C:insert  R:select U:update D:delete
==========================================================*/
    /**
     * Function add an address
     */
    function addAddress()
    {

        global $db;
        $requete = $db->prepare('INSERT INTO address(way,postalcode,city) values(?,?,?)');

        $requete->execute(array(
            $this->way,
            $this->postalcode,
            $this->city));
    }

    /**
     * Function display all address
     * @return false|PDOStatement
     */
    function getAllAddress()
    {
        global $db;
        $listeAddress = $db->query('select * from address');
        return $listeAddress;
    }

    /**
     * Delete an address function
     */
    function deleteAddress()
    {
        global $db;
        $requete = $db->prepare('DELETE FROM address WHERE idA = ?');
        $requete->execute(array($this->idA)
        );
    }

    /**
     * Update function of an address
     */
    function updateAddress()
    {
        global $db;
        $requete = $db->prepare('UPDATE address SET way=?, postalcode=? , city=? WHERE idA = ?');
        $requete->execute(array(
            $this->way,
            $this->postalcode,
            $this->city,
            $this->idA
        ));
    }

    /**
     * check the existence of an address
     * @param $way
     * @param $postalcode
     * @param $city
     * @return bool
     */
    function isAddressExiste($way, $postalcode, $city)
    {
        global $db;
        $existe = false;
        $reqAddress = $db->prepare('SELECT * FROM address WHERE way = ? AND postalcode = ?  and  city = ?');
        $reqAddress->execute(array($way, $postalcode, $city));
        if ($reqAddress->rowCount() == 1) {
            $existe = true;
        }
        return $existe;
    }

    /**
     * Recovery function id address
     * @param $way
     * @param $postalcode
     * @param $city
     * @return mixed|null
     */
    function recupIdAdress($way, $postalcode, $city)
    {
        global $db;
        $var = null;
        $reqIdAddress = $db->prepare("SELECT idA FROM address WHERE way=? AND postalcode=? AND city=?");
        $reqIdAddress->execute(array($way, $postalcode, $city));
        $var = $reqIdAddress->fetchColumn();
        if ($var != null) {
            return $var;
        }
    }

    /**
     * Recovery function data address
     * @param $id
     * @return bool|PDOStatement
     */
    function recupAddressdetails($id)
    {
        global $db;
        $addressListe = $db->prepare('SELECT way , postalcode , city FROM address WHERE idA = ?');
        $addressListe->execute(array($id));
        return $addressListe;
    }
}