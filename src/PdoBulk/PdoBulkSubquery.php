<?php

namespace PdoBulk;

class pdoBulkSubquery {
	
	private $query;
	
	public function __construct($query) {
		$this->setQuery($query);
	}
	
	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = $query;
	}
	
}