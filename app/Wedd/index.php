<style>
    #canvas_container {
        /* top:0;
        /* overflow: auto; */ 
        /* position: absolute; */
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        text-align: center;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<title>Invitation</title>
<link rel="stylesheet" href="lib/bootstrap-5.0.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style/custom.css?no=<?php echo base64_encode(date("mdyHis")); ?>">
<script src="lib/js/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.550/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.550/pdf.worker.min.js"></script>
</head>
<body class="body-content">
<?php
if($_SERVER['REQUEST_METHOD'] == "GET"){
    $Idx = htmlspecialchars(trim($_GET['to']), ENT_QUOTES, "UTF-8");
}
else{
	$Idx = "";
}
?>
<section class="vh-100 gradient-custom">
    <div id="content">
		<div id="canvas_container">
			<canvas id="pdf_renderer" data-file="src/Cover2.pdf"></canvas>
		</div>
	</div>
	<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="Modal-View" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="col-md-12" style="text-align:center;">
					<p><strong>Kepada Bapak/Ibu/Saudara:</strong></p>
					<p><strong><?php echo $Idx; ?></strong></p>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">&nbsp;Close&nbsp;</button>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="lib/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
<script>
$(document).ready(function(){
	$('#myModal').modal('show');
	var myState = {
			pdf: null,
			currentPage: 1,
			zoom: 1.3
		}
	var x = '';
	var pageNum = 1;
	const canvas = document.getElementById('pdf_renderer');
	const url = $(canvas).data("file");
	pdfjsLib.getDocument(url).then((pdf) => {

		myState.pdf = pdf;
		render(canvas,url,myState);
		x = pdf.numPages;
		var i = 1;   
	});
});
function render(canvas,url,myState) {
	myState.pdf.getPage(myState.currentPage).then((page) => {
		
		var data = canvas;
		var ctx = canvas.getContext('2d');

		var viewport = page.getViewport(myState.zoom);

		canvas.width = viewport.width;
		canvas.height = viewport.height;
	
		page.render({
			canvasContext: ctx,
			viewport: viewport
		});
	});
}
</script>