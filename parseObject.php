<?php

class parseObject extends parseRestClient{
	public $_includes = array();
	private $_className = '';

	public function __construct($class=''){
		if($class != ''){
			$this->_className = $class;
		}
		else{
			$this->throwError('include the className when creating a parseObject');
		}

		parent::__construct();
	}

	public function __set($name,$value){
		if($name != '_className'){
			$this->data[$name] = $value;
		}
	}

	public function save(){
		if(count($this->data) > 0 && $this->_className != ''){
			$request = $this->request(array(
				'method' => 'POST',
				'requestUrl' => 'classes/'.$this->_className,
				'data' => $this->data,
			));
			return $request;
		}
	}

    public function get($id){
        if($this->_className != '' || !empty($id)){
            $requestUrl = 'classes/'.$this->_className.'/'.$id;

            if(!empty($this->_includes)){
                $requestUrl .= '?include='.implode(',', $this->_includes);
            }

            $request = $this->request(array(
                'method' => 'GET',
                'requestUrl' => $requestUrl
            ));

            return $request;
        }
    }

	public function update($id){
		if($this->_className != '' || !empty($id)){
			$request = $this->request(array(
				'method' => 'PUT',
				'requestUrl' => 'classes/'.$this->_className.'/'.$id,
				'data' => $this->data,
			));

			return $request;
		}
	}

	public function increment($field,$amount){
		$this->data[$field] = $this->dataType('increment', $amount);
	}

	public function decrement($field,$amount){
		$this->data[$field] = $this->dataType('decrement', $amount);
	}


	public function delete($id){
		if($this->_className != '' || !empty($id)){
			$request = $this->request(array(
				'method' => 'DELETE',
				'requestUrl' => 'classes/'.$this->_className.'/'.$id
			));

			return $request;
		}
	}

	public function addInclude($name){
		$this->_includes[] = $name;
	}
}

?>