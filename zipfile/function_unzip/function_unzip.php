<?php



  function unzipFile($filename, $destination_folder) {
  
	/*========================================================
	|
	| unzip files using SimpleUnzip
	|
	| License: Use it, copy it, but leave my copyright where it is, 
	| otherwise, create your own code, thank you!
	|
	| coded by Vladimir Ghetau (c) 2007 pixeltomorrow.com
	|
	|
	|
	| http://www.vladimir.pixeltomorrow.com
	| 
	| 
	| 
	| usage:
	|
	|  if (@function_exists('gzinflate')) { 
	| 
	|     $filename = 'uploads/zipped.zip';
	|     $destionation_folder = 'unzipped/';
	|     require_once ('unzip.lib.php');
	|     unzipFile($filename, $destination_folder);
	|
	|  } else {
	| 
	|     die ('gzinflate() is missing!');
	|
	|  }
	|
	|
	| Enjoy!
	|
	|
	========================================================*/

                                                    
        if ($filename == '') die ('Please enter a file name first of all!');
    
        if ($destination_folder == '') die ('The path you specified is empty!');
    
        if (substr($destination_folder, -1) != '/') {
                                                          
            $destination_folder = $destination_folder .'/';
                                                          
        }
                                                          
                                                          
     $vzip = new SimpleUnzip($filename);

          foreach ($vzip->Entries as $extr) {
          
              $path = $extr->Path;
              $path_folder = explode ('/', $path);
              $new_path = '';
              
                  foreach ($path_folder as $folder) {
                  
                      $new_path .= $folder .'/'; 
                  
                      $to_create = $destination_folder . $new_path;
                      
                          if (substr($to_create, -1) == '/') {
                          
                            $to_create = substr($to_create, 0, strlen($to_create)-1);
                          
                          }
                      
                      @mkdir($to_create, 0777);
                  
                  }
          
              $new_path = '';
              $filev = fopen ($destination_folder. $extr->Path .'/'. $extr->Name, 'w');
              fwrite ($filev, $extr->Data);
              fclose ($filev);
                                                        
          }
          
                                                         

  }


?>
