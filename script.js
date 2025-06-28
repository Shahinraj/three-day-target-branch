jQuery(document).ready(function($) {
    const container = $('#tdt-container');
    let score = parseInt(container.data('score'));
    let bestDays = parseInt(container.data('best-days'));

    function showTodayPoint() {
        $('#today-point').text('আপনার আজকের পয়েন্ট: ' + score);
    }
    showTodayPoint();

    function updateRank() {
        $('.rank').removeClass('highlight');
        let message = "";

        if (score >= 15) {
            $('#BEST').addClass('highlight');
            message = "আপনি আজকের জন্য BEST র‍্যাংকিং অর্জন করেছেন। লেগে থাকুন, ৩ দিনের টার্গেট পূরণে আপনাকে অগ্রিম অভিনন্দন।";
        } else if (score >= 10) {
            $('#BETTER').addClass('highlight');
            message = "অভিনন্দন! BETTER র‍্যাংকিং অর্জন করেছেন। চালিয়ে যান আরও ৫ বার কাজ করলে আপনি BEST র‍্যাংকিং অর্জন করবেন।";
        } else if (score >= 5) {
            $('#GOOD').addClass('highlight');
            message = "অভিনন্দন! GOOD র‍্যাংকিং অর্জন করেছেন। চালিয়ে যান আরও ৫ বার কাজ করলে আপনি BETTER র‍্যাংকিং অর্জন করবেন।";
        } else {
            $('#BAD').addClass('highlight');
        }

        if (bestDays >= 3) {
            console.log("Badge active! তিনদিন BEST হয়েছে: ", bestDays);
            message = "আপনি তিন দিনের টার্গেট পূরণ করেছেন! আপনাকে অভিনন্দন, আপনি ওয়ানস্টার র‍্যাংকিং অর্জন করেছেন।";
            $('.badge').addClass('active');
            if (typeof confetti === "function") confetti();
            let audio = new Audio('https://cdn.pixabay.com/audio/2022/03/15/audio_115b9c6cfa.mp3');
            audio.play();
            $('#congratsMessage').append('<div style="margin-top:10px;"><button onclick="window.open(\'https://www.facebook.com/sharer/sharer.php?u=https://yourlink.com\', \'_blank\')">Facebook-এ শেয়ার করুন</button></div>');
        } else {
            console.log("Badge inactive. bestDays:", bestDays);
        }

        if (message) {
            $('#congratsMessage').html('<div class="message">' + message + '</div>');
        }
        showTodayPoint();
    }

    updateRank();

    $('#yesBtn').click(function() {
        $.post(tdt_ajax.ajax_url, {
            action: 'tdt_add_point'
        }, function(response) {
            if (response.success) {
                score = response.data.score;
                bestDays = response.data.best_days;
                updateRank();
            }
        });
    });

    $('#resetBtn').click(function() {
        if (confirm("আপনি কি নিশ্চিতভাবে রিসেট করতে চান?")) {
            $.post(tdt_ajax.ajax_url, {
                action: 'tdt_reset_score'
            }, function(response) {
                if (response.success) {
                    score = 0;
                    bestDays = 0;
                    updateRank();
                    $('#congratsMessage').html('<div class="message">রিসেট সম্পন্ন হয়েছে।</div>');
                }
            });
        }
    });
   /*কারেন্ট সময় লেখার কোড  12/6/25 */
    function formatBanglaTime(date) {
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let period = '';
        if (hours < 6) period = "রাত";
        else if (hours < 12) period = "সকাল";
        else if (hours < 16) period = "দুপুর";
        else if (hours < 18) period = "বিকাল";
        else period = "সন্ধ্যা";
        let displayHours = hours % 12;
        if (displayHours === 0) displayHours = 12;
        let minStr = minutes < 10 ? "0" + minutes : minutes;
        return ` সময় : ${period} ${displayHours}:${minStr}`;
    }

    function showCurrentTime() {
        const now = new Date();
        $('#current-time').text(formatBanglaTime(now));
    }
    showCurrentTime();
    setInterval(showCurrentTime, 1000);
});
