<?php
/*
 * SOMMAIRE :
 *
 * ALLIANCE : zrd_aly
 *  get_gen
 *  get
 *  edit
 *  add
 *  del
 *  upload_logo
 *  make_thumb
 */

class Aly {
	private static $__sql;
	private static $initialized = false;

	// constructeur private pour interdire de faire new Aly();
	private function __construct(){}

	private static function init() {
		if(!self::$initialized){
			self::$__sql = &mysqliext::$bdd;
			self::$initialized = true;
		}
	}

	public static function get_gen($cond) {
		self::init();

		$limite1 = 0; $limite2 = 0;
		$limite = 0;
		$aid = 0; $name = 0;

		if(isset($cond['limite1'])) {
			$limite1 = protect($cond['limite1'], "uint");
			$limite++;	
		}
		if(isset($cond['limite2'])) {
			$limite2 = protect($cond['limite2'], "uint");
			$limite++;	
		}
	
		if(isset($cond['aid']))
			$aid = protect($cond['aid'], "uint");
		if(isset($cond['name']))
			$name = protect($cond['name'], "string");
		
		$sql="SELECT al_aid,al_name,al_nb_mbr,al_mid,mbr_pseudo,mbr_race, mbr_gid, al_points,al_open";
		if(!$limite)
			$sql.=",al_descr,al_rules";	
	
		$sql.=" FROM ".self::$__sql->prebdd."al ";
		$sql.=" JOIN ".self::$__sql->prebdd."mbr ON mbr_mid = al_mid ";
	
		if($aid || $name) {
			$sql .= "WHERE ";
			if($aid)
				$sql.= "al_aid = $aid AND ";
			if($name)
				$sql.=" al_name LIKE '%$name%' AND ";

			$sql = substr($sql, 0, strlen($sql) - 4);
		}

		$sql .= "ORDER BY al_points DESC ";

		if($limite) {
			if($limite == 2)
				$sql .= "LIMIT $limite2, $limite1 ";
			else
				$sql .= "LIMIT $limite1 ";
		}

		return self::$__sql->query($sql);
		//return self::$__sql->index_array($sql, 'al_aid');
	}

	public static function get($aid)
	{
		if(!$aid)
			return array();
		return self::get_gen(array('aid' => $aid));
	}

	function edit_aly($alid, $edit)
	{
		self::init();

		$alid = protect($alid, "uint");

		$sql="UPDATE ".self::$__sql->prebdd."al SET ";
		if(isset($edit['open'])) {
			$open = protect($edit['open'], "uint");
			$sql.="al_open = $open,";
		}
		if(isset($edit['nb_mbr'])) {
			$nb_mbr = protect($edit['nb_mbr'], "int");
			$sql.="al_nb_mbr = al_nb_mbr + $nb_mbr,";
		}
		if(isset($edit['mid'])) {
			$mid = protect($edit['mid'], "uint");
			$sql.="al_mid = $mid,";
		}
		if(isset($edit['name'])) {
			$name = protect($edit['name'], "string");
			$sql.="al_name = '$name',";
		}
		if(isset($edit['descr'])) {
			$descr = protect($edit['descr'], "bbcode");
			$sql.="al_descr = '$descr',";
		}
		if(isset($edit['rules'])) {
			$rules = protect($edit['rules'], "bbcode");
			$sql.="al_rules = '$rules',";
		}
		if(isset($edit['diplo'])) {
			$diplo = protect($edit['diplo'], "bbcode");
			$sql.="al_diplo = '$diplo',";
		}
		
		$sql = substr($sql, 0, strlen($sql) - 1);
	
		$sql.=" WHERE al_aid = $alid";
		self::$__sql->query($sql);
		
		return self::$__sql->affected_rows();
	}

	public static function add($mid,$nom)/* création nouvelle alliance */
	{
		self::init();

		$mid = protect($mid, "uint");
		$nom = protect($nom, "string");
	
		$sql="INSERT INTO ".self::$__sql->prebdd."al VALUES ('','$nom','$mid','0','1','1','','', '')";
		self::$__sql->query($sql);
	
		$aid = self::$__sql->insert_id();
	
		$im = imagecreatefrompng(ALL_LOGO_DIR.'0.png');
		imagepng($im, ALL_LOGO_DIR."$aid.png");
		self::make_thumb($aid,imagesx($im),imagesy($im));
	
		return $aid;
	}
	
	public static function del($alid)
	{
		self::init();

		$rows = 0;
		$alid = protect($alid, "uint");
	
		$sql = "DELETE FROM ".self::$__sql->prebdd."al_shoot WHERE shoot_aid = '$alid'";
		self::$__sql->query($sql); $rows += self::$__sql->affected_rows();
	
		$sql = "DELETE FROM ".self::$__sql->prebdd."al_res WHERE ares_aid = '$alid'";
		self::$__sql->query($sql); $rows += self::$__sql->affected_rows();
	
		$sql = "DELETE FROM ".self::$__sql->prebdd."al_res_log WHERE arlog_aid = '$alid'";
		self::$__sql->query($sql); $rows += self::$__sql->affected_rows();
	
		$sql = "DELETE FROM ".self::$__sql->prebdd."al WHERE al_aid = '$alid'";
		self::$__sql->query($sql); $rows += self::$__sql->affected_rows();
	
		$rows += Ambr::del($alid);
	
		return $rows;
	
	}
	
	public static function upload_logo($alid, $fichier)
	{
		self::init();
		$alid = protect($alid, "uint");
	
		$fichier = protect($fichier, "array");
	
		$nom = protect($fichier['name'], "string");
		$taille = protect($fichier['size'], "uint");
		$tmp = protect($fichier['tmp_name'], "string");
		$type = protect($fichier['type'], "string");
		$erreur = protect($fichier['error'], "string");
	
		if($erreur)
			return $erreur;
	
		if($taille > ALL_LOGO_SIZE OR !strstr(ALL_LOGO_TYPE, $type))
			return false;
		
		$nom_destination = ALL_LOGO_DIR.$alid.'.png';
		move_uploaded_file($tmp, $nom_destination);
		list($width, $height, $type, $attr) = getimagesize(ALL_LOGO_DIR.$alid.'.png');
		if($width <= ALL_LOGO_MAX_X_Y AND $height <= ALL_LOGO_MAX_X_Y)
			return self::make_thumb($alid,$width,$height);
		else
		{
			$owidth = $width;
			$oheight= $height;
			$rap = $width / $height;
			$width = round(($width == $height) ? ALL_LOGO_MAX_X_Y : (($width > $height) ? ALL_LOGO_MAX_X_Y : ALL_LOGO_MAX_X_Y * $rap));
			$height = round($width / $rap);
		
			$im1 = imagecreatefrompng($nom_destination);	
			$im2 = imagecreatetruecolor ($width, $height);
			imagecopyresized ( $im2, $im1, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
			imagepng($im2,ALL_LOGO_DIR.$alid.'.png');
		
			return self::make_thumb($alid,$width,$height);
		}
	}

	public static function make_thumb($alid,$owidth,$oheight)
	{
		self::init();
		$alid = protect($alid, "uint");
		$logo = ALL_LOGO_DIR.$alid.'.png';
		$owidth = protect($owidth, "uint");
		$oheight = protect($oheight, "uint");
		$width = 20;
		$height = 20;
	
		$image_p = imagecreatetruecolor($width, $height);
		$image = imagecreatefrompng($logo);
		$col = imagecolorallocatealpha($image_p, 255,255,255,255);
		imagecolortransparent($image_p, $col);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0,$width, $height, $owidth, $oheight);
		return imagepng($image_p, ALL_LOGO_DIR.$alid.'-thumb.png');	
	}
}
