<?
class mch
{
	var $sql;
	
	//construction
	function mch(&$sql)
	{
		$this->sql = &$sql;
	}

	
	//fonction principale
	function exec()
	{

		if(00  == date("H"))
		{
			//Moyenne des trucs vendus aujourd'hui, et supressions
			$sql="SELECT mch_type,mch_nb,mch_type2,mch_nb2 FROM ".$this->sql->prebdd."mch WHERE mch_ach = 1";
			$res_array = $this->sql->make_array($sql);
			foreach($res_array as $value)
			{
				$cours_array[$value['mch_type']][$value['mch_type2']]['res_nb']   += $value['mch_nb'];
				$cours_array[$value['mch_type']][$value['mch_type2']]['res_nb2'] += $value['mch_nb2'];
			}
			
			//Tout décaler
			$sql="UPDATE ".$this->sql->prebdd."mch_sem SET mch_sem_jour = mch_sem_jour - 1";
			$this->sql->query($sql);
			
			//virer celle de y'a une semaine
			$sql="DELETE FROM ".$this->sql->prebdd."mch_sem WHERE mch_sem_jour = 0";
			$this->sql->query($sql);
			
			//Insérer les moyennes du jour
			$sql="INSERT INTO ".$this->sql->prebdd."mch_sem VALUES ";
			foreach($cours_array as $mch_type => $mch_array2)
			{
				foreach($mch_array2 as $mch_type2 => $mch_value)
				{
					$sql.="('','$mch_type','".round($mch_value['res_nb2'] / $mch_value['res_nb'],2)."',7),";
				}	
			}
			$sql = str_replace(", ","",$sql." ");
			//echo $sql;
			$this->sql->query($sql);
			
			//Moyenne de la semaine /!\	
			$sql="SELECT * FROM ".$this->sql->prebdd."mch_sem";
			$mch_array = $this->sql->make_array($sql);
			$cours_array = array();
			foreach($mch_array as $mch_value)
			{
				$cours_array[$mch_value['mch_sem_res']] += $mch_value['mch_sem_cours'];
			}
			
			$sql="TRUNCATE TABLE ".$this->sql->prebdd."mch_cours";
			$this->sql->query($sql);
			
			$sql="INSERT INTO ".$this->sql->prebdd."mch_cours VALUES ";
			foreach($cours_array as $mch_type => $mch_value)
			{
					$sql.="('','$mch_type','".round($mch_value / 7,2)."'),";
			}
			$sql = str_replace(", ","",$sql." ");
			$this->sql->query($sql);
		}
		
		//Faire avancer les ventes dans le marcher
		$sql="UPDATE ".$this->sql->prebdd."mch SET mch_tours = mch_tours +1";
		$this->sql->query($sql);
		
		//Virer les vieilles
		$sql="DELETE FROM ".$this->sql->prebdd."mch WHERE mch_tours > ".MCH_MAX;
		$this->sql->query($sql);
	}
}
?>
