<div class="language-switcher">
    <div class="current-language">
        <span class="flag-icon flag-icon-{{ app()->getLocale() == 'it' ? 'it' : 'en' }}"></span>
        <span class="language-code">{{ strtoupper(app()->getLocale()) }}</span>
        <i class="bi bi-caret-down-fill"></i>
    </div>
    <div class="language-dropdown">
        <a href="{{ route('language.switch', 'it') }}" class="language-option {{ app()->getLocale() == 'it' ? 'active' : '' }}">
            <span class="flag-icon flag-icon-it"></span>
            <span class="language-name">Italiano</span>
        </a>
        <a href="{{ route('language.switch', 'en') }}" class="language-option {{ app()->getLocale() == 'en' ? 'active' : '' }}">
            <span class="flag-icon flag-icon-en"></span>
            <span class="language-name">English</span>
        </a>
    </div>
</div>
