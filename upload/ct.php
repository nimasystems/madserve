<?php

//setcookie('testc', '12345', time() + 1024 * 60 * 60, '/', '.madserve.dev.bgmiracle.com');


 $c = $_COOKIE;

var_dump($c);

//var_dump($_SERVER);


?>
<html>
<head></head>
<body>
	<script type="text/javascript">
function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; path=/; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}
setCookie('testc', 'xxyyzzAAA', 123);
alert('set');
</script>
</body>
</html>