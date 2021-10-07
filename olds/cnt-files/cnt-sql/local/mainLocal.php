<?php 
/**MAINCLASS**/
include('conexaoLocal.php');
class Main{
	private $db;

	public function __construct(){
		$this->db = new Conexao();
		$this->db->openConexao();
	}

	public function __destruct(){
		if($this->db){ $this->db->closeConexao(); }
	}

	//EXECUTE STATEMENT SQL
	public function executeQuery($sql){
		$this->db->closeConexao();
		$this->db->openConexao();
		$result = mysqli_query($this->db->getConexao(),$sql)
		or die(mysqli_error($this->db->getConexao()));
		return $result;
	}

}
?>