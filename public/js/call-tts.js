let voices = [];
let selectedVoice = null;

// Muat daftar voice
function loadVoices() {
    voices = speechSynthesis.getVoices();
    console.log("Voices loaded:", voices);

    const voiceSelect = document.getElementById('voiceSelect');
    if (voiceSelect) {
        voiceSelect.innerHTML = '';

        voices.forEach((voice, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = `${voice.name} (${voice.lang})`;
            voiceSelect.appendChild(option);
        });

        // Pilih default Google Bahasa Indonesia
        const defaultIndex = voices.findIndex(v => v.name.toLowerCase().includes("google bahasa indonesia"));
        if (defaultIndex !== -1) {
            voiceSelect.value = defaultIndex;
            selectedVoice = voices[defaultIndex];
        } else {
            selectedVoice = voices[0];
        }
    }
}

// Pastikan voices dimuat
speechSynthesis.onvoiceschanged = loadVoices;

// Saat dropdown diubah
document.addEventListener('change', function (e) {
    if (e.target.id === 'voiceSelect') {
        const voiceIndex = parseInt(e.target.value, 10);
        selectedVoice = voices[voiceIndex];
        console.log("Selected voice:", selectedVoice);
    }
});

// Fungsi bicara
function speakText(text) {
    if (!voices.length) {
        console.warn("Voices not loaded yet, retrying...");
        setTimeout(() => speakText(text), 500);
        return;
    }

    const utter = new SpeechSynthesisUtterance(text);
    utter.voice = selectedVoice || voices[0];
    utter.rate = 0.92;
    utter.pitch = 1.05;
    utter.volume = 1;

    console.log("Speaking with voice:", utter.voice);
    speechSynthesis.speak(utter);
}

// Event tombol panggil
document.addEventListener('DOMContentLoaded', function () {
    const panggilBtns = document.querySelectorAll('.btn-panggil');

    panggilBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const nomor = this.getAttribute('data-nomor');
            const loket = this.getAttribute('data-loket');

            const text = `Nomor antrian ${nomor}, silakan menuju loket ${loket}. Terima kasih.`;

            speakText(text);
        });
    });
});

