@foreach ($blocks as $block)
    @php
        $embedded = $embedded ?? false;
        $layout = $block['layout'] ?? 'text_image_right';
        $images = $block['images'] ?? [];
        $hasImages = count($images) > 0;
        $textColumnClass = $hasImages && $layout !== 'gallery' ? 'col-md-10 col-lg-7 col-xl-6' : 'col-12';
        $imageColumnClass = $layout === 'image_left_text' ? 'order-lg-first' : 'order-lg-last';
    @endphp

    @if ($embedded)
    <div class="static-page-block {{ ! $loop->last ? 'mb-5' : '' }}">
    @else
    <section class="section section-sm {{ $loop->first ? 'section-first' : '' }} {{ $loop->odd ? 'bg-default' : 'bg-gray-100' }} text-left">
        <div class="container">
    @endif
            @if ($layout === 'gallery' && $hasImages)
                @if (filled($block['title']))
                    <h2 class="title-decoration-lines-left">{{ $block['title'] }}</h2>
                @endif

                @if (filled($block['body']))
                    <div class="static-page-content text-gray-800 mb-4">
                        {!! $block['body'] !!}
                    </div>
                @endif

                <div class="row row-30" data-lightgallery="group">
                    @foreach ($images as $image)
                        @php
                            $caption = $image['caption'] ?? '';
                        @endphp
                        <div class="col-sm-6 col-lg-4">
                            <a href="{{ $image['url'] }}" data-lightgallery="item" @if (filled($caption)) data-sub-html="{{ e($caption) }}" @endif>
                                <img src="{{ $image['url'] }}" class="img-fluid w-100" alt="{{ $caption ?: ($block['title'] ?? '') }}" loading="lazy">
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                @if (filled($block['title']))
                    <h2 class="title-decoration-lines-left">{{ $block['title'] }}</h2>
                @endif

                <div class="row row-50 justify-content-center align-items-xl-center">
                    <div class="{{ $textColumnClass }}">
                        @if (filled($block['body']))
                            <div class="static-page-content text-gray-800">
                                {!! $block['body'] !!}
                            </div>
                        @endif
                    </div>

                    @if ($hasImages)
                        <div class="col-md-10 col-lg-5 col-xl-6 {{ $imageColumnClass }}">
                            @if (count($images) === 1)
                                @php
                                    $caption = $images[0]['caption'] ?? '';
                                @endphp
                                <a href="{{ $images[0]['url'] }}" data-lightgallery="item" @if (filled($caption)) data-sub-html="{{ e($caption) }}" @endif>
                                    <div class="figure-classic figure-classic-left wow fadeInRight">
                                        <img src="{{ $images[0]['url'] }}" class="img-fluid w-100" alt="{{ $caption ?: ($block['title'] ?? '') }}" loading="lazy">
                                    </div>
                                </a>
                            @else
                                <div id="static-page-content-carousel-{{ $loop->index }}" class="carousel slide w-100 figure-classic figure-classic-left wow fadeInLeft" data-ride="carousel" data-interval="{{ random_int(6000, 12000) }}" data-wrap="true">
                                    <div class="carousel-inner" data-lightgallery="group" data-lg-autoplay="true" data-lg-loop="true">
                                        @foreach ($images as $image)
                                            @php
                                                $caption = $image['caption'] ?? '';
                                            @endphp
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <a href="{{ $image['url'] }}" data-lightgallery="item" @if (filled($caption)) data-sub-html="{{ e($caption) }}" @endif>
                                                    <img src="{{ $image['url'] }}" class="d-block w-100 img-fluid" alt="{{ $caption ?: ($block['title'] ?? '') }}" loading="lazy" style="height: auto; cursor: pointer;">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
    @if ($embedded)
    </div>
    @else
        </div>
    </section>
    @endif
@endforeach
