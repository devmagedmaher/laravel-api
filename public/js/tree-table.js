$(function () {
    var
        $table = $('#tree-table'),
        rows = $table.find('tr'),
        expanderClass = 'fa-plus-square',
        collapserClass = 'fa-minus-square'
        ;


    rows.each(function (index, row) {
        var
            $row = $(row),
            level = $row.data('level'),
            id = $row.data('id'),
            $columnName = $row.find('td[data-column="name"]'),
            children = $table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            var expander = $columnName.prepend('' +
                '<span class="treegrid-expander fa '+ expanderClass +' mouse-pointer"></span>' +
                '');

            children.hide();

            expander.on('click', function (e) {
                var $target = $(e.target);
                if ($target.hasClass(expanderClass)) {
                    $target
                        .removeClass(expanderClass)
                        .addClass(collapserClass)
                        .closest('tr')
                        .addClass('info');

                    children.show();
                } else if($target.hasClass(collapserClass)) {
                    $target
                        .removeClass(collapserClass)
                        .addClass(expanderClass)
                        .closest('tr')
                        .removeClass('info');

                    reverseHide($table, $row);
                }
            });
        }

        $columnName.prepend('' +
            '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
            '');
    });

    // Reverse hide all elements
    reverseHide = function (table, element) {
        var
            $element = $(element),
            id = $element.data('id'),
            children = table.find('tr[data-parent="' + id + '"]');

        if (children.length) {
            children.each(function (i, e) {
                reverseHide(table, e);
            });

            $element
                .find('.' + collapserClass)
                .removeClass(collapserClass)
                .addClass(expanderClass);

            children.hide();
        }
    };
});
