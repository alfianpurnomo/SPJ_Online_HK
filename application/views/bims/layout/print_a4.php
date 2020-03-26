<!DOCTYPE html>
<html lang="en">
	<head>
		<style type="text/css">
			body {
		        margin: 0;
		        padding: 0;
		        background-color: #FAFAFA;
		        font: 10pt "Tahoma";
		    }
		    * {
		        box-sizing: border-box;
		        -moz-box-sizing: border-box;
		    }
		    .page {
		        width: 21cm;
		        min-height: 29.7cm;
		        padding: 2cm;
		        margin: 1cm auto;
		        border: 1px #D3D3D3 solid;
		        border-radius: 5px;
		        background: white;
		        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		    }
		    .subpage {
		        padding: 1cm;
		        border: 5px red solid;
		        height: 256mm;
		        outline: 2cm #FFEAEA solid;
		    }
		    p{
		    	font-size: 12px;
		    }
		    
		    @page {
		        size: A4;
		        margin: 0;
		    }
		    @media print {
		        .page {
		            margin: 0;
		            border: initial;
		            border-radius: initial;
		            width: initial;
		            min-height: initial;
		            box-shadow: initial;
		            background: initial;
		            page-break-after: always;
		        }
		    }
		</style>
	</head>
	<body>
		<?php echo $content;?>
	</body>
</html>