// Queue Display System Enhancement

// Voice and Audio Configuration
const QueueSystem = {
    voices: [],
    notification: new Audio('/notification.mp3'),
    statusSound: new Audio('/status-change.mp3'),
    
    // Initialize the system
    init() {
        this.loadVoices();
        this.initializeEventListeners();
        this.startClockUpdate();
        this.initializeAOS();
    },

    // Load available TTS voices
    loadVoices() {
        if (window.speechSynthesis) {
            this.voices = window.speechSynthesis.getVoices();
            window.speechSynthesis.onvoiceschanged = () => {
                this.voices = window.speechSynthesis.getVoices();
            };
        }
    },

    // Initialize AOS (Animate On Scroll) library
    initializeAOS() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    },

    // Start clock update
    startClockUpdate() {
        this.updateClock();
        setInterval(() => this.updateClock(), 1000);
    },

    // Update digital clock and date
    updateClock() {
        const now = new Date();
        const clockElement = document.getElementById('clock');
        const dateElement = document.getElementById('date');
        
        if (clockElement && dateElement) {
            // Update time with animation
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            if (clockElement.textContent !== time) {
                clockElement.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    clockElement.textContent = time;
                    clockElement.style.transform = 'scale(1)';
                }, 100);
            }

            // Update date
            dateElement.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    },

    // Announce queue number using TTS
    announceNumber(number, counterNumber = '') {
        if (!window.speechSynthesis) return;

        // Cancel any ongoing speech
        window.speechSynthesis.cancel();

        // Create announcement parts
        const parts = [
            { text: 'Nomor antrian', rate: 0.9, pitch: 1.1 },
            { text: number.split('').join(' '), rate: 0.8, pitch: 1.2 },
            { text: 'Silakan menuju ke loket', rate: 0.9, pitch: 1.1 }
        ];

        if (counterNumber) {
            parts.push({ text: counterNumber, rate: 0.8, pitch: 1.2 });
        }

        // Play attention sound
        this.notification.play().then(() => {
            // Chain announcements
            this.speakSequence(parts);
        }).catch(error => {
            console.error('Error playing notification:', error);
            // Fallback to direct TTS if audio fails
            this.speakSequence(parts);
        });
    },

    // Speak a sequence of utterances
    speakSequence(parts) {
        const indonesianVoice = this.voices.find(voice => 
            voice.lang.includes('id') || voice.name.includes('Indonesian')
        ) || this.voices.find(voice => voice.name.includes('Female'));

        let delay = 0;
        parts.forEach((part, index) => {
            setTimeout(() => {
                const utterance = new SpeechSynthesisUtterance(part.text);
                utterance.voice = indonesianVoice;
                utterance.rate = part.rate;
                utterance.pitch = part.pitch;
                utterance.volume = 1;
                utterance.lang = indonesianVoice?.lang || 'id-ID';
                
                window.speechSynthesis.speak(utterance);
            }, delay);
            delay += (part.text.length * 100) + 500; // Adjust timing based on text length
        });
    },

    // Update display with animation
    updateDisplay(number) {
        const display = document.querySelector('.current-number-animation');
        if (!display) return;

        // Add exit animation
        display.style.transform = 'scale(0.8)';
        display.style.opacity = '0';

        // Update number with entrance animation
        setTimeout(() => {
            display.textContent = number;
            display.style.transform = 'scale(1.2)';
            display.style.opacity = '1';
            
            // Return to normal scale
            setTimeout(() => {
                display.style.transform = 'scale(1)';
            }, 300);
        }, 300);
    },

    // Update queue list with animation
    updateQueueList(tickets) {
        const container = document.getElementById('waitingList');
        if (!container) return;

        const fragment = document.createDocumentFragment();

        tickets.forEach((ticket, index) => {
            const item = document.createElement('div');
            item.className = 'queue-item';
            item.setAttribute('data-aos', 'fade-left');
            item.setAttribute('data-aos-delay', `${index * 100}`);
            
            item.innerHTML = `
                <span class="queue-number">${ticket.display_number}</span>
                <span class="queue-time">${new Date(ticket.created_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                })}</span>
            `;
            
            fragment.appendChild(item);
        });

        // Clear and update container
        container.innerHTML = '';
        container.appendChild(fragment);
        AOS.refresh(); // Refresh animations
    },

    // Initialize event listeners
    initializeEventListeners() {
        // Listen for status changes
        document.addEventListener('click', (e) => {
            const statusBtn = e.target.closest('.status-btn');
            if (statusBtn) {
                this.handleStatusChange(statusBtn);
            }
        });

        // Listen for theme changes
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            darkModeToggle.addEventListener('change', () => {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            });
        }
    },

    // Handle status changes
    handleStatusChange(button) {
        if (button.classList.contains('active')) return;

        // Play status change sound
        this.statusSound.play().catch(console.error);

        // Add loading animation
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.classList.add('loading');

        // Get status info
        const status = button.dataset.status;
        const queueNumber = button.closest('tr')?.querySelector('.queue-number')?.textContent;

        // If status is 'called', announce the number
        if (status === 'called' && queueNumber) {
            this.announceNumber(queueNumber);
        }

        // Remove loading state after animation
        setTimeout(() => {
            button.classList.remove('loading');
            button.innerHTML = button.dataset.originalText || '';
        }, 1000);
    }
};

// Initialize system when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    QueueSystem.init();

    // Check for saved theme preference
    const darkMode = localStorage.getItem('darkMode') === 'true';
    if (darkMode) {
        document.body.classList.add('dark-mode');
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) darkModeToggle.checked = true;
    }
});

// Export for use in other modules
window.QueueSystem = QueueSystem;
