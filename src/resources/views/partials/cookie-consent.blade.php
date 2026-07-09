@php
    $analytics = $analyticsSettings ?? \App\Helpers\SettingsHelper::analytics();
    $showCookieConsent = (bool) ($analytics['enabled'] ?? false)
        && ($analytics['provider'] ?? null) === 'ga4'
        && trim((string) ($analytics['ga4_measurement_id'] ?? '')) !== '';
    $privacyPolicyUrl = route('privacy-policy');
@endphp

@if ($showCookieConsent)
    <style>
        .cookie-consent {
            position: fixed;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1100;
            border-top: 4px solid #50ba87;
            background: rgba(37, 37, 37, 0.98);
            color: #fff;
            box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.18);
        }

        .cookie-consent__inner {
            display: flex;
            max-width: 1200px;
            gap: 30px;
            margin: 0 auto;
            align-items: center;
            justify-content: space-between;
            padding: 20px 15px;
        }

        .cookie-consent__content {
            max-width: 780px;
        }

        .cookie-consent__title {
            margin: 0 0 4px;
            color: #fff;
            font-family: "Teko", sans-serif;
            font-size: 26px;
            font-weight: 400;
            letter-spacing: 0.04em;
            line-height: 1;
        }

        .cookie-consent__text {
            margin: 0;
            font-size: 13px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.92);
        }

        .cookie-consent__text a {
            color: #50ba87;
            text-decoration: underline;
        }

        .cookie-consent__actions {
            display: flex;
            gap: 12px;
            align-items: center;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        .cookie-consent__button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 142px;
            min-height: 54px;
            margin: 0;
            padding: 12px 24px;
            cursor: pointer;
        }

        .cookie-consent__reject {
            min-width: auto;
            min-height: 54px;
            padding: 12px 8px;
            border: 0;
            background: transparent;
            color: rgba(255, 255, 255, 0.68);
            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.02em;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .cookie-consent__reject:hover,
        .cookie-consent__reject:focus-visible {
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .cookie-consent__inner {
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
                padding: 18px 20px;
            }

            .cookie-consent__actions {
                width: 100%;
            }

            .cookie-consent__button {
                flex: 1 1 0;
            }
        }
    </style>

    <div
        id="cookie-consent"
        class="cookie-consent"
        role="dialog"
        aria-live="polite"
        aria-label="{{ __('cookie.banner_aria') }}"
        hidden
    >
        <div class="cookie-consent__inner">
            <div class="cookie-consent__content">
                <h2 class="cookie-consent__title">{{ __('cookie.title') }}</h2>
                <p class="cookie-consent__text">
                    {!! __('cookie.message', ['privacyUrl' => e($privacyPolicyUrl)]) !!}
                </p>
            </div>

            <div class="cookie-consent__actions">
                <button type="button" class="cookie-consent__button cookie-consent__reject" data-cookie-consent="reject">
                    {{ __('cookie.reject') }}
                </button>
                <button type="button" class="button button-primary button-ujarak cookie-consent__button" data-cookie-consent="accept">
                    {{ __('cookie.accept') }}
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var storageKey = 'banda_cookie_consent_v1';
            var banner = document.getElementById('cookie-consent');

            if (!banner) {
                return;
            }

            function updateConsent(state) {
                if (typeof window.gtag !== 'function') {
                    return;
                }

                window.gtag('consent', 'update', {
                    'ad_storage': 'denied',
                    'ad_user_data': 'denied',
                    'ad_personalization': 'denied',
                    'analytics_storage': state === 'granted' ? 'granted' : 'denied'
                });

                if (state === 'granted') {
                    window.BandaAnalytics?.load?.();
                }
            }

            function persistChoice(state) {
                try {
                    window.localStorage.setItem(storageKey, state);
                } catch (error) {
                    return;
                }
            }

            function readChoice() {
                try {
                    return window.localStorage.getItem(storageKey);
                } catch (error) {
                    return null;
                }
            }

            function hideBanner() {
                banner.hidden = true;
            }

            function showBanner() {
                banner.hidden = false;
            }

            function reopenBanner() {
                try {
                    window.localStorage.removeItem(storageKey);
                } catch (error) {
                    // Ignore storage access failures and still reopen the banner.
                }

                updateConsent('denied');
                showBanner();
            }

            window.BandaCookieConsent = {
                reopen: reopenBanner
            };

            document.querySelectorAll('[data-cookie-consent-reopen]').forEach(function (button) {
                button.addEventListener('click', reopenBanner);
            });

            var savedChoice = readChoice();

            if (savedChoice === 'granted' || savedChoice === 'denied') {
                updateConsent(savedChoice);
                hideBanner();
            } else {
                showBanner();
            }

            banner.querySelectorAll('[data-cookie-consent]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var action = button.getAttribute('data-cookie-consent') === 'accept' ? 'granted' : 'denied';
                    persistChoice(action);
                    updateConsent(action);
                    hideBanner();
                });
            });
        })();
    </script>
@endif
