<?php 
class datetimetool  
{   
	public static function getnow(string $formato_final = 'Y-m-d H:i:s') 
	{
		return (new DateTime('now'))->format($formato_final);
	}

	public static function getTimeStamp(string $formato_final = 'Y-m-d H:i:s')  
    {
         return (new DateTime('now'))->format($formato_final);
    }

	public static function format(string $data, string $formato_final)
	{
            return (new DateTime($data))->format($formato_final);
    }
	public static function ageCalculator($dob)
	{
		if ($dob != '0000-00-00') {
			$birthdate = new \DateTime($dob);
			$today = new \DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		} 
		else 
		{
			return null;
		}
	}	
}
?>