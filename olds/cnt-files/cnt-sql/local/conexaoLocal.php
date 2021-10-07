<?php 
/**CONEXÃO SITE SALES**/
class Conexao{
	private $db;
	private $host;
	private $user;
	private $pass_senha;
	private $scheme_db;

	function __construct(){
		$this->host = '127.0.0.1';
		$this->user = 'root';
		$this->pass_senha = '';
		$this->scheme_db = 'wwsale_intranet_unificado';
	}

	//ABRIR CONEXAO COM DB
	public function openConexao(){
		$this->db = mysqli_connect(
			$this->host,
			$this->user,
			$this->pass_senha,
			$this->scheme_db
		);
		mysqli_set_charset($this->db, 'utf8');
		if(mysqli_connect_errno()){
			echo json_encode(array('status'=>0,'message'=>mysqli_connect_error()));
			exit();
		}
	}
	
	//FECHAR CONEXAO COM DB
	public function closeConexao(){
		mysqli_close($this->db);
	}

	//CHAMAR CONEXÃO
	public function getConexao(){
		return $this->db;
	}
}

?>