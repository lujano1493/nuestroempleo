<?php  
/** 
 * This is a component to send email from CakePHP using PHPMailer 
 * @link http://bakery.cakephp.org/articles/view/94 
 * @see http://bakery.cakephp.org/articles/view/94 
 */ 
App::uses('Component', 'Controller');

class EmailerPHPComponent   extends Component
{ 
  /** 
   * Send email using SMTP Auth by default. 
   */ 
    public $from         = 'registro_ne1@nuestroempleo.com.mx'; 
    public $fromName     = "Registro nuestro Empleo"; 
    public $smtpUserName = 'registro_ne1@nuestroempleo.com.mx';  // SMTP username 
    public $smtpPassword = 'Hg48Y535D7B9'; // SMTP password 
    public $smtpHostNames= "mail.nuestroempleo.com.mx";  // specify main and backup server 
    public $Port        =   25;

    public $text_body = null; 
    public $html_body = null; 
    public $to = null; 
    public $toName = null; 
    public $subject = null; 
    public $cc = null; 
    public $bcc = null; 
    public $template = 'email/default'; 
    public $attachments = null; 

    public $controller; 

    function startup(Controller $controller ) { 
      $this->controller = &$controller; 
    } 

    function bodyText() { 
    /** This is the body in plain text for non-HTML mail clients 
     */ 
      ob_start(); 
      $temp_layout = $this->controller->layout; 
      $this->controller->layout = '';  // Turn off the layout wrapping 
      $this->controller->render($this->template . '_text');  
      $mail = ob_get_clean(); 
      $this->controller->layout = $temp_layout; // Turn on layout wrapping again 
      return $mail; 
    } 

    function bodyHTML() { 
    /** This is HTML body text for HTML-enabled mail clients 
     */ 
      // ob_start(); 
      // $temp_layout = $this->controller->layout; 
      // $this->controller->layout = 'email';  //  HTML wrapper for my html email in /app/views/layouts 
      // $this->controller->render("/Emails/html/activar_candidato","Emails/html/default");  
      // $mail = ob_get_clean(); 
      $mail=  "we like party :)";
      // $this->controller->layout = $temp_layout; // Turn on layout wrapping again 
      return $mail; 
    } 

    function attach($filename, $asfile = '') { 
      if (empty($this->attachments)) { 
        $this->attachments = array(); 
        $this->attachments[0]['filename'] = $filename; 
        $this->attachments[0]['asfile'] = $asfile; 
      } else { 
        $count = count($this->attachments); 
        $this->attachments[$count+1]['filename'] = $filename; 
        $this->attachments[$count+1]['asfile'] = $asfile; 
      } 
    } 


    function send() 
    { 
    require(ROOT . DS .'vendor'.DS.'PHPMailer' . DS . 'class.phpmailer.php');      
    $mail = new PHPMailer(); 

    $mail->IsSMTP();            // set mailer to use SMTP 
    $mail->SMTPAuth = true;     // turn on SMTP authentication 
    $mail->Host   = $this->smtpHostNames; 
    $mail->Username = $this->smtpUserName; 
    $mail->Password = $this->smtpPassword; 
    $mail->Port = $this->Port; 

    $mail->From     = $this->from; 
    $mail->FromName = $this->fromName; 
    $mail->AddAddress($this->to, $this->toName ); 
    $mail->AddReplyTo($this->from, $this->fromName ); 

    $mail->CharSet  = 'UTF-8'; 
    $mail->WordWrap = 50;  // set word wrap to 50 characters 

    if (!empty($this->attachments)) { 
      foreach ($this->attachments as $attachment) { 
        if (empty($attachment['asfile'])) { 
          $mail->AddAttachment($attachment['filename']); 
        } else { 
          $mail->AddAttachment($attachment['filename'], $attachment['asfile']); 
        } 
      } 
    } 

    $mail->IsHTML(true);  // set email format to HTML 

    $mail->Subject = $this->subject; 
    $mail->Body    = $this->bodyHTML(); 
    // $mail->AltBody = $this->bodyText(); 

    $result = $mail->Send(); 

    if($result == false ) $result = $mail->ErrorInfo; 

    return $result; 
    } 
} 
?>