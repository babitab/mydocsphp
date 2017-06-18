<?php 
/**
* This class handles validation for inputs
*/
class Validate{
	
	private $_isValid = false;
	private $_errors = array();
	private $_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	// function to validate a given source of items
	public function validate($source, $items = array()){
		foreach ($items as $item_key => $rules) {
			$item_name = sanitize($rules['label']);
			// get the value from source for the current key
			$value = $source[$item_key];
			$isFile = isset($value['size']) and isset($value['tmp_name']);
			foreach ($rules as $rule_key => $rule_value) {
				// escape the label varification
				if($rule_key == 'label') continue;

				if(!$isFile){
					// for required attributes
					if($rule_key == 'required' and empty($value)){
						$this->addError("{$item_name} is required");
					}else if(!empty($value)){
						switch ($rule_key) {
							case 'minlength':
								if(strlen($value) < $rule_value){
									$this->addError("{$item_name} must be atleast {$rule_value}.");
								}
								break;
							case 'maxlength':
								if(strlen($value) > $rule_value){
									$this->addError("{$item_name} must not exceed {$rule_value}.");
								}		
								break;

							case 'unique':
								$check = $this->_db->get($rule_value, array($item_key, "=", $value));
								if($check->count()){
									$this->addError("{$item_name} already exists.");
								}
								break;
									
							case 'match':
								$match_value = $source[$rule_value];
								$match_item_name = $items[$rule_value]['label'];
								if($value !== $match_value){
									$this->addError("{$item_name} must match with {$match_item_name}.");
								}			
							default:
								break;
						}
					}
				}else{
					$fileUploaded = $value['size'] != 0 ? true : false; 
					if($rule_key == 'required' and !$fileUploaded){
						$this->addError("{$item_name} is required");
					}else if($fileUploaded){
						switch ($rule_key) {
							case 'size':
								if($value['size'] > $rule_value){
									$mb = $rule_value/1000000;
									$this->addError("{$item_name} exceeded limit {$mb} MB.");
								}
								break;
							case 'extension':
								$fileName = $value['name'];
								$ext = pathinfo($fileName, PATHINFO_EXTENSION); 
								if(!in_array($ext, $rule_value)){
									$this->addError("{$item_name} type must be from ". implode('/', $rule_value).".");
								}
								break;
							default:
								break;
						}
					}
				}
			}
		}

		if(empty($this->_errors)){
			$this->_isValid = true;
		}
	}

	private function addError($error){
		$this->_errors[] = $error;
	}

	public function isValid(){
		return $this->_isValid;
	}

	public function errors(){
		return $this->_errors;
	}


}
 ?>