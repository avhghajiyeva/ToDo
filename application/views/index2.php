<!DOCTYPE html>
<html>
<head>
	<title>403 Forbidden</title>
</head>
<body>
<h1>Test</h1>
<button type="button" name="button" id='btn'>button</button>
<script>
	function salam(){
		// console.log("hello world");
		document.getElementById('id').html('salam');
	}


	$(document).on('click', '#btn', function () {
		salam();
	});
</script>
</body>
</html>
