<?php
/**
 * Class DB
 * Allows you to make requests easier than before by using PDO
 *
 * More details here: https://github.com/AxelPariss/DB
 * Created by Axel Paris (contact@axelparis.fr)
 */
class DB{
    private $db;
    /**
     * Connect to the database
     * @param $dbhost
     * @param $dbname
     * @param $dbuser
     * @param $dbpswd
     */
    public function __construct($dbHost, $dbName, $dbUser, $dbPswd){
        $this->db = new PDO('mysql:host='.DATABASE_HOST.';dbName='.DATABASE_NAME.';charset=utf8', DATABASE_USER, DATABASE_PASSWORD);
    }
    /**
     * Execute an SQL query and return the result (prepared request or not)
     * @param string $request SQL query
     * @param array|null $values Optional values
     * @return PDOStatement
     */
    private function exec($request, $values = null){
        $req = $this->db->prepare($request);
        $req->execute($values);
        return $req;
    }
    /**
     * Define the fetchMode
     * @param int $fetchMode fetchMode
     */
    public function setFetchMode($fetchMode){
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    }
    /**
     * Execute an SQL query and return the status
     * @param string $request SQL query
     * @param array|null $values Optional values
     * @return bool Result of the request
     */
    public function execute($request, $values = array()){
        $results = self::exec($request, $values);
        return ($results) ? true : false;
    }
    /**
     * Execute an SQL query and return row(s) of the result
     * @param string $request SQL query
     * @param array|null $values Optional values
     * @param bool $all Query with several rows or not
     * @return array|mixed Return data
     */
    public function fetch($request, $values = null, $all = true) {
        $results = self::exec($request, $values);
        return ($all) ? $results->fetchAll() : $results->fetch();
    }
}