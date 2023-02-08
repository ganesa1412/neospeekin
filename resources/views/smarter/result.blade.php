<h5>Hasil Keputusan</h5>
<table class="table table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td>#</td>
			<td>Nama</td>
			<td>Nilai Akhir (%)</td>
			<td>Hasil Keputusan</td>
		</tr>
	</thead>
	<tbody id="result">
		
	</tbody>
</table>
<p class="mt-2">
	<svg style="color : #40906e; background-color : #40906e;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect></svg>
	3 Kandidat dengan nilai tertinggi akan dibandingkan dengan hasil pada metode Fuzzy Tsukamoto
</p>

<div class="text-right">
	<form method="post" action="/smarter/pdf" id="form" class="text-right" target="_blank">
	@csrf
		<textarea name="content" id="table_content" style="display: none;"></textarea>
	</form>
	<button class="btn btn-dark" onclick="getResult()">Cetak PDF</button>
</div>

<script type="text/javascript">
	function getResult(){
		var r = $('#result').html();
		$('#table_content').text(r);
		$('#form').submit();
	}
</script>