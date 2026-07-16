<script>
    (() => {
        try {
            const exactKeys = new Set(['isOpen', 'collapsedGroups']);
            const prefixes = ['tabs-', 'section-'];

            for (let index = localStorage.length - 1; index >= 0; index--) {
                const key = localStorage.key(index);
                const value = key ? localStorage.getItem(key) : null;

                if (value !== null && value.trim() === '') {
                    localStorage.removeItem(key);

                    continue;
                }

                if (!key || (!exactKeys.has(key) && !prefixes.some((prefix) => key.startsWith(prefix)))) {
                    continue;
                }

                try {
                    JSON.parse(value);
                } catch (error) {
                    localStorage.removeItem(key);
                }
            }
        } catch (error) {
            // Filament already falls back to temporary storage when localStorage is unavailable.
        }
    })();
</script>
