

    @foreach ($languages as $language)
    	@if ($language->image)
    		<img src="{{ $language->image_url }}" title="{{ $language->name }}" class="flag flag-sm"> 
    	@else
        	<span title="{{ $language->name }}">[{{ $language->code }}]</span>
    	@endif
    	@if (!$loop->first && $loop->iteration % 3 === 0)
    		<br>
    	@endif
    @endforeach	
