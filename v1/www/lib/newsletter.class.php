<?
class newsletter
{
	var $nb;
	function newsletter()
	{
		$this->nb = 0;
	}
	
	function send($mails, $subject, $message, $from)
	{
		$this->nb=0;
		$to = $from;
		
		/* D'autres en-têtes */
		$headers = "From: Zordania <$from>\n";
		
		/* Pour envoyer un mail au format HTML, vous pouvez configurer le type Content-type. */
		$headers  .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			
		if(is_array($mails))
		{
			$headers .= "Bcc: ";
			foreach($mails as $key => $value)
			{
				$mail = $value['mbr_mail'];
				$pseudo = $value['mbr_pseudo'];
				$headers .= "$mail,";
				$this->nb++;
			}
			$headers .= "\n";
		}
		else
		{
			$headers .= "Bcc: $mails\n";
		}	
		$headers = str_replace(",\n","\n",$headers);
		
		$headers .= "X-Mailer: PHP/" . phpversion()."\n";
		//echo"( $to, $subject, $message, $headers)";
		//echo $this->nb;
      		return mail ( $to, $subject, $message, $headers);
	}
	
}
?>