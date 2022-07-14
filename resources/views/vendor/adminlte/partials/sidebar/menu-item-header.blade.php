<li @if(isset($item['show']) && !$item['show']) style="display: none" @endif @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header {{ $item['class'] ?? '' }}">

    {{ is_string($item) ? $item : $item['header'] }}

</li>
