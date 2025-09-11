$(document).ready(function() {
    // Function to update statistics
    function updateStats() {
        const visibleCards = $('.ticket-card:visible');
        const totalTickets = visibleCards.length;
        const completedTickets = visibleCards.filter('[data-status="completed"]').length;
        const pendingTickets = visibleCards.filter('[data-status="pending"]').length;
        const calledTickets = visibleCards.filter('[data-status="called"]').length;
        
        $('#total-tickets').text(totalTickets);
        $('#completed-tickets').text(completedTickets);
        $('#pending-tickets').text(pendingTickets);
        $('#called-tickets').text(calledTickets);
    }

    // Listen to loket filter buttons
    $('.loket-filter').on('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all buttons
        $('.loket-filter').removeClass('active');
        
        // Add active class to clicked button
        $(this).addClass('active');
        
        // Get loket value
        const loket = $(this).data('loket');
        
        // Filter tickets
        if (loket === 'all') {
            $('.ticket-card').show();
        } else {
            $('.ticket-card').hide();
            $(`.ticket-card[data-loket="${loket}"]`).show();
        }
        
        // Update stats
        updateStats();
    });

    // Initial stats update
    updateStats();
});
