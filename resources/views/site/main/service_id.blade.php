@extends('site.layouts.default')

@section('content')
  @php($path = '/images/files/big/')
  @php($img = $page['file'] ? $page['crop'] ? $path . $page['crop'] : $path . $page['file'] : '')

  <main class="main">
    <div class="subheader fixed-subheader" style="background-image: url('{{ $img }}')">
      <div class="container"><h1>{{ $langSt($page['name']) }}</h1></div>
    </div>

    <div class="scroll-content">
      <div class="indent-block">
        <div class="container">
          <div class="entry-holder">
            <div class="entry-content">
              {!! $langSt($page['text']) !!}
            </div>
          </div>
        </div>

        @if(!empty($langSt($page['how_working']) ?? []) && $langSt($page['how_working']) !== 'null')
          <div class="container">
            <div class="service-slider simple-slider">
              @include('site.block.how_working', ['how_working' => $page['how_working']])
            </div>
          </div>
        @endif
      </div>
    </div>
  </main>

  @push('footer')
    <script>
      $(document).ready(function() {
        catAll.initialize({
          container  : '.sys-sel-catalog',
          num        : '.selReN > .i',
          pagination : false,
          isLoad     : false,
          isPortfolio: false,
          url_req    : '/',
        });
      });

      $('#header').addClass('static');
    </script>
  @endpush
@endsection
