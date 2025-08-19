        // Update current time
        function updateCurrentTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            document.querySelector('.current-time').textContent = now.toLocaleDateString('id-ID', options);
        }

        // Update time every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Function to speak queue number
        function speakQueueNumber(queueNumber) {
            console.log('Memanggil nomor:', queueNumber);

            // Create TTS message
            const msg = new SpeechSynthesisUtterance();
            
            // Set speech properties
            msg.lang = 'id-ID';
            msg.rate = 0.9;
            msg.pitch = 1;
            msg.volume = 1;
            msg.text = `Nomor Antrian ${queueNumber}, silakan menuju ke loket`;

            // Speak the message
            window.speechSynthesis.cancel(); // Cancel any ongoing speech
            window.speechSynthesis.speak(msg);
            
            // Add event listeners for speech synthesis
            msg.onstart = () => console.log('Mulai berbicara');
            msg.onend = () => console.log('Selesai berbicara');
            msg.onerror = (e) => console.error('Error dalam text-to-speech:', e);
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