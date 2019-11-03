

    @foreach ($languages as $language)
    	@if ($language->image)
    		<img src="http://magedmaher-testapi2.s3-eu-west-1.amazonaws.com/languages/{{ $language->image }}" title="{{ $language->name }}" class="flag flag-sm"> 
    	@else
        	<span title="{{ $language->name }}">[{{ $language->code }}]</span>
    	@endif
    	@if (!$loop->first && $loop->iteration % 3 === 0)
    		<br>
    	@endif
    @endforeach	
