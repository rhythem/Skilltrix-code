<?php
class questions
{
	public $ques_id,$ques,$theory,$output,$course_name,$module_no,$pre_code,$hint,$cdstr,$cdt,$ot,$ccex,$ofe,$chkr;

	/*
	*Will fetch question, output and theory
	*Into the object
	*Need to specify question id before calling this
	*/	
	public function get_ques()
	{
		$qid=$this->ques_id;
		$link=mysqli_connect('localhost','root','dZ8LyUqVBm4rfTD4','lr');	
		$sql="SELECT question,pre_code,hint,output,explanation,output_type,cc_expl,of_expl,checker FROM exercises WHERE exercise_id=?";
		$stmt=mysqli_prepare($link,$sql);
		mysqli_stmt_bind_param($stmt,"s",$qid);				
		mysqli_stmt_execute($stmt);		
		mysqli_stmt_bind_result($stmt,$this->ques,$this->pre_code,$this->hint,$this->output,$this->theory,$this->ot
								, $this->ccex,$this->ofe,$this->chkr);
		mysqli_stmt_fetch($stmt);
	}

	/*
	*Will add the question to the database
	*the object needs to have all the data before calling this function
	*/	
	public function add_ques()
	{
		$link=mysqli_connect('localhost','root','mSLruyMbvTxLaAAK','db_ques');
		$sql="INSERT into questions VALUES(?,?,?,?,?,?)";
		$stmt=mysqli_prepare($link,$sql);
		mysqli_stmt_bind_param($stmt,"ssssss",$this->course_name,$this->module_no,$this->ques_id,$this->ques,$this->output,
							$this->theory);
		mysqli_stmt_execute($stmt);
		
	}
}
?>

