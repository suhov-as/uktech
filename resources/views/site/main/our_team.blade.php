@extends('site.layouts.default')

@section('content')
    @php($path_big = '/images/files/big/')
    <main class="main">
        <section class="indent-block">
            <div class="container">
                <h1 class="text-center">{{ $langSt($team['name']) }}</h1>

                <div class="about-info">
                    <div class="entry-holder mb-none">
                        <div class="entry-content">
                            <p>{!! $langSt($team['block_1']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="indent-block">
            <div class="container">
                @foreach($employees as $emp)
                    <div class="team-member">
                        <div class="team-member__info">
                            <img src="/images/content/img_40.jpg" alt="">
                            <div class="team-member__info-content">
                                <h4 class="team-member__title">{!! $langSt($emp['name']) !!}</h4>
                                <span class="team-member__subtitle">{!! $langSt($emp['position']) !!}</span>
                                <address class="team-member__contact-info">
                                <span class="address-info">
                                    <svg><use xlink:href="/images/svg/sprite.svg#envelope"></use></svg>
                                    <a href="mailto:name@gmail.com">{!! $langSt($emp['email']) !!}</a>
                                </span>
                                    <span class="address-info">
                                    <svg><use xlink:href="/images/svg/sprite.svg#phone"></use></svg>
                                    <a href="tel:{!! $langSt($emp['phone']) !!}">{!! $langSt($emp['phone']) !!}</a>
                                </span>
                                </address>
                            </div>
                        </div>
                        <div class="team-member__description">
                            {!! $langSt($emp['user_description']) !!}
                        </div>
                    </div>
                @endforeach
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