<div class="row">
    		<div class="col-md-6">
    			<p><b>Himpunan Output</b></p>
    			<table class="table table-striped table-bordered">
    				<thead class="bg-dark">
    					<tr>
    						<td>Himpunan Fuzzy</td>
    						<td>Domain</td>
    					</tr>
    				</thead>
    				<tbody>
    					@foreach($cvalue AS $cv)
    						@if($cv->criteria_id == 0)
	    					<tr>
	    						<td>{{$cv->value}}</td>
	    						<td>[{{$cv->domain_min}}-{{$cv->domain_max}}]</td>
	    					</tr>
	    					@endif
    					@endforeach
    				</tbody>
    			</table>
    			<br>
    			<div id="chart-output"></div>
    			<script type="text/javascript">
    				chart('chart-output', [
						@foreach($cvalue AS $cv)
						@if($cv->criteria_id == 0)
							{ name: '{{$cv->value}}',
						     data: [
						     	@if($cv->domain_min == $abc_output[0] && $cv->domain_max != end($abc_output))
						     		// Kurva Turun
						     		[0, 1],
							     	[{{$abc_output[0]}}, 1],
							     	[{{$abc_output[1]}}, 0],
							     	[{{$abc_output[2]}}, null],
							     	[{{$abc_output[2]+($abc_output[1]-$abc_output[0])}}, null]
								@elseif($cv->domain_max == end($abc_output) && $cv->domain_min != $abc_output[0])
									// Kurva Naik
									[0, null],
							     	[{{$abc_output[0]}}, null],
							     	[{{$abc_output[1]}}, 0],
							     	[{{$abc_output[2]}}, 1],
							     	[{{$abc_output[2]+($abc_output[1]-$abc_output[0])}}, 1]
								@else
									// Kurva Segitiga
									[0, null],
							     	[{{$abc_output[0]}}, 0],
							     	[{{$abc_output[1]}}, 1],
							     	[{{$abc_output[2]}}, 0],
							     	[{{$abc_output[2]+($abc_output[1]-$abc_output[0])}}, null]
								@endif
						     ] },
					     @endif
					     @endforeach
					      ]);
    				window.dispatchEvent(new Event('resize'));
    			</script>
    		</div>
    		<div class="col-md-6">
    			<p><b>Fungsi Keanggotaan Variabel Output</b></p>
    			@foreach($cvalue AS $cv)
    				@if($cv->criteria_id == 0)
	    			<div class="membership_function">
	    				<div class="mf-left"><b>μ {{$cv->value}} = </b></div>
	    				<div class="mf-right">

	    					@if($cv->domain_min == $abc_output[0] && $cv->domain_max < end($abc_output))
	    						{{-- Kurva Turun --}}
		    					0 : x ≥ {{$abc_output[1]}}
		    					<br><br>
		    					({{$abc_output[1]}}-x)/({{$abc_output[1]}}-{{$abc_output[0]}}) : {{$abc_output[0]}} ≤ x ≤ {{$abc_output[1]}}
		    					<br><br>
		    					1 : x ≤ {{$abc_output[0]}}
	    					@elseif($cv->domain_max == end($abc_output) && $cv->domain_min != $abc_output[0])
	    						{{-- Kurva Naik --}}
		    					0 : x ≤ {{$abc_output[1]}}
		    					<br><br>
		    					(x-{{$abc_output[1]}})/({{end($abc_output)}}-{{$abc_output[1]}}) : {{$abc_output[1]}} ≤ x ≤ {{end($abc_output)}}
		    					<br><br>
		    					1 : x ≥ {{end($abc_output)}}
	    					@else
	    						{{-- Kurva Segitiga --}}
	    						0 : x ≤ {{$abc_output[0]}} or x ≥ {{$abc_output[2]}}
		    					<br><br>
		    					(x-{{$abc_output[0]}})/({{$abc_output[1]}}-{{$abc_output[0]}}) : {{$abc_output[0]}} ≤ x ≤ {{$abc_output[1]}}
		    					<br><br>
		    					({{$abc_output[2]}}-x)/({{$abc_output[2]}}-{{$abc_output[1]}}) : {{$abc_output[1]}} ≤ x ≤ {{$abc_output[2]}}
	    					@endif
	    				</div>
	    			</div>
	    			@endif
    			@endforeach
    		</div>
    	</div>