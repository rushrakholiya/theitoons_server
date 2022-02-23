<?php
if(!function_exists('test_ran')) {
	function test_ran()
	{
		return 1234;		

	}
}
if(!function_exists('displayError')) {
	function displayError($validation,$field)
	{
		if(isset($validation))
		{
			if($validation->hasError($field))
			{
				return $validation->getError($field);
			}
			else
			{
				return false;
			}

		}

	}
}
?>