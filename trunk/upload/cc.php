<?php

if (isset($_GET['f']) && $_GET['f'] == 1) {
	setcookie('good_test', 'CVETE', time() + 1024 * 60 * 60, '/', null);
}


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
//setCookie('testd', 'MARTIN 123', 123);
//alert('set');
<?php 
if (isset($_GET['f']) && $_GET['f'] == 1) { ?> alert('set'); <?php }
?>
</script>
</body>
</html>
