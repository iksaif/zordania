<?
class stq
{
	var $sql;
	
	//construction
	function stq(&$sql)
	{
		$this->sql = &$sql;
		include(SITE_DIR.'lib/jpgraph/src/jpgraph.php');
		include(SITE_DIR.'lib/jpgraph/src/jpgraph_line.php');
	}

	
	//fonction principale
	function exec()
	{
		$heure =date('H'); $minute = date('i');
		
		$sql="DELETE FROM ".$this->sql->prebdd."ses WHERE ";
		$sql.="ses_ldate < (NOW() - INTERVAL 1500 SECOND)";
		$this->sql->query($sql);
		
		$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."ses WHERE ses_mid != 1";
		$nb_con = mysql_result($this->sql->query($sql), 0);
		$sql="INSERT INTO ".$this->sql->prebdd."con VALUES (NOW(),$nb_con)";
		$this->sql->query($sql);
		
		if($heure == 23 and $minute == 30)
		{
			$sql="SELECT SUM(unt_nb) as sum FROM ".$this->sql->prebdd."unt";
			$res = $this->sql->query($sql);
			$unt_tot = mysql_result($res, 0);
			
			$sql="SELECT COUNT(*) as sum FROM ".$this->sql->prebdd."btc";
			$res = $this->sql->query($sql);
			$btc_tot = mysql_result($res, 0);
				 
			$sql="SELECT COUNT(*) FROM ".$this->sql->prebdd."src";
			$res = $this->sql->query($sql);
			$src_tot = mysql_result($res, 0);
						
			$sql="SELECT SUM(res_nb) FROM ".$this->sql->prebdd."res";
			$res = $this->sql->query($sql);
			$res_tot = mysql_result($res, 0);
			
			$sql="SELECT mbr_etat,COUNT(*) as sum FROM ".$this->sql->prebdd."mbr GROUP BY mbr_etat";
			$mbr_tmp_array = $this->sql->make_array($sql);
			$mbr_array = array();
			foreach($mbr_tmp_array as $key => $value)
			{
				$mbr_array[$value['mbr_etat']] = $value['sum'];
				$mbr_tot += $value['sum'];
			}
			
			$btc_avg = ($btc_tot / $mbr_tot);
			$res_avg = ($res_tot / $mbr_tot);
			$src_avg = ($src_tot / $mbr_tot);
			$unt_avg = ($unt_tot / $mbr_tot);
			
			$sql="SELECT * FROM ".$this->sql->prebdd."con WHERE con_date > ".date('ymd')."0000 LIMIT 24";
			$con_tmp_array = $this->sql->make_array($sql);
			foreach($con_tmp_array as $key => $value)
			{
				$con_array[] = $value['con_nb'];
				$con_tot += $value['con_nb'];
			}
			$con_avg = ceil($con_tot / 24);
			
			$sql="DELETE FROM ".$this->sql->prebdd."con";
			$this->sql->query($sql);
			
			$sql="INSERT INTO ".$this->sql->prebdd."stq VALUES
				('',NOW(),'".$mbr_array[1]."','".$mbr_array[3]."',$con_avg,$unt_tot,$btc_tot,$unt_avg,$btc_avg,$res_avg,$src_avg)";
			$this->sql->query($sql);
			
			/**********Graphique Connectés journalier******************/		 
			// Creation du graphique
			$graph = new Graph(550,400);
			$graph->SetScale('textint');
			
			 // Setup margin and titles
			$graph->img->SetMargin(40,40,40,40);
			$graph->yaxis->title->Set("Connectés/Members Online");
			$graph->xaxis->title->Set("Heure/Time"); 
			$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
			$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
			
			$graph->xaxis->SetTickLabels(array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23));
		
			// Création du système de points
			$lineplot=new LinePlot($con_array);
			$lineplot->SetColor("blue"); 
			$lineplot->SetFillColor('orange');
			// On rajoute les points au graphique
			$graph->Add($lineplot);

			// Affichage
			$graph->Stroke(SITE_DIR."img/stats/mbr_".date("d-m-Y").".png");	
			
			$mois = array('Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aou','Sep','Oct','Nov','Déc');
			$days_in_month = (int) cal_days_in_month(CAL_GREGORIAN, date('n'), date('Y'));
			$day = (int) date('j');
			if($days_in_month == $day)
			{
				$sql="SELECT *,DATE_FORMAT(stq_date,'%d-%m-%y') as stq_dates FROM ".$this->sql->prebdd."stq WHERE stq_date > (NOW() - INTERVAL 1 MONTH)";
				$stq_tmp_array = $this->sql->make_array($sql);
				//print_r($stq_tmp_array);
				foreach($stq_tmp_array as $key => $value)
				{
					$dates[]	    = $value['stq_dates'];
					$res_array['avg'][] = $value['stq_res_avg'];
					$btc_array['avg'][] = $value['stq_btc_avg'];
					$btc_array['tot'][] = $value['stq_btc_tot'];
					$unt_array['tot'][] = $value['stq_unt_tot'];
					$unt_array['avg'][] = $value['stq_unt_avg'];
					$src_array['avg'][] = $value['stq_src_avg'];
					$mbr_array['act'][] = $value['stq_mbr_act'];
					$mbr_array['inac'][]= $value['stq_mbr_inac'];
					$mbr_array['con'][] = $value['stq_mbr_con'];
				}
				
				/**********Graphique Membres Mois***************/
				// Creation du graphique
				$graph = new Graph(550,400);
				$graph->SetScale('textint');
				$graph->SetY2Scale("int");
	
				// Setup margin and titles
				$graph->img->SetMargin(40,40,40,40);
				$graph->yaxis->title->Set("Connectés/Online");
				$graph->y2axis->title->Set("Membres/Members");
				$graph->yaxis->title->SetFont(FF_VERDANA,FS_NORMAL,8);
				$graph->y2axis->title->SetFont(FF_VERDANA,FS_NORMAL,8);
				$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
				$graph->xaxis->SetTickLabels($dates);
				$graph->xaxis->SetLabelAngle(45);
				// membres act/inact
				$p1 = new LinePlot($mbr_array['act']);
				$p2 = new LinePlot($mbr_array['inac']);
				$p1->SetFillColor("red");
				$p2->SetFillColor("blue"); 
				$p1->SetLegend("Actifs");
				$p2->SetLegend("Inactifs");
				$mbrplot = new AccLinePlot(array($p2,$p1)); 
				$graph->AddY2($mbrplot);
		
				// Création du système de points
				$connectplot=new LinePlot($mbr_array['con']);
				$connectplot->SetColor('orange'); 
				$connectplot->SetLegend("Connectés");
				// On rajoute les points au graphique
				$graph->Add($connectplot);
		
				$graph->legend->Pos(0.4,0.95,"center","bottom");
				// Affichage
				$graph->Stroke(SITE_DIR."img/stats/mbr_".date("m-Y").".png");
		
				/****************Graphique ressources mois***************************/		
				// Creation du graphique
				$graph = new Graph(550,400);
				$graph->SetScale('textint');
					
				// Setup margin and titles
				$graph->img->SetMargin(60,50,40,40);
				$graph->title->Set("Moyenne des ressources par joueur.");
				$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
				$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
				$graph->xaxis->SetTickLabels($dates);
				$graph->xaxis->SetLabelAngle(45);
	
				// Création du système de points
				$connectplot=new LinePlot($res_array['avg']);
				$connectplot->SetColor('orange'); 
				// On rajoute les points au graphique
				$graph->Add($connectplot);
		
				// Affichage
				$graph->Stroke(SITE_DIR."img/stats/res_".date("m-Y").".png");
		
				
				/****************Graphique recherches mois***************************/		
				// Creation du graphique
				$graph = new Graph(550,400);
				$graph->SetScale('textint');	
		
				// Setup margin and titles
				$graph->img->SetMargin(60,50,40,40);
				$graph->title->Set("Moyenne des recherches par joueur.");
				$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
				$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
				$graph->xaxis->SetTickLabels($dates);
				$graph->xaxis->SetLabelAngle(45);

				// Création du système de points
				$connectplot=new LinePlot($src_array['avg']);
				$connectplot->SetColor('orange'); 
				// On rajoute les points au graphique
				$graph->Add($connectplot);
		
				// Affichage
				$graph->Stroke(SITE_DIR."img/stats/src_".date("m-Y").".png");
			
	
				/****************Graphique btc mois***************************/		
				// Creation du graphique
				$graph = new Graph(550,400);
				$graph->SetScale('textint');
				$graph->SetY2Scale("int");	
	
				// Setup margin and titles
				$graph->img->SetMargin(60,50,40,40);
				$graph->title->Set("Bâtiments.");
				$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
				$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
				$graph->xaxis->SetTickLabels($dates);
				$graph->xaxis->SetLabelAngle(45);
				$graph->yaxis->SetColor("orange");
				$graph->y2axis->SetColor("blue");	
		
				// Création du système de points
				$connectplot=new LinePlot($btc_array['avg']);
				$connectplot->SetColor('orange'); 
				$connectplot->SetLegend("Moyenne");
				// On rajoute les points au graphique
				$graph->Add($connectplot);		
	
				// Création du système de points
				$connectplot2=new LinePlot($btc_array['tot']);
				$connectplot2->SetColor('blue'); 
				$connectplot2->SetLegend("Total");
				// On rajoute les points au graphique
				$graph->AddY2($connectplot2);



				$graph->legend->Pos(0.4,0.95,"center","bottom");
	
				// Affichage
				$graph->Stroke(SITE_DIR."img/stats/btc_".date("m-Y").".png");


				/****************Graphique unt mois***************************/		
				// Creation du graphique
				$graph = new Graph(550,400);
				$graph->SetScale('textint');
				$graph->SetY2Scale("int");
	
				// Setup margin and titles
				$graph->img->SetMargin(60,50,40,40);
				$graph->title->Set("Unités.");
				$graph->yaxis->title->SetFont(FF_VERDANA,FS_BOLD,8);
				$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7);
				$graph->xaxis->SetTickLabels($dates);
				$graph->xaxis->SetLabelAngle(45);
				$graph->yaxis->SetColor("orange");
				$graph->y2axis->SetColor("blue");

				// Création du système de points
				$connectplot=new LinePlot($unt_array['avg']);
				$connectplot->SetColor('orange'); 
				$connectplot->SetLegend("Moyenne");
				// On rajoute les points au graphique
				$graph->Add($connectplot);
	
				// Création du système de points
				$connectplot2=new LinePlot($unt_array['tot']);
				$connectplot2->SetColor('blue'); 
				$connectplot2->SetLegend("Total");
				// On rajoute les points au graphique
				$graph->AddY2($connectplot2);



				$graph->legend->Pos(0.4,0.95,"center","bottom");
	
				// Affichage
				$graph->Stroke(SITE_DIR."img/stats/unt_".date("m-Y").".png");

				
			}
			
		}
		
		
	}
}
?>
