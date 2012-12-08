<?php
#=======================================================================#
#                   Online Inventories by miner345                      #
#         This script works with the Bukkit Plugin InventorySQL         #
#        For more Information and download of InventorySQL visit:       #
#            http://dev.bukkit.org/server-mods/inventorysql/            #
#           Contact: info@miner345.de // http://miner345.de/            #
#                                                                       #
#                Ask me if you want to change something!                #
#                 Do not remove or edit the copyright!                  #
#                                                                       #
#                      (c) 2012 by miner345                             #
#=======================================================================#

#=======================================================================#
#                            Configuration                              #
#                                                 (Edit only this part) #
#=======================================================================#

# MySQL Data of your InventorySQL Database
$host = "localhost";
$username = "name";
$password = "pass";
$database = "inventory";
$table_prefix = "invsql";

# Path to the directory (with http://...) ex: http://your-website.com/inventory/
# Don't forget the "/" at the end please!
$path = "http://yourdomain.de/inventory/";

# Path Settings !Default Configuration!
# Do not need to edit, if you haven't changed anything!
$inventory_picture = "inventory.png";
$item_folder = "items";
$font = "minecraft_font.ttf";
$skin = "skin.php";

#=======================================================================#
#                         End of Configuration                          #
#                                                     (Stop Editing!)   #
#=======================================================================#



# /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\   #
#    Script! Do not edit without asking me!                             #
# /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\   #

header("Content-Type: image/png");

# Hintergrund laden
$img = imagecreatefrompng($inventory_picture);

# Skin laden
$skin = imagecreatefrompng($path.$skin.'?user='.$_GET['user']);

# Verbinden mit MySQL - Datenbank
mysql_connect($host, $username, $password);
mysql_select_db($database);

# Infos (c) ...
$white = imagecolorallocate($img, 255, 255, 255);
imagettftext($img, 7, 0, 180, 20, $white, "./".$font, "copyright 2012 by miner345");

# Skin
imagecopy($img, $skin, 80, 27, 0, 0, 60, 120);

# User finden
$res1 = mysql_query("SELECT * FROM `".$table_prefix."_users` WHERE `name` = '".$_GET['user']."'");
$count1 = mysql_num_rows($res1);
if($count1 != 1){
# Fehlermeldung
	$red = imagecolorallocate($img, 255, 0, 0);
	$black = imagecolorallocate($img, 0, 0, 0);
	imagettftext($img, 24, 0, 20, 235, $red, "./".$font, "User not found!");
}
else {
	# User-ID
	$row1 = mysql_fetch_array($res1);
	$userid = $row1[0];
	
	# Inventar - Abfrage
	$res2 = mysql_query("SELECT * FROM `".$table_prefix."_inventories` WHERE `owner` = '".$userid."'");
	
	while($row2 = mysql_fetch_row($res2)){
		$count = $row2[6];
		if($count==1) $count ="";
		if($count<10) $count ="   ".$count;
		$itemid = $row2[3];
		$dataid = $row2[4];
		$fuckindamage = $row2[5];
		
		if($itemid>=256 and $itemid<=259 || $itemid==261 || $itemid>=267 and $itemid<=279 || $itemid>=283 and $itemid<=286 || $itemid>=290 and $itemid<=291 ||  $itemid>=298 and $itemid<=317 || $itemid==398){
			if(file_exists($item_folder.'/'.$itemid.'.png')){
				$itempath = $item_folder.'/'.$itemid.'.png';
			}
			else{
				$itempath = $item_folder.'/error.png';
			}
		}
		elseif($dataid == 0){
			if(file_exists($item_folder.'/'.$itemid.'.png')){
				$itempath = $item_folder.'/'.$itemid.'.png';
			}
			else{
				$itempath = $item_folder.'/error.png';
			}	
		}
		elseif($itemid == 373){
			$damage=$fuckindamage;
			if(file_exists($item_folder.'/'.$itemid.'-'.$damage.'.png')){
				$itempath = $item_folder.'/'.$itemid.'-'.$damage.'.png';
			}
			else $itempath = $item_folder.'/373-error.png';
		}
		elseif($dataid==$fuckindamage){
			if(file_exists($item_folder.'/'.$itemid.'.png')){
				$itempath = $item_folder.'/'.$itemid.'.png';
			}
			else{
				$itempath = $item_folder.'/error.png';
			}
		}
		else{
			$itempath = $item_folder.'/error.png';
		}
		
		$item = imagecreatefrompng($itempath);
		switch($row2[7]){
			case 0:
				imagecopy($img, $item, 15, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 28, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 27, 327, $white, "./".$font, $count); 
				break;
			case 1:
				imagecopy($img, $item, 53, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 66, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 65, 327, $white, "./".$font, $count); 
				break;
			case 2:
				imagecopy($img, $item, 91, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 104, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 103, 327, $white, "./".$font, $count); 
				break;
			case 3:
				imagecopy($img, $item, 128, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 141, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 140, 327, $white, "./".$font, $count); 
				break;
			case 4:
				imagecopy($img, $item, 166, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 179, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 178, 327, $white, "./".$font, $count); 
				break;
			case 5:
				imagecopy($img, $item, 204, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 217, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 216, 327, $white, "./".$font, $count); 
				break;
			case 6:
				imagecopy($img, $item, 242, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 255, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 254, 327, $white, "./".$font, $count); 
				break;
			case 7:
				imagecopy($img, $item, 279, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 292, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 291, 327, $white, "./".$font, $count); 
				break;
			case 8:
				imagecopy($img, $item, 318, 296, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 331, 328, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 330, 327, $white, "./".$font, $count); 
				break;
			case 9:
				imagecopy($img, $item, 15, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 28, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 27, 205, $white, "./".$font, $count); 
				break;
			case 10:
				imagecopy($img, $item, 53, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 66, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 65, 205, $white, "./".$font, $count); 
				break;
			case 11:
				imagecopy($img, $item, 91, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 104, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 103, 205, $white, "./".$font, $count); 
				break;
			case 12:
				imagecopy($img, $item, 128, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 141, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 140, 205, $white, "./".$font, $count); 
				break;
			case 13:
				imagecopy($img, $item, 166, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 179, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 178, 205, $white, "./".$font, $count); 
				break;
			case 14:
				imagecopy($img, $item, 204, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 217, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 216, 205, $white, "./".$font, $count); 
				break;
			case 15:
				imagecopy($img, $item, 242, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 255, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 254, 205, $white, "./".$font, $count); 
				break;
			case 16:
				imagecopy($img, $item, 279, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 292, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 291, 205, $white, "./".$font, $count); 
				break;
			case 17:
				imagecopy($img, $item, 318, 174, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 331, 206, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 330, 205, $white, "./".$font, $count); 
				break;
			case 18:
				imagecopy($img, $item, 15, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 28, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 27, 243, $white, "./".$font, $count); 
				break;
			case 19:
				imagecopy($img, $item, 53, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 66, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 65, 243, $white, "./".$font, $count); 
				break;
			case 20:
				imagecopy($img, $item, 91, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 104, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 103, 243, $white, "./".$font, $count); 
				break;
			case 21:
				imagecopy($img, $item, 128, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 141, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 140, 243, $white, "./".$font, $count); 
				break;
			case 22:
				imagecopy($img, $item, 166, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 179, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 178, 243, $white, "./".$font, $count); 
				break;
			case 23:
				imagecopy($img, $item, 204, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 217, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 216, 243, $white, "./".$font, $count); 
				break;
			case 24:
				imagecopy($img, $item, 242, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 255, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 254, 243, $white, "./".$font, $count); 
				break;
			case 25:
				imagecopy($img, $item, 279, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 292, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 291, 243, $white, "./".$font, $count); 
				break;
			case 26:
				imagecopy($img, $item, 318, 212, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 331, 244, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 330, 243, $white, "./".$font, $count); 
				break;
			case 27:
				imagecopy($img, $item, 15, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 28, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 27, 281, $white, "./".$font, $count); 
				break;
			case 28:
				imagecopy($img, $item, 53, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 66, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 65, 281, $white, "./".$font, $count); 
				break;
			case 29:
				imagecopy($img, $item, 91, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 104, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 103, 281, $white, "./".$font, $count); 
				break;
			case 30:
				imagecopy($img, $item, 128, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 141, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 140, 281, $white, "./".$font, $count); 
				break;
			case 31:
				imagecopy($img, $item, 166, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 179, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 178, 281, $white, "./".$font, $count); 
				break;
			case 32:
				imagecopy($img, $item, 204, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 217, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 216, 281, $white, "./".$font, $count); 
				break;
			case 33:
				imagecopy($img, $item, 242, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 255, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 254, 281, $white, "./".$font, $count); 
				break;
			case 34:
				imagecopy($img, $item, 279, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 292, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 291, 281, $white, "./".$font, $count); 
				break;
			case 35:
				imagecopy($img, $item, 318, 250, 0, 0, 32, 32);
				imagettftext($img, 10, 0, 331, 282, $black, "./".$font, $count);
				imagettftext($img, 10, 0, 330, 281, $white, "./".$font, $count); 
				break;
			case 100:
				imagecopy($img, $item, 15, 130, 0, 0, 32, 32);
				break;
			case 101:
				imagecopy($img, $item, 15, 93, 0, 0, 32, 32);
				break;
			case 102:
				imagecopy($img, $item, 15, 55, 0, 0, 32, 32);
				break;
			case 103:
				imagecopy($img, $item, 15, 16, 0, 0, 32, 32);
				break;
		}
	}
}

# Ausgabe
imagepng($img);












?>