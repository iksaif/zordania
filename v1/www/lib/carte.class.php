<?
/**************************************************
* Classe permettant de gerer les cartes           *
**************************************************/
class carte
{
var $sql;

	function carte(&$_sql)
	{
	$this->sql = &$_sql;
	}
	
	function get_map($mid,$position,$zoom = 1)
	{
		$mid = (int) $mid;
		$x1 = (int) $position['x1'];
		$y1 = (int) $position['y1'];
		$x2 = (int) $position['x2'];
		$y2 = (int) $position['y2'];
		
		$sql="SELECT * FROM ".$this->sql->prebdd."map 
			WHERE (map_x >= $x1 AND map_x < $x2) AND (map_y >= $y1 AND map_y < $y2) ORDER BY map_y DESC";
		
		$cases = $this->sql->make_array($sql);
		
		foreach($cases as $rien => $result)
		{
			$nb = (($result['map_x'] - $x1)/ $zoom) + (($result['map_y'] - $y1)/ $zoom)*(10*$zoom);
			//echo "<br/>$nb = ((".$result['map_x']." - $x1)/ $zoom) + ((".$result['map_y']." - $y1)/ $zoom)*(10*$zoom)";
			$return['cases'][$nb] = $result;
		}
		sort ($return['cases']);
		
		$sql="SELECT map_x,map_y,mbr_mid,mbr_pseudo,mbr_points,mbr_etat,mbr_race 
			FROM ".$this->sql->prebdd."mbr 
			LEFT JOIN ".$this->sql->prebdd."map ON map_cid=mbr_mapcid 
			WHERE (map_x >= $x1 AND map_x <= $x2) AND (map_y >= $y1 AND map_y <= $y2)
			"; 
		
		$members = $this->sql->make_array($sql);
		foreach($members as $rien => $result)
		{
			$return['members'][$result['map_x']][$result['map_y']] = array('mbr_mid' => $result['mbr_mid'],
											'mbr_pseudo' => $result['mbr_pseudo'],
											'mbr_race' => $result['mbr_race'],
											'mbr_etat' => $result['mbr_etat'],
											'mbr_points' => $result['mbr_points']);
		}
		
		$sql="SELECT map_x,map_y,leg_lid,mbr_pseudo,mbr_etat,mbr_race 
			FROM ".$this->sql->prebdd."leg LEFT JOIN ".$this->sql->prebdd."mbr 
			ON leg_mid=mbr_mid 
			LEFT JOIN ".$this->sql->prebdd."map 
			ON map_cid = leg_cid 
			WHERE 
			(map_x >= $x1 AND map_x <= $x2) AND (map_y >= $y1 AND map_y <= $y2) 
			AND mbr_mid = ' ".$mid."'
			AND leg_etat != 0
			";
				
		$return['legions'] = $this->sql->make_array($sql);
		
		return $return;
	}
	
	function get_infos($mid,$mapcid)
	{
		$mid = (int) $mid;
		$mapcid = (int) $mapcid;
		$y = (int) $position['y'];
		
		$sql ="SELECT map_type,map_rand,map_x,map_y,map_cid,mbr_mid,mbr_pseudo,mbr_etat,mbr_points,mbr_race FROM ".$this->sql->prebdd."map ";
		//$sql.=" LEFT JOIN ".$this->sql->prebdd."leg ON map_cid = leg_cid ";
		$sql.=" LEFT JOIN ".$this->sql->prebdd."mbr ON map_cid = mbr_mapcid ";
		$sql.=" WHERE map_cid = $mapcid";
		return $this->sql->make_array($sql);
	}
}
?>