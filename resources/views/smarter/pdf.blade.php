<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		*{
			font-size: 20px !important;
		}
		h1{
			font-size: 32px !important;
		}
		.thead-dark{
			font-size: 24px !important;
		}
		table.noborder,table.noborder *{
			border: none !important;
		}
	</style>
</head>
<body style="padding: 50px;">
	<div class="row">
		<div class="col-6">
			<img src="/assets/img/90x90.jpg" width="80">
		</div>
		<div class="col-6 text-right"><h2 class="mt-4">speek.in</h2></div>
	</div>
	<hr>
	<h1 class="my-5 text-center">Hasil Keputusan Metode SMARTER</h1>
    <table class="table table-bordered table-striped" width="100%">
    	<thead class="thead-dark text-center fuz-th">
			<tr>
				<th>#</th>
				<th>Nama</th>
				<th>Nilai Akhir (%)</th>
				<th>Hasil Keputusan</th>
			</tr>
		</thead>
		<tbody>
			{!! $content !!}
		</tbody>
   	</table>
</body>
<script type="text/javascript">
	window.print();
</script>
</html>