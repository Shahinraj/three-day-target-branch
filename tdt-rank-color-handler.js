jQuery(document).ready(function($) {
   function updateRankColors(score, bestDays) {
    // Reset all
    $('#BEST, #BETTER, #GOOD, #BAD').removeClass('active-rank').css({
        'background-color': '#fff',
        'color': '#000'
    });

    // Apply color based on score range
    if (score >= 15) {
        $('#BEST').css({'background-color': '#4CAF50', 'color': '#fff'});
    } else if (score >= 10) {
        $('#BETTER').css({'background-color': '#4CAF50', 'color': '#fff'});
    } else if (score >= 5) {
        $('#GOOD').css({'background-color': '#4CAF50', 'color': '#fff'});
    } else {
        $('#BAD').css({'background-color': '#f44336', 'color': '#fff'});
    }

    // Star Badge: Gold if bestDays >= 3
    if (bestDays >= 3) {
        $('.badge').addClass('gold');
    } else {
        $('.badge').removeClass('gold');
    }
}



    // Initial update
    const container = $('#tdt-container');
    let score = parseInt(container.data('score'));
    let bestDays = parseInt(container.data('best-days'));
    updateRankColors(score, bestDays);

    // Also call updateRankColors again if score or rank changes dynamically
    // Example integration point:
    $('#yesBtn').on('click', function() {
        setTimeout(() => {
            const container = $('#tdt-container');
            score = parseInt(container.data('score'));
            bestDays = parseInt(container.data('best-days'));
            updateRankColors(score, bestDays);
        }, 500);
    });

    $('#resetBtn').on('click', function() {
        setTimeout(() => {
            $('#BEST, #BETTER, #GOOD, #BAD').css('background-color', '#fff').css('color', '#000');
            $('.badge').css('color', '#ccc');
        }, 500);
    });
});
