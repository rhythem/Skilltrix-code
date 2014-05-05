<?php
class compiler
{
	public $check;
	

	/*
	*Compiler code will return error or output
	*pass coding as the argument
	*if output is sent then this->check=1
	*if error is sent then this>check=0
	*/
	public function get_op($code)
	{
		$fname="fgh.c";
		$flink=fopen($fname,'w');
		exec("chmod 777 -R fgh.c");
		fwrite($flink,$code);
		fclose($flink);
		shell_exec("gcc fgh.c -o agh.out");
		exec("./agh.out",$out);
		exec("gcc fgh.c 2>&1",$err);
		
		if(!$err)
		{	
			$this->check=1;
			return $out;
		}
		else
		{
			$this->check=2;
			return $err;	
			
		}	
	}
	


	/*
	*It will parsed the coding for spaces and newlines
	*just send the coding as argument
	*/
	public function parse_code($parse_code)
	{
		$ret="";
		$len=strlen($parse_code);
		for($i=0;$i<$len;$i++)	
		{
			
			 if($parse_code[$i]=="\n")
			$ret.="\n";
			else if($parse_code[$i]=="<")
			$ret.="&lt;";
			else if($parse_code[$i]==">")
			$ret.="&gt;";
			else if($parse_code[$i]=="\"")
			$ret.="&quot;";
			else
			$ret.=($parse_code[$i]);
		}
		return $ret;
	}	


	
	/*
	*It will parse the output or the error just send it as argument
	*Will return parsed string
	*/
	public function parse_op($parse_out)
	{
		$ret="";
		foreach($parse_out as $str)
		{	
			$ret.="\n";
			$len=strlen($str);
			for($i=0;$i<$len;$i++)
			{
				//if($str[$i]==" ")
				//$ret.="&nbsp;";
				//else if($str[$i]=="")
				//else
				$ret.="$str[$i]";
			}
		}
		return $ret;	
	}
}
?>
