$(function() {
    let current_cell;
    $(document).on('click', '.str__value', function() {
        current_cell = $(this);
        let table = $(this).find('a').data('table');
        let column = $(this).find('a').data('column');
        $('[name="table"]').val(table);
        $('[name="column"]').val(column);
    });

    $(document).on('submit', '#change-value form', function() {
        let that =  $(this);
        let data = $(this).serialize();
        $.ajax({
            url: 'assets/action.php',
            data: data,
            type: 'post',
            success: function(html){
                that.get(0).reset();
                $.fancybox.close();
                current_cell.html(html);
            }
        });
        return false;
    });
});
