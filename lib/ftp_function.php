<?php
Class FTP{

		var $System_FTP_Root;
		var $System_FTP_HostName;
		var $System_FTP_UserName;
		var $System_FTP_Password;
		var $System_FTP_Connect;
		var $System_FTP_Result;

		function FTP()
		{
			$this->System_FTP_Root="ewtadmin/";
			$this->System_FTP_HostName='personel.obec.go.th';
			$this->System_FTP_UserName='personel';
			$this->System_FTP_Password='obec6767';
			$this->System_FTP_Connect= ftp_connect($this->System_FTP_HostName);
			$this->System_FTP_Result = ftp_login($this->System_FTP_Connect, $this->System_FTP_UserName, $this->System_FTP_Password);
		}

		function new_mkdir($nfolder){
				$dir = $this->System_FTP_Root.$nfolder;
				if (@ftp_mkdir($this->System_FTP_Connect, $dir)){
						 return 1;
				} else {
						return 0;
				}
		}

		function new_rmdir($nfolder){
				$dir = $this->System_FTP_Root.$nfolder; 
				if (!@ftp_rmdir($this->System_FTP_Connect, $dir)){
					$this->LooPDel($dir);
				}    
		}

		function LooPDel($p){ 
				$contents = ftp_nlist($this->System_FTP_Connect, $p);  //open ftp folder in the given directory
				foreach($contents as $file) {  
						$d=explode('/',$file);
						$dl=$d[sizeof($d)-1];
						if ($dl!='.'&&$dl!='..') {
									 if (!@ftp_delete($this->System_FTP_Connect,$file)) {
										$this->LooPDel($file);
									 } 
						}
				}
				@ftp_rmdir($this->System_FTP_Connect, $p);
		}

		function new_copy($file_Source,$file_Des){
			$dir = $this->System_FTP_Root.$file_Des; 
			@ftp_put($this->System_FTP_Connect, $dir,$file_Source, FTP_ASCII);
		}

		function new_unlink($file_name){
			$dir = $this->System_FTP_Root.$file_name; 
			@ftp_delete($this->System_FTP_Connect, $dir);
		}

		function new_close(){
			ftp_quit($this->System_FTP_Connect);
		}
}
?>
