<?php
// jQuery File Tree Plugin
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// Visit http://abeautifulsite.net/notebook.php?article=58 for more information
//
// Usage: $('.fileTreeDemo').fileTree( options, callback )
//
// Options:  root           - root folder to display; default = /
//           script         - location of the serverside AJAX file to use; default = file_manager.php
//           folderEvent    - event to trigger expand/collapse; default = click
//           expandSpeed    - default = 500 (ms); use -1 for no animation
//           collapseSpeed  - default = 500 (ms); use -1 for no animation
//           expandEasing   - easing function to use on expand (optional)
//           collapseEasing - easing function to use on collapse (optional)
//           multiFolder    - whether or not to limit the browser to one subfolder at a time
//           loadMessage    - Message to display while initial tree loads (can be HTML)
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// TERMS OF USE
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//



//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//

function get_dir( $dir, $and=array() )
{
	if ( ! file_exists($dir) ) return 'lost';
	if ( ! is_readable($dir) ) return 'deny';
	
	$items = scandir($dir);
	foreach ($items as $item)
	{
		if ( preg_match('/^\./', $item) ) continue;

		$fullpath = rtrim($dir, '/') . '/' . $item;
		if ( is_dir($fullpath) )
		{
			if ( ! empty($and['recursive']) ) $a[$item] = get_dir($fullpath, $and);
			else $a[$item] = array();
		}
		else
		{
			$a[] = $item;
		}
	}
	return $a;
}
$a = get_dir( $_REQUEST['dir'], array('recursive' => 1) );
echo '<pre>' . print_r($a, 1) . '</pre>';
die;


#$root = '';
#$_POST['dir'] = urldecode($_POST['dir']);

#if( file_exists($root . $_POST['dir']) ) {
	#$files = scandir($root . $_POST['dir']);
	#natcasesort($files);
	if( count($files) > 2 ) { // The 2 accounts for . and ..
		echo "<ul class=\"file_manager\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) ) {
				echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
			}
		}
		// All files
		foreach( $files as $file ) {
			if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
			}
		}
		echo "</ul>";	
	}
#}

?>