<?php

namespace Tests\Feature;

use App\Filament\Pages\HomepageStaticPage;
use App\Helpers\SettingsHelper;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class HomeBannerTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_the_default_banner(): void
    {
        $response = $this
            ->withHeader('Accept-Language', 'it')
            ->get('/');

        $response
            ->assertOk()
            ->assertSee('home-banner', false)
            ->assertSeeText('125 anni di musica, storia e comunità')
            ->assertSeeText('Scopri gli eventi')
            ->assertSee('href="/eventi"', false);
    }

    public function test_homepage_hides_the_banner_when_disabled(): void
    {
        Setting::set('home_announcement_banner', [
            'enabled' => false,
        ], 'events');

        $response = $this
            ->withHeader('Accept-Language', 'it')
            ->get('/');

        $response
            ->assertOk()
            ->assertDontSee('home-banner', false)
            ->assertDontSeeText('125 anni di musica, storia e comunità');
    }

    public function test_banner_respects_inclusive_start_and_end_dates(): void
    {
        $this->travelTo('2026-07-23 12:00:00');

        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'start_date' => '2026-07-23',
            'end_date' => '2026-07-23',
        ], 'events');

        $this->assertTrue(SettingsHelper::localizedHomeBanner()['visible']);

        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'start_date' => '2026-07-24',
            'end_date' => null,
        ], 'events');

        $this->assertFalse(SettingsHelper::localizedHomeBanner()['visible']);

        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'start_date' => null,
            'end_date' => '2026-07-22',
        ], 'events');

        $this->assertFalse(SettingsHelper::localizedHomeBanner()['visible']);
    }

    public function test_banner_uses_localized_content_and_a_custom_link(): void
    {
        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'image' => 'static-pages/home-banner/announcement.webp',
            'badge' => [
                'en' => 'Featured',
            ],
            'headline' => [
                'en' => 'A custom announcement',
            ],
            'body' => [
                'en' => 'Custom announcement details.',
            ],
            'cta_label' => [
                'en' => 'See the programme',
            ],
            'cta_url' => [
                'en' => 'https://example.com/programme',
            ],
        ], 'events');

        app()->setLocale('en');

        $banner = SettingsHelper::localizedHomeBanner();

        $this->assertTrue($banner['visible']);
        $this->assertSame('static-pages/home-banner/announcement.webp', $banner['image']);
        $this->assertSame('Featured', $banner['badge']);
        $this->assertSame('A custom announcement', $banner['headline']);
        $this->assertSame('Custom announcement details.', $banner['body']);
        $this->assertSame('See the programme', $banner['cta_label']);
        $this->assertSame('https://example.com/programme', $banner['cta_url']);
    }

    public function test_homepage_renders_the_optional_banner_image(): void
    {
        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'image' => 'static-pages/home-banner/announcement.webp',
        ], 'events');

        $response = $this
            ->withHeader('Accept-Language', 'it')
            ->get('/');

        $response
            ->assertOk()
            ->assertSee('home-banner__visual', false)
            ->assertSee('static-pages/home-banner/announcement.webp', false)
            ->assertSee('alt=""', false);
    }

    public function test_banner_rejects_unsafe_custom_links(): void
    {
        Setting::set('home_announcement_banner', [
            'enabled' => true,
            'cta_url' => [
                'it' => 'javascript:alert(1)',
            ],
        ], 'events');

        $this->assertSame('', SettingsHelper::localizedHomeBanner()['cta_url']);
    }

    public function test_legacy_anniversary_setting_is_used_until_the_generic_banner_is_saved(): void
    {
        Setting::set('home_anniversary_banner', [
            'enabled' => true,
            'headline' => [
                'it' => 'Contenuto esistente',
            ],
        ], 'events');

        $this->assertSame('Contenuto esistente', SettingsHelper::localizedHomeBanner()['headline']);
    }

    public function test_admin_can_update_the_scheduled_banner_from_the_homepage_editor(): void
    {
        Storage::fake('public');

        $this->actingAs(User::factory()->create());

        Livewire::test(HomepageStaticPage::class)
            ->fillForm([
                'home_banner' => [
                    'enabled' => true,
                    'start_date' => '2026-01-01',
                    'end_date' => '2026-12-31',
                    'image' => UploadedFile::fake()->image('admin-image.png', 1200, 675),
                    'badge' => [
                        'it' => 'In evidenza',
                        'en' => 'Featured',
                        'de' => 'Empfohlen',
                    ],
                    'headline' => [
                        'it' => 'Titolo banner',
                        'en' => 'Banner headline',
                        'de' => 'Bannerüberschrift',
                    ],
                    'body' => [
                        'it' => 'Testo banner.',
                        'en' => 'Banner text.',
                        'de' => 'Bannertext.',
                    ],
                    'cta_label' => [
                        'it' => 'Scopri',
                        'en' => 'Discover',
                        'de' => 'Entdecken',
                    ],
                    'cta_url' => [
                        'it' => '/eventi',
                        'en' => '/en/events',
                        'de' => '/de/veranstaltungen',
                    ],
                ],
                'header_slides' => [],
                'is_active' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $savedBanner = Setting::get('home_announcement_banner');

        $this->assertTrue($savedBanner['enabled']);
        $this->assertSame('2026-01-01', $savedBanner['start_date']);
        $this->assertSame('2026-12-31', $savedBanner['end_date']);
        $this->assertStringStartsWith('static-pages/home-banner/', $savedBanner['image']);
        $this->assertStringEndsWith('.webp', $savedBanner['image']);
        Storage::disk('public')->assertExists($savedBanner['image']);
        $this->assertSame('Titolo banner', $savedBanner['headline']['it']);
        $this->assertSame('/en/events', $savedBanner['cta_url']['en']);
    }
}
