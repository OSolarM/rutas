<?php
   class DBConnection {
      var $dbcon;
      
      function DBConnection() {
		global $dbConf;

		//echo MDB_TIPO."<hr>";
		$this->dbcon = & ADONewConnection(MDB_TIPO);
		$this->dbcon->debug = MDB_DEBUG;
		$this->dbcon->Connect(MDB_HOST, MDB_USER, MDB_PASS, MDB_NAME);
		$this->dbcon->SetFetchMode(ADODB_FETCH_ASSOC);
      }
      
      function getConn() {
         return $this->dbcon;
      }
   }//class DBConnection
   
   class DBOracle {
      var $dbcon;
      
      function DBOracle() {
		global $dbConf;
		$this->dbcon = & ADONewConnection(DB_TIPO);
		$this->dbcon->debug = DB_DEBUG;
		$this->dbcon->Connect(DB_HOST, DB_NAME, DB_USER,DB_PASS);
		$this->dbcon->SetFetchMode(ADODB_FETCH_ASSOC);
      }
      
      function getConn() {
         return $this->dbcon;
      }
   }//class DBOracle