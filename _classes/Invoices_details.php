<?php
/**
 * Class Invoices_details
 */
class Invoices_details
{
    /**
     * attributes of the class
     */
    /**
     * @var int
     */
    private $idId;
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
    private $invoice_id;
    /*================== Getters and Setters =====================*/
    /**
     * @return int
     */
    public function getIdId()
    {
        return $this->idId;
    }

    /**
     * @param int $idId
     * @return Invoices_details
     */
    public function setIdId($idId)
    {
        $this->idId = $idId;
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
     * @return Invoices_details
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
     * @return Invoices_details
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
     * @return Invoices_details
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
     * @return Invoices_details
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
     * @return Invoices_details
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
     * @return Invoices_details
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
     * @return Invoices_details
     */
    public function setEquivalent($equivalent)
    {
        $this->equivalent = $equivalent;
        return $this;
    }

    /**
     * @return int
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    /**
     * @param int $invoice_id
     * @return Invoices_details
     */
    public function setInvoiceId($invoice_id)
    {
        $this->invoice_id = $invoice_id;
        return $this;
    }
    /*==========================================================
  Creation of CRUD C:insert  R:select U:update D:delete
  ==========================================================*/

    /**
     * Insert function details invoice
     */
    function addIvoiceDetails()
    {
        global $db;
        $requete = $db->prepare('INSERT INTO invoice_details
        (designation, unit, amount, unitprice, totaluwt, percentage, equivalent, invoice_id)
         VALUES (?,?,?,?,?,?,?,?)');
        $requete->execute(array(
            $this->designation,
            $this->unit,
            $this->amount,
            $this->unitprice,
            $this->totaluwt,
            $this->percentage,
            $this->equivalent,
            $this->invoice_id
        ));
    }

    /**
     * Display function invoice_details
     * @return false|PDOStatement
     */
    function getAllInvoice_Details($id)
    {
        global $db;
        $invoicedetailListe = $db->prepare('SELECT * FROM invoice_details 
        WHERE invoice_id = ? ORDER BY idId DESC');
        $invoicedetailListe->execute(array($id));
        return $invoicedetailListe;

    }
    /**
     * Function of recovery data
     * @param $id
     * @return bool|PDOStatement
     */
    function recupAllInvoicedetails($id)
    {
        global $db;
        $invoicedetailListe = $db->prepare('SELECT `designation`, `unit`, `amount`, `unitprice`, 
        `totaluwt`, `percentage`, `equivalent`,`deposit_id`,`invoice_id` FROM invoice_details WHERE idId=?');
        $invoicedetailListe->execute(array($id));
        return $invoicedetailListe;

    }

    /**
     * Delete function all invoice details
     * @param $id
     * @return bool|PDOStatement
     */
    function DeletAllInvoicedetails($id)
    {
        global $db;
        $invoicedetailsListe = $db->prepare('DELETE FROM invoice_details WHERE invoice_id = ?');
        $invoicedetailsListe->execute(array($id));
        return $invoicedetailsListe;

    }

    /**
     *  Delete function invoice details
     */
    function deleteInvoivedetails()
    {
        global $db;
        $requete = $db->prepare('DELETE FROM invoice_details WHERE idId = ?');
        $requete->execute(array($this->idId));
    }

    /**
     * Update function invoice details
     */
    function updateInvoicedetails()
    {
        global $db;
        $requete = $db->prepare('UPDATE deposit_invoice_details SET `designation`, `unit`, `amount`, `unitprice`, 
        `totaluwt`, `percentage`, `equivalent`  WHERE idId = ?');
        $requete->execute(array(
            $this->designation,
            $this->unit,
            $this->amount,
            $this->unitprice,
            $this->totaluwt,
            $this->percentage,
            $this->idId
        ));
    }

    /**
     * Calculate the sum of a colone function
     * @param $id
     * @return bool|PDOStatement
     */
    function calculateSumInvoicedetails($id)
    {
        global $db;
        $requete = $db->prepare('SELECT SUM(equivalent) FROM invoice_details WHERE invoice_id = ? ;');
        $requete->execute(array($id));
        return $requete;
    }
}