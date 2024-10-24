  {{-- @if (session()->has('success')) --}}
  @if (session($type))
      <div class="alert alert-{{ $type }}">
          {{ session($type) }}
      </div>
  @endif
  {{-- @if (session('info'))
      <div class="alert alert-info">
          {{ session('info') }}
      </div>
  @endif --}}
