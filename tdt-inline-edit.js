 
jQuery(document).ready(function($) {
    $(document).on('click', '.editable-rank', function() {
        const btn = $(this);
        const currentText = btn.text();
        const rankId = btn.attr('id');

        const input = $('<input type="text" class="rank-input">').val(currentText);
        btn.replaceWith(input);
        input.focus();

        input.blur(function() {
            const newText = $(this).val();
            const newBtn = $('<button>')
                .attr('id', rankId)
                .addClass('editable-rank')
                .text(newText);

            $(this).replaceWith(newBtn);

            // Ajax call to save updated rank
            $.post(tdt_ajax.ajax_url, {
                action: 'update_rank_label',
                rank: rankId.toLowerCase(),
                value: newText
            });
        });
    });
});
