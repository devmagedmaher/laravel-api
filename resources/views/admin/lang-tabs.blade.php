
<ul class="nav" id="language-list">
    @foreach ($langs as $lang) 
        <li 
            data-role='tab' 
            class="
                {{ $lang->code == 'en' ? 'checked active' : '' }}
            " 
            href="#tab-{{ $lang->code }}"
        >
            <span class="checked checker fa fa-check-square-o"></span>
            <span class="unchecked checker fa fa-square-o"></span>
            <input 
                type="checkbox"  
                fixed="{{ $lang->code == 'en' && empty($checkedLangs) ? 'true' : ''}}"
                {{ old("language.$lang->code") || (!$errors->any() && in_array($lang->id, $checkedLangs)) ? 'checked' : '' }}
            >
            <span class="text">{{ $lang->name }}</span> 
            <span class="label label-danger pull-right" style="display: none"></span>
        </li>
    @endforeach
</ul>
