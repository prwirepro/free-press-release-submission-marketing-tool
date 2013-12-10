<?php
/*
Plugin Name: Free Press Release Submission & Distribution
Description: Free Press Release Submission & Distribution from PR Wire Pro
Author: PR Wire Pro
Author URL: http://prwirepro.com/wordpress/marketing/free-wordpress-press-release-submit-marketing
*/

$pw_settings_page;
class PRWirePro{
	public $options;
	public function __construct(){
		$this->options = get_option('ydl_options');
		$this->ydlRegisterSettingsNFields();
	}
	public  function prwireproAddOptionPage(){
		global $pw_settings_page;
		$pw_settings_page = add_menu_page ('PR Wire Pro','PR Wire Pro','administrator',basename(__FILE__),array('PRWirePro','ydlOptionPageContent'));
		
	}

	public  function ydlOptionPageContent(){
?>		<a href="http://prwirepro.com"><img style='margin-top:10px;' src='assets/prwirepro-plugin-header.png' /></a>

	<div class="wrap">

		<?php screen_icon(); ?>
		<h2> PR Wire Pro Settings </h2>
		<form method='post' action='<?php echo admin_url().'admin.php?page=prwirepro-plugin.php'; ?>' enctype="multipart/form-data" >
			<?php settings_fields('ydl_options'); 
				  do_settings_sections(basename(__FILE__));	
			?>
			<p class='submit'>
				<input name='submit' class='button-primary' type='submit' value="Submit Press Release" />
			</p>
		</form>
			<a href="http://prwirepro.com"><img src='assets/prwirepro-plugin-footer.png' /></a>

	</div>
<?php
	}
	public  function ydlRegisterSettingsNFields(){
		register_setting( 'ydl_options', 'ydl_options');
		add_settings_section('ydl_main_section',"PR WIRE PRO | Free Press Release Submission",array($this,'ydlSettingSecHandler') , basename(__FILE__) ); 
		add_settings_field('prwirepro_email_address',"Email Address", array($this,'prwirepro_email_address'),basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_confirm_email_address',"Confirm Email Address", array($this,'prwirepro_confirm_email_address'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_username',"Username", array($this,'prwirepro_username'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_password',"Password", array($this,'prwirepro_password'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_password',"Password", array($this,'prwirepro_password'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_pressrealasetitle',"Press Release Title", array($this,'prwirepro_pressrealasetitle'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_pressrealasebodycontent',"Press Release Body Content", array($this,'prwirepro_pressrealasebodycontent'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_pressrealasekitpage',"(Optional) Link to external pdf or url of a Press Kit Page", array($this,'prwirepro_pressrealaseurls'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_pressrealaseslideshare',"(Optional) Link to Slideshare Content To embed in bottom of the press release body", array($this,'prwirepro_pressrealaseslideshare'), basename(__FILE__), 'ydl_main_section');
		add_settings_field('prwirepro_pressrealasefile',"Your Press Release in zip or pdf format", array($this,'prwirepro_pressrealasefile'), basename(__FILE__), 'ydl_main_section');
	}
	public function ydlSettingSecHandler(){
		//optional
	}
	public function ydlVideoSecHandler(){

	}
	public  function prwirepro_email_address(){
		echo "<input name='ydl_options[prwirepro_email_address]' type='text' value='{$this->options['prwirepro_email_address']}' />";
	}
	public  function prwirepro_confirm_email_address(){
		echo "<input name='ydl_options[prwirepro_confirm_email_address]' type='text' value='{$this->options['prwirepro_confirm_email_address']}' />";
	}
	public  function prwirepro_username(){
		echo "<input name='ydl_options[prwirepro_username]' type='text' value='{$this->options['prwirepro_username']}' />";
	}
	public  function prwirepro_password(){
		echo "<input name='ydl_options[prwirepro_password]' type='password' value='{$this->options['prwirepro_password']}' />";
	}
	public  function prwirepro_pressrealasetitle(){
		echo "<input name='ydl_options[prwirepro_pressrealasetitle]' type='text' value='{$this->options['prwirepro_pressrealasetitle']}' />";
	}
	public  function prwirepro_pressrealasebodycontent(){
		echo "<textarea name='ydl_options[prwirepro_pressrealasebodycontent]' cols='100' rows='10'> </textarea>";
	}
	public  function prwirepro_pressrealaseurls(){
		echo "<textarea name='ydl_options[prwirepro_pressrealaseurls]' cols='100' rows='10'> </textarea>";
	}
	public  function prwirepro_pressrealasekitpage(){
		echo "<input type='text' name='ydl_options[prwirepro_pressrealasekitpage]' />";
	}
	public  function prwirepro_pressrealaseslideshare(){
		echo "<input type='text' name='ydl_options[prwirepro_pressrealaseslideshare]' />";
	}
	public  function prwirepro_pressrealasefile(){
		echo "<input type='file' name='ydl_options[prwirepro_pressrealasefile]' />";
	}
	
}
add_action('admin_menu', 'yCallBack' );
add_action('admin_init','yldAdminInit');
function yldAdminInit(){
	new PRWirePro();
}
function yCallBack(){
	PRWirePro::prwireproAddOptionPage();
}
if(isset($_POST['ydl_options'])){
	$to='submission@prwirepro.com';
	$from= '';
	$subject='Below is the information send from the PR Wire Pro';
	$message ='';
	if(!empty($_POST['ydl_options']['prwirepro_email_address'])){
		$message.= 'Email Address :'.$_POST['ydl_options']['prwirepro_email_address']."<br/>";
		$from = $_POST['ydl_options']['prwirepro_email_address'];
	}
	if(!empty($_POST['ydl_options']['prwirepro_username'])){
		$message.= 'Username :'.$_POST['ydl_options']['prwirepro_username']."<br/>";

	}
	if(!empty($_POST['ydl_options']['prwirepro_password'])){
		$message.= 'Password :'.$_POST['ydl_options']['prwirepro_password']."<br/>";
	}
	if(!empty($_POST['ydl_options']['prwirepro_pressrealasetitle'])){
		$message.= 'Press Release Title :'.$_POST['ydl_options']['prwirepro_pressrealasetitle']."<br/>";

	}
	if(!empty($_POST['ydl_options']['prwirepro_pressrealasebodycontent'])){
		$message.= 'Press Release Body Content :'.$_POST['ydl_options']['prwirepro_pressrealasebodycontent']."<br/>";
	}
	if(!empty($_POST['ydl_options']['prwirepro_pressrealaseurls'])){
		$message.= 'Press Release Urls :'.$_POST['ydl_options']['prwirepro_pressrealaseurls']."<br/>";

	}
	if(!empty($_POST['ydl_options']['prwirepro_pressrealasekitpage'])){
		$message.= 'Press Release Kit pages :'.$_POST['ydl_options']['prwirepro_pressrealasekitpage']."<br/>";

	}
	if(!empty($_POST['ydl_options']['prwirepro_pressrealaseslideshare'])){
		$message.= 'Press Release Slideshare Url :'.$_POST['ydl_options']['prwirepro_pressrealaseslideshare']."<br/>";

	}
	if(isset($_FILES['ydl_options']) && $_FILES['ydl_options']['error']['prwirepro_pressrealasefile'] ==0 ){
		$file = $_FILES['ydl_options']['tmp_name']['prwirepro_pressrealasefile'];
		$fileatt = $_FILES['ydl_options']['type']['prwirepro_pressrealasefile'];
		$fileName = $_FILES['ydl_options']['name']['prwirepro_pressrealasefile'];
	}
	if(isset($file) && isset($fileatt) && isset($fileName)){
		mail_file($to,$subject,$message,$from,$file,$fileatt,$fileName);
	}else{
		mail_file($to,$subject,$message,$from);
	}
}
  function mail_file( $to, $subject, $messagehtml, $from,$fileWithPath='', $fileatt='',$fileName='', $replyto="" ) {
            
			// handles mime type for better receiving
            $ext = strrchr( $fileatt , '.');
            $ftype = $fileatt;
            /*if ($ext == ".doc") $ftype = "application/msword";
            if ($ext == ".jpg") $ftype = "image/jpeg";
            if ($ext == ".jpg") $ftype = "image/jpeg";
            if ($ext == ".gif") $ftype = "image/gif";
            if ($ext == ".zip") $ftype = "application/zip";
            if ($ext == ".pdf") $ftype = "application/pdf";*/
            if ($ftype=="") $ftype = "application/octet-stream";
        // read file into $data var
			if(!empty($fileWithPath)){
				$file = @fopen($fileWithPath, "rb");
	  
				$data = @fread($file,  filesize( $fileWithPath ) );
				@fclose($file);

				// split the file into chunks for attaching
				$content = @chunk_split(base64_encode($data));
				$uid = @md5(uniqid(time()));
			}
            // build the headers for attachment and html
            $h = "From: $from\r\n";
            if ($replyto) $h .= "Reply-To: ".$replyto."\r\n";
            $h .= "MIME-Version: 1.0\r\n";
            $h .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
            $h .= "This is a multi-part message in MIME format.\r\n";
            $h .= "--".$uid."\r\n";
            $h .= "Content-type:text/html; charset=iso-8859-1\r\n";
            $h .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $h .= $messagehtml."\r\n\r\n";
			if(!empty($fileWithPath)){
				$h .= "--".$uid."\r\n";
				$h .= "Content-Type: ".$ftype."; name=\"".$fileName."\"\r\n";
				$h .= "Content-Transfer-Encoding: base64\r\n";
				$h .= "Content-Disposition: attachment; filename=\"".$fileName."\"\r\n\r\n";
				$h .= $content."\r\n\r\n";
				$h .= "--".$uid."--";
				return mail( $to, $subject, strip_tags($messagehtml), str_replace("\r\n","\n",$h) ) ;

			}else{
				// send mail
				return mail( $to, $subject, strip_tags($messagehtml))  ;
	
			}
}