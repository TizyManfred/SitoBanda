@php
    $coursesInfo = \App\Helpers\SettingsHelper::coursesInfo();
@endphp

<div class="aside-component">
    <div class="card">
        <div class="card-header">
            <h4>{{ __('corsi-di-musica.sidebar.enrollment_title') }}</h4>
        </div>
        <div class="card-body">
            <p><strong>{{ __('corsi-di-musica.sidebar.expiration_label') }}</strong><br>
            {{ \Carbon\Carbon::parse($coursesInfo['expiration_date'])->translatedFormat('d F Y') }}</p>

            <p><strong>{{ __('corsi-di-musica.sidebar.period_label') }}</strong><br>
            da {{ \Carbon\Carbon::parse($coursesInfo['start_date'])->translatedFormat('F') }} a {{ \Carbon\Carbon::parse($coursesInfo['end_date'])->translatedFormat('F') }}</p>

            <p><strong>{{ __('corsi-di-musica.sidebar.fees_label') }}</strong><br>
            {!! nl2br($coursesInfo['price']) !!}

            <p><strong>{{ __('corsi-di-musica.sidebar.info_label') }}</strong><br>
            <a href="mailto:{{ $coursesInfo['contact_email'] }}">{{ $coursesInfo['contact_email'] }}</a><br>
            {{ __('corsi-di-musica.sidebar.phone_label') }} {{ $coursesInfo['phone'] }}</p>

            <div class="mt-4">
                <a href="{{ $coursesInfo['forms_link'] }}" class="button button-primary button-ujarak w-100">{{ __('corsi-di-musica.sidebar.cta') }}</a>
            </div>
        </div>
    </div>

    @if(isset($coursesInfo['testimonials']) && count($coursesInfo['testimonials']) > 0)
    <!-- Testimonials -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __('corsi-di-musica.sidebar.testimonials_title') }}</h4>
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($coursesInfo['testimonials'] as $testimonial)
                <li class="list-group-item">
                    <blockquote class="mb-1">{!! nl2br($testimonial['text']) !!}</blockquote>
                    <small class="text-muted d-block">— {{ $testimonial['name'] }}</small>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
