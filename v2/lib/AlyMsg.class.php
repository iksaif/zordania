<?php
/*
 * SOMMAIRE :
 *
 * SHOOTBOX : zrd_al_msg
 *  count
 *  get
 *  add
 *  del
 */

class AlyMsg{

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

	public static function count($alid)/* nb msg shootbox */
	{
		self::init();
	
		$alid = protect($alid, "uint");
	
		$sql="SELECT COUNT(*) FROM ".self::$__sql->prebdd."al_shoot WHERE shoot_aid = $alid";
		return self::$__sql->result(self::$__sql->query($sql), 0 );
	}
	
	public static function get($alid,$limite1, $limite2 = 0)
	{
		self::init();
	
		$alid = protect($alid, "uint");
		$limite1 = protect($limite1, "uint");
		$limite2 = protect($limite2, "uint");
	
		$sql="SELECT mbr_mid, shoot_msgid, shoot_mid, shoot_texte,mbr_pseudo,mbr_sign,_DATE_FORMAT(shoot_date) as shoot_date_formated,
			DATE_FORMAT(shoot_date,'%a, %d %b %Y %T') as shoot_date_rss";
		$sql.=" FROM ".self::$__sql->prebdd."al_shoot ";
		$sql.=" JOIN ".self::$__sql->prebdd."mbr ON mbr_mid = shoot_mid ";
		$sql.=" WHERE shoot_aid = '$alid' ";
		$sql.=" ORDER BY shoot_date DESC";
	
		if($limite2) 
			$sql.=" LIMIT $limite2,$limite1"; 
		else
			$sql.=" LIMIT $limite1";

		return self::$__sql->make_array($sql);
	}
	
	public static function add($alid,$text,$mid)
	{
		self::init();
	
		$alid = protect($alid, "uint");
		$mid = protect($mid, "uint");
		$text = protect($text, "bbcode");
	
		$sql="INSERT INTO ".self::$__sql->prebdd."al_shoot VALUES ('','$mid','$alid',NOW(),'$text')";
		return self::$__sql->query($sql);
	}
	
	public static function del($alid,$msgid,$mid,$chef = false)
	{
		self::init();
	
		$alid = protect($alid, "uint");
		$msgid = protect($msgid, "uint");
		$mid = protect($mid, "uint");
		$chef = protect($chef, "bool");
	
		$sql="DELETE FROM ".self::$__sql->prebdd."al_shoot WHERE shoot_msgid=$msgid AND shoot_aid=$alid";
		if(!$chef) $sql.=" AND shoot_mid=$mid";
	
		self::$__sql->query($sql);
		return self::$__sql->affected_rows();
	}

}
?>
