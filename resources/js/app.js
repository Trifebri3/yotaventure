import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Global Bilingual Language Store (ID & EN)
Alpine.store('lang', {
    current: (typeof window !== 'undefined' && localStorage.getItem('yoin_lang')) || 'ID',
    set(lang) {
        this.current = lang;
        if (typeof window !== 'undefined') {
            localStorage.setItem('yoin_lang', lang);
            document.documentElement.lang = lang.toLowerCase();
            window.dispatchEvent(new CustomEvent('yoin-lang-changed', { detail: lang }));
        }
    },
    isID() {
        return this.current === 'ID';
    },
    isEN() {
        return this.current === 'EN';
    },
    t(idText, enText) {
        return this.current === 'EN' ? enText : idText;
    }
});

Alpine.start();
