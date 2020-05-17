<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/default_params.php');
    
    class Email
    {
        protected $typeContent;
        protected $expediteurMail;
        protected $returnMail;
        protected $destMail;
        
        protected $contenu;
        protected $sujet;
        
        public function send()
        {
            $mail = $this->destMail; // Déclaration de l'adresse de destination.
            $messageText = defaut_email_HTML($this->contenu);
            if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
	            $passage_ligne = "\r\n";
            else
	            $passage_ligne = "\n";
            
            $boundary = "-----=".md5(rand());
            
            $sujet = $this->sujet;
            
            //=====Création du header de l'e-mail.
            $header = 'From: "'.$this->expediteurMail.'"<'.$this->expediteurMail.'>'.$passage_ligne;
            $header.= 'Reply-to: "'.$this->returnMail.'" <'.$this->returnMail.'>'.$passage_ligne;
            $header.= "MIME-Version: 1.0".$passage_ligne;
            $header.= "Content-Type: multipart/alternative;".$passage_ligne
                   .  ' boundary="'.$boundary.'"'.$passage_ligne;
            
            //=====Création du message.
            $message = $passage_ligne."--".$boundary.$passage_ligne;
            //=====Ajout du message au format HTML
            $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
            $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
            $message.= $passage_ligne.$messageText.$passage_ligne;
            
            $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
            $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
            
            mail($mail,$sujet,$message,$header);
        }
        
        public function __construct($expediteur = "", $destinataire = "", $contenu = "", $envoyer = null)
        {
            $this->expediteurMail = $expediteur;
            $this->returnMail = $expediteur;
            $this->destMail = $destinataire;
            $this->contenu = $contenu;
            
            if ($envoyer)
                $this->send();
        }
        
        public function setExpediteur($var)
        { $this->expediteurMail = $var; }
        
        public function setMailRetour($var)
        { $this->returnMail = $var; }
        
        public function setSubject($var)
        { $this->sujet = $var; }
        
        public function setContent($var)
        { $this->contenu = $var; }
        
        public function setDestMail($var)
        { $this->destMail = $var; }
        
    }
    
?>
