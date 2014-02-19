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
	function setCookie(c_name,value,expiredays)
	{
	    var exdate=new Date();
	    exdate.setDate(exdate.getDate()+expiredays);
	    document.cookie=c_name+ "=" +escape(value)+
	    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString()+ "; path=/;"); 
	    document.cookie="expiration"+ "=" +escape(exdate.toGMTString())+
	    ((expiredays==null) ? "" : ";expires="+exdate.toGMTString()+ "; path=/;"); 
	}
setCookie('testd', 'MARTIN 123', 123);
alert('set');
</script>
</body>
</html>
