<!DOCTYPE html>
<html>
<head>
	<title>BoomingMart Payment</title>
</head>
<body>
	<center>
	<form method="post" name="redirect" action="{{ $endPoint }}"> 
	
		<input type=hidden name=encRequest value="{{ $encrypted_data }}">
		<input type=hidden name=access_code value="{{ $access_code }}">
	</form>
	</center>
	<script language='javascript'> document.redirect.submit();</script>
</body>
</html>