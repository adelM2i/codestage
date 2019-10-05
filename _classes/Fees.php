<?php

/**
 * Class fees
 */
class Fees
{
//attributes of the class
    /**
     * @var int
     */
    private $idF;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $nature;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var int
     */
    private $site_id;

    /*================== Getters and Setters =====================*/
    /**
     * @return int
     */
    public function getIdF()
    {
        return $this->idF;
    }

    /**
     * @param int $idF
     * @return Fees
     */
    public function setIdF($idF)
    {
        $this->idF = $idF;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     * @return Fees
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param string $nature
     * @return Fees
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Fees
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getSiteId()
    {
        return $this->site_id;
    }

    /**
     * @param int $site_id
     * @return Fees
     */
    public function setSiteId($site_id)
    {
        $this->site_id = $site_id;
        return $this;
    }

    /*==============================================================
             Creation of CRUD C:insert  R:select U:update D:delete
    ===============================================================*/

    //Function add an fee
    function addfee()
    {
        global $db;
        $requete = $db->prepare('INSERT INTO fees (date,nature,amount,site_id) values(?,?,?,?)');
        $requete->execute(array(
            $this->date,
            $this->nature,
            $this->amount,
            $this->site_id
        ));
    }

    // Function display all fees
    function getAllsiteFee()
    {
        global $db;
        $listeFee = $db->query('SELECT idF , date , nature , amount , site_id ,initialmonatant ,totalpayments ,
        remainingbalance ,quotation_id FROM fees INNER JOIN sites WHERE fees.site_id = sites.idS 
        ORDER BY idF DESC');
        return $listeFee;

    }

    // Update function of an fee
    function updateFee()
    {
        global $db;
        $requete = $db->prepare('UPDATE fees SET date=? , nature=? , amount=? , site_id=? where idF = ?');
        $requete->execute(array(
            $this->date,
            $this->nature,
            $this->amount,
            $this->site_id,
            $this->idF
        ));
    }

    // Delete an fee function
    function deleteFee()
    {
        global $db;
        $requete = $db->prepare('DELETE FROM fees WHERE idF = ?');
        $requete->execute(array($this->idF));
    }

    /**
     * check the existence of an fee
     * @param $date
     * @param $nature
     * @param $amount
     * @param $site_id
     * @return bool
     */
    function isFeeExiste($date, $nature, $amount, $site_id)
    {
        global $db;
        $existe = false;
        $reqFee = $db->prepare('SELECT * FROM fees WHERE date = ? AND nature = ? AND amount = ? AND site_id = ?');
        $reqFee->execute(array($date, $nature, $amount, $site_id));
        if ($reqFee->rowCount() >= 1) {
            $existe = true;
        }
        return $existe;
    }

}