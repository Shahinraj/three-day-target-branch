jQuery(document).ready(function($) {
    $.post(tdt_ajax.ajax_url, { action: 'get_user_ranks' }, function(response) {
        if (response.success) {
            $('#BAD').text(response.data.bad);
            $('#GOOD').text(response.data.good);
            $('#BETTER').text(response.data.better);
            $('#BEST').text(response.data.best);
        }
    });
});
