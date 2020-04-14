@extends('site.layouts.default')

@section('content')
    @php($path_big = '/images/files/big/')

    <main class="main">
        <section class="indent-block">
            <div class="container">
                <h1 class="text-center">{{ $langSt($about['name']) }}</h1>

                <div class="about-info">
                    <div class="entry-holder mb-none">
                        <div class="entry-content">
                            <p>{!! $langSt($about['block_1']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="indent-block">
            <div class="container">
                {!! $langSt($about['block_2']) !!}
            </div>
        </section>
    </main>

    @push('footer')
        <script>
            $(document).ready(function () {
                catAll.initialize({
                    container: '.sys-sel-catalog',
                    num: '.selReN > .i',
                    pagination: false,
                    isLoad: false,
                    isPortfolio: false,
                    url_req: '/',
                });
            });

            $('#header').addClass('static');
        </script>
    @endpush
@endsection