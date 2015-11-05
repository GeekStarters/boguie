<? session_start();
require_once("includes/main.inc.php");

session_destroy();
header("Location: index.php");
exit;
?>