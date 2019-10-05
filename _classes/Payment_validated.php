<?php
/**
 * Created by PhpStorm.
 * User: JED
 * Date: 04/04/2019
 * Time: 16:24
 */

class Payment_validated
{
    /**
     * @var int
     */
    private $idPv;
    /**
     * @var string
     */
    private $date;
    /**
     * @var int
     */
    private $reference;
    /**
     * @var float
     */
    private $total_turnover;
    /**
     * @var int
     */
    private $site_id;
    /**
     * @var int
     */
    private $deposit_id;
    /**
     * @var int
     */
    private $invoice_id;
    /*================== Getters and Setters =====================*/
    /**
     * @return int
     */
    public function getIdPv()
    {
        return $this->idPv;
    }

    /**
     * @param int $idPv
     * @return Payment_validated
     */
    public function setIdPv($idPv)
    {
        $this->idPv = $idPv;
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
     * @return Payment_validated
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     * @return Payment_validated
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalTurnover()
    {
        return $this->total_turnover;
    }

    /**
     * @param float $total_turnover
     * @return Payment_validated
     */
    public function setTotalTurnover($total_turnover)
    {
        $this->total_turnover = $total_turnover;
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
     * @return Payment_validated
     */
    public function setSiteId($site_id)
    {
        $this->site_id = $site_id;
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
     * @return Payment_validated
     */
    public function setDepositId($deposit_id)
    {
        $this->deposit_id = $deposit_id;
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
     * @return Payment_validated
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
     * Payment insertion function
     */
    function addPayment()
    {
        global $db;
        $requete = $db->prepare('INSERT INTO payment_validated (reference, total_turnover, 
        site_id , deposit_id ,invoice_id)
           values(?,?,?,?,?)');
        $requete->execute(array(
            $this->reference,
            $this->total_turnover,
            $this->site_id,
            $this->deposit_id,
            $this->invoice_id
        ));
    }

    /**
     * Update payment function
     */
    function updatePayment()
    {
        global $db;
        $requete = $db->prepare('UPDATE payment_validated SET reference = ? , total_turnover = ? ,
        site_id = ? , deposit_id = ? , invoice_id = ? WHERE idPv = ?');
        $requete->execute(array(
            $this->reference,
            $this->total_turnover,
            $this->site_id,
            $this->deposit_id,
            $this->invoice_id,
            $this->idPv
        ));
    }

    /**
     * Delete payment function
     */
    function deletePayment()
    {
        global $db;
        $requete = $db->prepare('DELETE FROM payment_validated WHERE idPv = ?');
        $requete->execute(array($this->idPv));
    }

    /**
     * Display function payment
     * @return false|PDOStatement
     */
    function getAllDepositPaymentvalidated()
    {
        global $db;
        $paymentListe = $db->query('SELECT idPv ,\'date\' , reference, total_turnover , totalwt,vat,totalttc 
        FROM payment_validated INNER JOIN deposit WHERE payment_validated.deposit_id = deposit.idD ORDER BY idPv DESC');
        return $paymentListe;

    }

    /**
     * Display function payment
     * @return false|PDOStatement
     */
    function getAllInvoicePaymentvalidated()
    {
        global $db;
        $paymentListe = $db->query('SELECT idPv ,\'date\' , reference, total_turnover, totalwt,vat,totalttc 
        FROM payment_validated INNER JOIN invoices WHERE payment_validated.invoice_id = invoices.idI ORDER BY idPv DESC');
        return $paymentListe;

    }
    /**
     * Display function payment
     * @return false|PDOStatement
     */
    function getAllSitePaymentvalidated()
    {
        global $db;
        $paymentListe = $db->query('SELECT idPv ,reference, date , total_turnover, site_id , deposit_id ,invoice_id 
        ,initialmonatant ,totalpayments , remainingbalance ,quotation_id
        FROM payment_validated INNER JOIN sites WHERE payment_validated.site_id = sites.idS ORDER BY idPv DESC');
        return $paymentListe;

    }

    /**
     * check the existence of an deposit_id
     * @param $id
     * @return int
     */
    function countPaymentDepositId($id)
    {
        global $db;
        $reqPayment = $db->prepare('SELECT * FROM payment_validated WHERE deposit_id = ?');
        $reqPayment->execute(array($id));
        $var = $reqPayment->rowCount();
        return $var;
    }

    /**
     * check the existence of an invoice_id
     * @param $id
     * @return int
     */
    function countPaymentInvoiceId($id)
    {
        global $db;
        $reqPayment = $db->prepare('SELECT * FROM payment_validated WHERE invoice_id = ?');
        $reqPayment->execute(array($id));
        $var = $reqPayment->rowCount();
        return $var;
    }

    /**
     * check the existence of an site_id
     * @param $id
     * @return int
     */
    function countPaymentSiteId($id)
    {
        global $db;
        $reqPayment = $db->prepare('SELECT * FROM payment_validated WHERE site_id = ?');
        $reqPayment->execute(array($id));
        $var = $reqPayment->rowCount();
        return $var;
    }

    /**
     * Function of recovery data
     * @param $id
     * @return bool|PDOStatement
     */
    function recupPaymentdetails($id)
    {
        global $db;
        $paymentListe = $db->prepare('SELECT \'date\', reference, total_turnover, site_id, deposit_id, invoice_id 
        FROM payment_validated WHERE idPv = ?');
        $paymentListe->execute(array($id));
        return $paymentListe;

    }
    /**
     * Calculate the sum of a colone function
     * @param $id
     * @return bool|PDOStatement
     */
    function SumTotalturnover()
    {
        global $db;
        $requete = $db->prepare('SELECT SUM(total_turnover) FROM payment_validated');
        $requete->execute(array());
        return $requete;
    }
    /**
     * Calculate the sum of a colone function
     * @param $id
     * @return bool|PDOStatement
     */
    function SumTotalturnoverDeposit($id)
    {
        global $db;
        $requete = $db->prepare('SELECT SUM(total_turnover) FROM payment_validated WHERE deposit_id = ?');
        $requete->execute(array($id));
        return $requete;
    }
    /**
     * Calculate the sum of a colone function
     * @param $id
     * @return bool|PDOStatement
     */
    function SumTotalturnoverSite($id)
    {
        global $db;
        $requete = $db->prepare('SELECT SUM(total_turnover) FROM payment_validated WHERE site_id = ?');
        $requete->execute(array($id));
        return $requete;
    }
}