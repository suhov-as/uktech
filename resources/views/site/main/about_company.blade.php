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
                <h3 class="text-center mb-md">{!! $langSt($about['block_4_1']) !!}</h3>
                <ul class="certificates-list">
                    @foreach($slider_1 as $sl_1)
                        @php($img = $sl_1['file'] ? $sl_1['crop'] ? $path_big . $sl_1['crop'] : $path_big . $sl_1['file'] : '')
                    <li>
                        <a href="{{$img}}" target="_blank" class=""><svg><use xlink:href="/images/svg/sprite.svg#pdf"></use></svg> {{ str_replace(['.pdf','.jpg','.jpeg','.png'],'',$sl_1['orig_name']) }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </section>
        <section class="indent-block">
            <div class="container">
                <h3 class="text-center mb-md">{!! $langSt($about['block_4_2']) !!}</h3>
                <ul class="certificates-list">
                    @foreach($slider_2 as $sl_2)
                        @php($img = $sl_2['file'] ? $sl_2['crop'] ? $path_big . $sl_2['crop'] : $path_big . $sl_2['file'] : '')
                        <li>
                            <a href="{{$img}}" target="_blank" class=""><svg><use xlink:href="/images/svg/sprite.svg#pdf"></use></svg> {{ str_replace(['.pdf','.jpg','.jpeg','.png'],'',$sl_1['orig_name']) }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="subscribe-section" style="background-image: url('/images/banners/img_2.jpg')">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <div class="section-title">{!! $langSt($params['about_company_contact']['key']) !!}</div>
                        {{--            <p>{!! $langSt($params['contact_us_text_contact_an_agent']['key']) !!}</p>--}}

                        <a href="#" class="link" data-toggle="modal" data-target=".request-modal">
                            @lang('main.to_get_a_consultation')
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="indent-block testimonials-section" style="background-image: url('/images/banners/img_10.jpg')">
            <div class="container large">
                <h3>@lang('main.reviews')</h3>

                <div class="testimonials-slider">
                    @foreach($reviews as $review)
                        <div>
                            <div class="inner-box">
                                <span class="user-name">{{ $langSt($review['name']) }}</span>
                                <span class="location">{{ $langSt($review['location_name']) }}</span>
                                <p>{{ $langSt($review['little_description']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
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