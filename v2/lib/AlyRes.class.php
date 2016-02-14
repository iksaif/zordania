<?php
/*
 * SOMMAIRE :
 *
 * GRENIER : zrd_al_res et zrd_al_res_log
 *  get
 *  get_norm
 *  add
 *  get_log
 *  mod
 */

class AlyRes {
	private static $__sql;
	private static $initialized = false;

	// constructeur private pour interdire de faire new Aly();
	private function __construct(){}

	private static function init() {
		if(!self::$initialized){
			global $_sql;
			self::$__sql = &$_sql;
			self::$initialized = true;
		}
	}


	public static function get($aid, $type = 0)/* grenier */
	{
		self::init();
	
		$aid = protect($aid, "uint");
		$type = protect($type, "uint");
	
		$sql="SELECT ares_type,ares_nb FROM ".self::$__sql->prebdd."al_res WHERE ares_aid = $aid";
		if($type) $sql.=" AND ares_type = $type";
		if(!$type) $sql.=" ORDER BY ares_type ASC";
	
		return self::$__sql->make_array($sql);
	}

	public static function get_norm($aid) // grenier "normalisé" ('id'= ressource et valeur = nb)
	{
		$result = get($aid);
		$return = array();
		foreach($result as $row)
			$return[$row['ares_type']] = $row['ares_nb'];
		return $return;
	}

	public static function get_log($aid, $limite2, $limite1 = 0, $synth = false)/* qui a pris quoi au grenier */
	{
		self::init();
	
		$aid = protect($aid, "uint");
		$limite1 = protect($limite1, "uint");
		$limite2 = protect($limite2, "uint");
		$synth = protect($synth, 'bool');

		if ($synth)
			$sql="SELECT mbr_pseudo, mbr_gid,mbr_mid,arlog_mid,arlog_type,SUM(arlog_nb) as total,arlog_ip ";
		else
			$sql="SELECT mbr_pseudo, mbr_gid,mbr_mid,arlog_mid,arlog_type,arlog_nb,_DATE_FORMAT(arlog_date) as arlog_date_formated ,arlog_ip ";

		$sql.=" FROM ".self::$__sql->prebdd."al_res_log ";
		$sql.=" LEFT JOIN ".self::$__sql->prebdd."mbr ON mbr_mid = arlog_mid ";
		$sql.=" WHERE arlog_aid = $aid";
		if ($synth)
			$sql .= ' GROUP BY arlog_mid,arlog_type';

		$sql.=" ORDER BY arlog_date DESC ";
		if($synth === false)
			$sql.="LIMIT ". ($limite1 ? "$limite1,$limite2" : $limite2);

		return self::$__sql->make_array($sql);	
	}

	public static function add($aid, $mid, $type, $nb)/* prendre/retirer au grenier 1 ressource */
	{
		return self::mod($aid, $mid, array($type => $nb));
	}

	public static function mod($aid, $mid, $res, $coef = 1)/* prendre/retirer au grenier plusieurs ressources */
	{
		self::init();
	
		$aid = protect($aid, "uint");
		$mid = protect($mid, "uint");
		$res = protect($res, "array");
		$sql = '';
		$sql_log = array();
		$ip = get_ip();

		foreach($res as $type => $nb){
			if($nb){
				$nb = $nb * $coef;
				$sql = "INSERT INTO ".self::$__sql->prebdd."al_res VALUES ($aid,$type,$nb)";
				$sql .= " ON DUPLICATE KEY UPDATE ares_nb = ares_nb + $nb;";
				self::$__sql->query($sql);

				$sql_log[] = "('',$aid,$mid,$type,$nb,NOW(),'$ip')";
			}
		}

		if(!empty($sql_log)){
			//self::$__sql->query($sql);
	
			$sql = "INSERT INTO ".self::$__sql->prebdd."al_res_log VALUES ". implode(',', $sql_log);
			return self::$__sql->query($sql);
		}
	}

}
?>
