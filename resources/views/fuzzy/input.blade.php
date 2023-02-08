<ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
	@php $i = 1; @endphp
	@foreach($criteria AS $c)
    <li class="nav-item">
        <a class="nav-link {{$i==1?'active':''}}" id="link{{$c->id}}" data-toggle="tab" href="#tab{{$c->id}}" role="tab" aria-controls="home" aria-selected="true">{{$c->name}}</a>
    </li>
	@php $i++; @endphp
    @endforeach
    
</ul>
<div class="tab-content" id="simpletabContent" style="border: 2px solid #ecf0f1; border-top: none; padding: 20px; padding-top: 0px;">
	@php $i = 1; @endphp
	@foreach($criteria AS $c)
    <div class="tab-pane fade show {{$i==1?'active':''}}" id="tab{{$c->id}}" role="tabpanel" aria-labelledby="link{{$c->id}}">
    	<div class="row">
    		<div class="col-md-6">
    			<p><b>Himpunan Input Variabel {{$c->name}}</b></p>
    			<table class="table table-striped table-bordered">
    				<thead class="bg-dark">
    					<tr>
    						<td>Himpunan Fuzzy</td>
    						<td>Domain</td>
    					</tr>
    				</thead>
    				<tbody>
    					@foreach($cvalue AS $cv)
    						@if($cv->criteria_id == $c->id)
	    					<tr>
	    						<td>{{$cv->value}}</td>
	    						<td>[{{$cv->domain_min}}-{{$cv->domain_max}}]</td>
	    					</tr>
	    					@endif
    					@endforeach
    				</tbody>
    			</table>
    			<br>
    			<div id="chart{{$c->id}}"></div>
    			<script type="text/javascript">
    				chart('chart{{$c->id}}', [
    										@foreach($cvalue AS $cv)
    										@if($cv->criteria_id == $c->id)
	    										{ name: '{{$cv->value}}',
	    									     data: [
	    									     	@if($cv->domain_min == $abc[$c->id][0] && $cv->domain_max != end($abc[$c->id]))
	    									     		// Kurva Turun
	    									     		[0, 1],
		    									     	[{{$abc[$c->id][0]}}, 1],
		    									     	[{{$abc[$c->id][1]}}, 0],
		    									     	[{{$abc[$c->id][2]}}, null],
		    									     	[{{$abc[$c->id][2]+($abc[$c->id][1]-$abc[$c->id][0])}}, null]
													@elseif($cv->domain_max == end($abc[$c->id]) && $cv->domain_min != $abc[$c->id][0])
														// Kurva Naik
														[0, null],
		    									     	[{{$abc[$c->id][0]}}, null],
		    									     	[{{$abc[$c->id][1]}}, 0],
		    									     	[{{$abc[$c->id][2]}}, 1],
		    									     	[{{$abc[$c->id][2]+($abc[$c->id][1]-$abc[$c->id][0])}}, 1]
													@else
														// Kurva Segitiga
														[0, null],
		    									     	[{{$abc[$c->id][0]}}, 0],
		    									     	[{{$abc[$c->id][1]}}, 1],
		    									     	[{{$abc[$c->id][2]}}, 0],
		    									     	[{{$abc[$c->id][2]+($abc[$c->id][1]-$abc[$c->id][0])}}, null]
													@endif
	    									     ] },
    									     @endif
    									     @endforeach
    									      ]);
    				window.dispatchEvent(new Event('resize'));
    			</script>
    		</div>
    		<div class="col-md-6">
    			<p><b>Fungsi Keanggotaan Variabel {{$c->name}}</b></p>
    			@foreach($cvalue AS $cv)
    				@if($cv->criteria_id == $c->id)
	    			<div class="membership_function">
	    				<div class="mf-left"><b>μ {{$cv->value}} = </b></div>
	    				<div class="mf-right">

	    					@if($cv->domain_min == $abc[$c->id][0] && $cv->domain_max < end($abc[$c->id]))
	    						{{-- Kurva Turun --}}
		    					0 : x ≥ {{$abc[$c->id][1]}}
		    					<br><br>
		    					({{$abc[$c->id][1]}}-x)/({{$abc[$c->id][1]}}-{{$abc[$c->id][0]}}) : {{$abc[$c->id][0]}} ≤ x ≤ {{$abc[$c->id][1]}}
		    					<br><br>
		    					1 : x ≤ {{$abc[$c->id][0]}}
	    					@elseif($cv->domain_max == end($abc[$c->id]) && $cv->domain_min != $abc[$c->id][0])
	    						{{-- Kurva Naik --}}
		    					0 : x ≤ {{$abc[$c->id][1]}}
		    					<br><br>
		    					(x-{{$abc[$c->id][1]}})/({{end($abc[$c->id])}}-{{$abc[$c->id][1]}}) : {{$abc[$c->id][1]}} ≤ x ≤ {{end($abc[$c->id])}}
		    					<br><br>
		    					1 : x ≥ {{end($abc[$c->id])}}
	    					@else
	    						{{-- Kurva Segitiga --}}
	    						0 : x ≤ {{$abc[$c->id][0]}} or x ≥ {{$abc[$c->id][2]}}
		    					<br><br>
		    					(x-{{$abc[$c->id][0]}})/({{$abc[$c->id][1]}}-{{$abc[$c->id][0]}}) : {{$abc[$c->id][0]}} ≤ x ≤ {{$abc[$c->id][1]}}
		    					<br><br>
		    					({{$abc[$c->id][2]}}-x)/({{$abc[$c->id][2]}}-{{$abc[$c->id][1]}}) : {{$abc[$c->id][1]}} ≤ x ≤ {{$abc[$c->id][2]}}
	    					@endif
	    				</div>
	    			</div>
	    			@endif
    			@endforeach
    		</div>
    	</div>
    </div>
    @php $i++; @endphp
    @endforeach
</div>