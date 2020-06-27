<?php

class orderColumn{
	var $p_order;
	var $f_order;
	var $t_order;
	
	/**
	* Contructor
	* @var string Nombre del campo de la tabla, por el cual se ordena
	* el registro
	* @var string el orden de la columna (asc,desc) 
	*/
	function orderColumn($cmp, $order){
		if ($cmp != null && $order != null){
			$this->f_order = "$cmp $order";
			$this->p_order = "/$cmp/$order";
			if($order == 'asc')
				$this->t_order = 'desc';
			else	
				$this->t_order = 'asc';
		}else{
			$this->p_order = '';
			$this->f_order = null;
			$this->t_order = 'desc';
		}
	}

	function getOrder(){
		return $data = array(
			"p_order"=>$this->p_order,
			"f_order"=>$this->f_order,
			"t_order"=>$this->t_order);
	}
}
?>
