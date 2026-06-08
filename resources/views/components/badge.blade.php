@props(['color' => '#6c757d'])

<span class="px-3 py-1 rounded-pill"
      style="font-size:12px;
             background-color: {{ $color }}20;
             color: {{ $color }};">
    {{ $slot }}
</span>
