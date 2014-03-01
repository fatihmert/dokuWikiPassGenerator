<?php
$filename = dirname('.') . $_SERVER['PHP_SELF'];

if (isset($_GET['download-source'])) {
    header("Content-type: application/force-download");
    $file = fopen(__FILE__, 'r');
    $content = fread($file, filesize(__FILE__));
    print $content;
    die();
}
?>

<html>
<head>
<title>DokuWiki Password Generator</title>
</head>
<body>
<center>
<h1>DokuWiki Password Generator</h1>
<h2>

<?php
if (isset($_POST['pass1']) and isset($_POST['pass2'])) {
    # In case of submitting the form.

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 == '' and $pass2 == '') {
	echo 'No password provided.';

    } else if ($pass1 == $pass2) {
	$password = $pass1;
	$salt = md5(uniqid(rand(), true));
	$encrypted = crypt($password, '$1$'.substr($salt, 0, 8).'$');
	echo 'The generated hash is: " <tt>' . $encrypted . '</tt> "';

    } else {
	echo 'The provided passwords are not identical.';
    }
}
?>

</h2>
<a href="http://wiki.splitbrain.org/wiki:dokuwiki">Dokuwiki</a> 2005-07-13 
doesn't provide an interface to the user to change his/her
initial random-generated password.  This script is meant to provide that
interface and it only works with the (default) smd5 crypt method.<br><br>
You need to replace the originally generated hash with the hash value
provided by this script.  More specifically you need to edit 
<tt>&lt;your_docuwiki_root&gt;/conf/users.auth.php</tt> and replace the second
field between your user name and your real name with the generated hash.<br><br>
<form method="post" action="<?php echo $filename; ?>">
<table>
<tr><td>Please provide your password:<td><input type="password" name="pass1"><br>
<tr><td>Confirm your password:<td><input type="password" name="pass2"><br>
</table>
<input type="submit">
</form>
<hr>
DokuWiki Password Generator is created by <a href="http://laci.monda.hu">
László Monda</a><br>
[ <a href="<?php echo $PHP_SELF;?>?download-source=true">Download source code</a> ]
</center>
</body>
