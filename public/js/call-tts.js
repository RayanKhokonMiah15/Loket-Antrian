    // Update jam digital simpel
    function updateClock() {
        const now = new Date();
        const timeElement = document.getElementById('clock');
        const dateElement = document.getElementById('date');
        
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
        
        if (dateElement) {
            dateElement.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
    }        // Update time every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Initialize speech synthesis
        let synthVoices = [];
        function loadVoices() {
            synthVoices = window.speechSynthesis.getVoices();
        }
        
        // Load voices when they're ready
        if (window.speechSynthesis.onvoiceschanged !== undefined) {
            window.speechSynthesis.onvoiceschanged = loadVoices;
        }
        
        // Initial load
        loadVoices();

        // Function to speak queue number
        function speakQueueNumber(queueNumber) {
            console.log('Memanggil nomor:', queueNumber);

            // Cancel any ongoing speech
            window.speechSynthesis.cancel();

            // Create utterance with Indonesian text
            const utterance = new SpeechSynthesisUtterance();
            
            // Set a female Microsoft voice
            const voices = window.speechSynthesis.getVoices();
            const femaleVoice = voices.find(voice => 
                (voice.name.includes('Microsoft Zira') || 
                 voice.name.includes('Google ID Indonesia Female') ||
                 voice.name.includes('Microsoft Eva'))
            );
            
            if (femaleVoice) {
                utterance.voice = femaleVoice;
            }

            utterance.lang = 'id-ID';  // Using Indonesian voice for better clarity
            utterance.rate = 0.9;      // Slightly slower
            utterance.pitch = 1.2;     // Higher pitch for female voice
            utterance.volume = 1;
            
            // Format nomor antrian untuk pengucapan yang lebih jelas
            const numberToSpeak = queueNumber.split('').join(' ');
            utterance.text = `Perhatian, nomor antrian ${numberToSpeak}, silakan menuju loket`;

            // Speak
            window.speechSynthesis.speak(utterance);

            // Log untuk debugging
            console.log('Speaking:', utterance.text);
        }
        
        // Function to handle status updates
        function updateStatus(button) {
            const form = button.closest('form');
            const statusInput = form.querySelector('.status-input');
            const newStatus = button.dataset.status;
            const row = button.closest('tr');
            
            // Update hidden input value
            statusInput.value = newStatus;

            // Remove active class from all buttons in this group
            button.parentElement.querySelectorAll('.status-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            button.classList.add('active');

            // Add transition effect to the row
            row.style.backgroundColor = '#f8f9fc';
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 1000);

            // Handle queue number calling if status is 'called'
            if (newStatus === 'called') {
                const queueNumber = row.querySelector('.fw-bold.fs-5').textContent.trim();
                speakQueueNumber(queueNumber);
            }

            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            // Submit the form
            form.submit();
        }

        // Initialize tooltips
        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('mouseover', function() {
                const status = this.dataset.status;
                let message = '';
                
                switch(status) {
                    case 'waiting':
                        message = 'Set status to Waiting';
                        break;
                    case 'called':
                        message = 'Set status to Called';
                        break;
                    case 'done':
                        message = 'Set status to Done';
                        break;
                }
                
                this.setAttribute('title', message);
            });
        });

        // Add sound effect for status changes
        const statusChangeSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodHRr3ZCKj+a2fLToWI7OIHJ6/LDkmk8LXfH7vi8kGI6KI/k/easclIwSpPt/cqKYkcviN/5xFxAR1PP8vO1kXBHGJHq+L1oUDVjtef0sIxwTRqe4O+0cl87Xrjj6a+GdVIXp+PqqYB0TxC26OypfGNnK8Tj6qZ8ZlBPweTqpHxgTSnH5OyjfGVQSMrm7KN8aFFEyebso31jUEPG5eujfGVRQ8Xk66N9Y1FDxOTro31jUULE5OujfWNRQ8Tj66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTro31jUUPE5OujfWNRQ8Tk66N9Y1FDxOTrZGF0YWoGAAA=');
        statusChangeSound.volume = 0.3;

        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('click', () => {
                if (!button.classList.contains('active')) {
                    statusChangeSound.play();
                }
            });
        });