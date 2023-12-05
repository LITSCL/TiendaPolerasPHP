<?php
class ProductoPedido {
	private $id;
	private $pedidoFK;
	private $productoFK;
	private $unidades;
	
	public function getId() {
		return $this->id;
	}

	public function getPedidoFK() {
		return $this->pedidoFK;
	}

	public function getProductoFK() {
		return $this->productoFK;
	}

	public function getUnidades() {
		return $this->unidades;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setPedidoFK($pedidoFK) {
		$this->pedidoFK = $pedidoFK;
	}

	public function setProductoFK($productoFK) {
		$this->productoFK = $productoFK;
	}

	public function setUnidades($unidades) {
		$this->unidades = $unidades;
	}
}
?>