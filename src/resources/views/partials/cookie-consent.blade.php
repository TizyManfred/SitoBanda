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
            left: 20px;
            right: 20px;
            bottom: 20px;
            z-index: 1100;
            border-radius: 16px;
            background: rgba(34, 34, 34, 0.96);
            color: #fff;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.28);
        }

        .cookie-consent__inner {
            display: flex;
            gap: 18px;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
        }

        .cookie-consent__text {
            margin: 0;
            font-size: 14px;
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.92);
        }

        .cookie-consent__text a {
            color: #f7c768;
            text-decoration: underline;
        }

        .cookie-consent__actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-shrink: 0;
        }

        .cookie-consent__button {
            border: 0;
            border-radius: 999px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }

        .cookie-consent__button:hover {
            transform: translateY(-1px);
        }

        .cookie-consent__button--accept {
            background: #f7c768;
            color: #2d2412;
        }

        .cookie-consent__button--reject {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .cookie-consent {
                left: 12px;
                right: 12px;
                bottom: 12px;
            }

            .cookie-consent__inner {
                flex-direction: column;
                align-items: stretch;
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
            <p class="cookie-consent__text">
                {!! __('cookie.message', ['privacyUrl' => e($privacyPolicyUrl)]) !!}
            </p>

            <div class="cookie-consent__actions">
                <button type="button" class="cookie-consent__button cookie-consent__button--reject" data-cookie-consent="reject">
                    {{ __('cookie.reject') }}
                </button>
                <button type="button" class="cookie-consent__button cookie-consent__button--accept" data-cookie-consent="accept">
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
