<?php
class database
{
	public function sanitize($ent)
	{
		$en=htmlentities(strip_tags($ent));
		$en1=htmlentities(stripslashes($en));
		return $en1;
	}
	
	public function parse_path($path)
	{
		$str=explode('_', $path);
		$ct=count($str);
		if($ct==1)
			return $str[0];
		else if($ct==2)
		{
			$s=$str[0]."~".$str[1];
			return $s;
		}
		else
		{
			$s=$str[0]."~".$str[1]."~".$str[2];
			return $s;
		}
		
	}
	
	public function code_chk($fn,$et)
	{
		
		
		$c=0;
		foreach($fn as $lineno => $line)
		{
			if(strpos($line,$et)!==false)	
			{
				$i=$lineno;
				$c++;		
			}
		}
		if($c)
		return $i;
		else
		return false;
	}
}
?>
