<?php

/**
 * Class Deposit_details
 */
class Deposit_details
{
    /**
     * attributes of the class
     */
    /**
     * @var int
     */
    private $idDd;
    /**
     * @var string
     */
    private $designation;
    /**
     * @var string
     */
    private $unit;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var float
     */
    private $unitprice;
    /**
     * @var float
     */
    private $totaluwt;
    /**
     * @var float
     */
    private $percentage;
    /**
     * @var float
     */
    private $equivalent;
    /**
     * @var int
     */
    private $deposit_id;
    /*================== Getters and Setters =====================*/
    /**
     * @return int
     */
    public function getIdDd()
    {
        return $this->idDd;
    }

    /**
     * @param int $idDd
     * @return Deposit_details
     */
    public function setIdDd($idDd)
    {
        $this->idDd = $idDd;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     * @return Deposit_details
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     * @return Deposit_details
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
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
     * @return Deposit_details
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getUnitprice()
    {
        return $this->unitprice;
    }

    /**
     * @param float $unitprice
     * @return Deposit_details
     */
    public function setUnitprice($unitprice)
    {
        $this->unitprice = $unitprice;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotaluwt()
    {
        return $this->totaluwt;
    }

    /**
     * @param float $totaluwt
     * @return Deposit_details
     */
    public function setTotaluwt($totaluwt)
    {
        $this->totaluwt = $totaluwt;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     * @return Deposit_details
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
        return $this;
    }

    /**
     * @return float
     */
    public function getEquivalent()
    {
        return $this->equivalent;
    }

    /**
     * @param float $equivalent
     * @return Deposit_details
     */
    public function setEquivalent($equivalent)
    {
        $this->equivalent = $equivalent;
        return $this;
    }

    /**
     * @return int
     */
    public function getDepositId()
    {
        return $this->deposit_id;
    }

    /**
     * @param int $deposit_id
     * @return Deposit_details
     */
    public function setDepositId($deposit_id)
    {
        $this->deposit_id = $deposit_id;
        return $this;
    }

    /*==========================================================
      Creation of CRUD C:insert  R:select U:update D:delete
      ==========================================================*/

    /**
     * Insert function details deposit
     */
    function addDepositDetails()
    {
        global $db;
        $requete = $db->prepare('INSERT INTO deposit_details
        (designation, unit, amount, unitprice, totaluwt, percentage, equivalent, deposit_id)
         VALUES (?,?,?,?,?,?,?,?)');
        $requete->execute(array(
            $this->designation,
            $this->unit,
            $this->amount,
            $this->unitprice,
            $this->totaluwt,
            $this->percentage,
            $this->equivalent,
            $this->deposit_id
        ));
    }

    /**
     * Display function deposit_details
     * @return false|PDOStatement
     */
    function getAlldeposit_Details($id)
    {
        global $db;
        $depositdetailListe = $db->prepare('SELECT * FROM deposit_details 
        WHERE deposit_id = ? ORDER BY idDd DESC');
        $depositdetailListe->execute(array($id));
        return $depositdetailListe;

    }

    /**
     * Function of recovery data
     * @param $id
     * @return bool|PDOStatement
     */
    function recupAllDepositdetails($id)
    {
        global $db;
        $depositdetailListe = $db->prepare('SELECT `designation`, `unit`, `amount`, `unitprice`, 
        `totaluwt`, `percentage`, `equivalent`,`deposit_id`,`invoice_id` FROM deposit_details WHERE idDd=?');
        $depositdetailListe->execute(array($id));
        return $depositdetailListe;

    }

    /**
     * Delete function all deposit details
     * @param $id
     * @return bool|PDOStatement
     */
    function DeletAllDepositdetails($id)
    {
        global $db;
        $depositDetailsListe = $db->prepare('DELETE FROM deposit_details WHERE deposit_id = ?');
        $depositDetailsListe->execute(array($id));
        return $depositDetailsListe;

    }

    /**
     *  Delete function deposit details
     */
    function deleteDepositdetails()
    {
        global $db;
        $requete = $db->prepare('DELETE FROM deposit_details WHERE idDd = ?');
        $requete->execute(array($this->idDd));
    }

    /**
     * Update function deposit details
     */
    function updateDepositdetails()
    {
        global $db;
        $requete = $db->prepare('UPDATE deposit_details SET `designation`, `unit`, `amount`, `unitprice`, 
        `totaluwt`, `percentage`, `equivalent`  WHERE idDd = ?');
        $requete->execute(array(
            $this->designation,
            $this->unit,
            $this->amount,
            $this->unitprice,
            $this->totaluwt,
            $this->percentage,
            $this->idDd
        ));
    }

    /**
     * Calculate the sum of a colone function
     * @param $id
     * @return bool|PDOStatement
     */
    function calculateSumDeposit($id)
    {
        global $db;
        $requete = $db->prepare('SELECT SUM(equivalent) FROM deposit_details WHERE deposit_id = ? ;');
        $requete->execute(array($id));
        return $requete;
    }
}