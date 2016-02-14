<?
class admin
{
	var $conf_file;
	
	function admin($conf_file)
	{
		$this->conf_file = $conf_file;	
	}
	
	function get_admin_page()
	{
		$handle=opendir('modules/');
		while ($file = readdir($handle)) {
		   if ($file != "." && $file != "..") {
		       if(@file_exists("modules/$file/admin.php"))
		       {
		       	$dir[]=$file;
		       	
		       }
		   }
		}
		closedir($handle); 
		return $dir;
	}
}
?>