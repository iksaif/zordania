<?php
/* bot IRC basé sur la classe SmartIRC */

class bot{

	var $channel;
	var $logfile;
	var $log;
	var $irc; //net_smartirc object

	var $questions; // quizz
	var $quiz = 0;
	var $questionEnCours = -1;
	var $questionPosee = 0;
	var $highscore;
	var $questionTime;

	function bot($channel, &$irc){
		$this->channel = $channel;
		$this->irc = &$irc;
		$this->logfile = SITE_DIR .'logs/irc/log_irc_'.date("Y_m_d").'.log';
		$this->log = new log($this->logfile, false, false); //On ouvre la gestion des logs
	}

    function channel_test(&$irc, &$data)
    {
        $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $data->nick.': I dont like tests!');
    }

    function query_test(&$irc, &$data)
    {
        // result is send to #smartirc-test (we don't want to spam #test)
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#smartirc-test', $data->nick.' said "'.$data->message.'" to me!');
        $irc->message(SMARTIRC_TYPE_QUERY, $data->nick, 'I told everyone on #smartirc-test what you said!');
    }

    function op_list(&$irc, &$data)
    {
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#smartirc-test', 'ops on this channel are:');
        
        $oplist = '';
        // Here we're going to get the Channel Operators, the voices and users
        // Method is available too, e.g. $irc->channel['#test']->users will
        // Return the channel's users.
        foreach ($irc->channel[$data->channel]->ops as $key => $value) {
            $oplist .= ' '.$key;
        }
        
        // result is send to #smartirc-test (we don't want to spam #test)
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#smartirc-test', $oplist);
    }

    function kick(&$irc, &$data)
    {
        // we need the nickname parameter
        if(isset($data->messageex[1])) {
	        if (strtolower($data->messageex[1]) == strtolower($irc->_nick))
 	           $irc->message( $data->type, $data->nick, 'Héhé, pas fou le bot! Je ne me kick pas :p ' );
			else if(!array_key_exists($data->nick, $irc->channel[$data->channel]->ops))
 	           $irc->message( $data->type, $data->nick, 'hum... T\'es pas op, mec, j\'obéis pas à n\'importe qui.' );
			else if(!array_key_exists($irc->_nick, $irc->channel[$data->channel]->ops))
 	           $irc->message( $data->type, $data->nick, 'Je voudrais bien kick '.$data->messageex[1].' mais je ne suis pas op!');
			else{
				$msg = $data->messageex; //[1]=nick [0]=!kick
				array_shift($msg);
	            $nickname = array_shift($msg);
				$reason = (!empty($msg) ? implode(' ', $msg) : $nickname);
    	        $irc->kick($data->channel, $nickname, $reason);
			}
        } else {
            $irc->message( $data->type, $data->nick, 'wrong parameter count' );
            $irc->message( $data->type, $data->nick, 'usage: !kick $nickname' );
        }
    }

    function onjoin_greeting(&$irc, &$data)
    {
        // if _we_ join, don't greet ourself, just jump out via return
        if ($data->nick == $irc->_nick)
            return;
        
        // now check if this is the right channel
        if ($data->channel == $this->channel)
            // it is, lets greet the joint user
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'hi '.$data->nick);
    }

	/*
	* fonctions concernant le QUiZZ
	*/
	function quizz_start(&$irc, &$data){
		if($this->quiz == 0)
		{
			$this->quiz = 1;
			$this->questionEnCours = 0;
			$this->questionPosee = 0;
			$this->highscore = array();
			$this->questionTime = time()+15;

            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'Un quiz a été lancé ! Tentez de répondre aux questions pour être le meilleur !');
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'Vous disposez de 30 secondes pour répondre.');
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'Que le meilleur perde');
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'Départ dans 15 secondes...');
			/* préparer les questions */
			$file = file_get_contents(SITE_DIR .'/templates/fr_FR/commun/question.tpl'); // On lit le fichier des questions dans une chaîne.
			$this->questions = explode("\n",$file); // On sépare chaque ligne (\n est le caractère signifiant une nouvelle ligne).
			// On sépare la question et la réponse :
			for($i=0;isset($this->questions[$i]);$i++)
				$this->questions[$i] = explode('<|#()#|>',$this->questions[$i]);
			shuffle($this->questions); // on mélange
		}
		else
            $irc->message(SMARTIRC_TYPE_NOTICE, $data->nick, 'Un quiz est déjà lancé -_-');

	}

	function quizz_stop(&$irc, &$data){
		if($this->quiz == 1){
			// fin du quizz
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, 'Le quiz est terminé ! Classement : ');
            $irc->message(SMARTIRC_TYPE_CHANNEL, $this->channel, $this->quizz_calcul_classement());
			$quiz = 0;
		}
	}

	function quizz_question(&$irc, &$data){
		// pose une question du quizz
	}

	function quizz_reponse(&$irc, &$data){
		// bonne réponse au quizz
	}

	function quizz_classement(&$irc, &$data){
		// annoncer le classement du quizz
		if($quiz == 1)
            $irc->message(SMARTIRC_TYPE_NOTICE, $data->nick,  'Classement : '.$this->quizz_calcul_classement());
		else
            $irc->message(SMARTIRC_TYPE_NOTICE, $data->nick, 'Il n\'y a aucun quiz de lancé...');
	}

	function quizz_calcul_classement() {
		$classement = '';
		arsort($this->highscore);
		$nicks = array_keys($this->highscore);
		for($i = 0;$i < count($this->highscore);$i++)
		{
			$classement .= "$place. ".$nicks[$i]." (".$this->highscore[$nicks[$i]].") ";
		}
		return $classement;
	}

    function saytime_once(&$irc)
    {
        global $saytime_once_id;// /!\ variable globale
        $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, '(once) the time is: '.date('H:i:s'));
        $irc->unregisterTimeid($saytime_once_id);
    }
    
    function saytime(&$irc)
    {
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#smartirc-test', 'the time is: '.date('H:i:s'));
    }
    
    function quit(&$irc, &$data)
    {
        $irc->quit("time to say goodbye...");
    }

    function logging(&$irc, &$data)
    {

        if ($data->channel == $this->channel){
			$logfile = SITE_DIR .'logs/irc/log_irc_'.date("Y_m_d").'.log';
			if($this->logfile != $logfile) { // nouveau jour nouveau log
				$this->logfile = $logfile;
				unset($this->log);
				$this->log = new log($this->logfile, false, false);
			}
			$this->log->text('['.date('H:i:s').'] '.$data->nick.' : '.$data->message);
	        $irc->message(SMARTIRC_TYPE_CHANNEL, '#smartirc-test', '['.date('H:i:s').'] '.$data->nick.' : '.$data->message);
		}
    }

}
?>
