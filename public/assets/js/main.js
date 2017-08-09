/**
 * Created by ngocnh on 5/24/15.
 */

$(function () {
    $('table[data-table]').each(function () {
        $(this).dataTable({
            "paginate": false,
            "lengthChange": true,
            "filter": true,
            "sort": true,
            "info": true,
            "autoWidth": true,
            "order": [[0, "desc"]],
            "columns": [
                null,
                null,
                null,
                {"sortable": false}
            ]
        });
    });

    select2();
    ckeditor();
});

/* Select2 */
function select2() {
    $('input[select2]').each(function () {
        if ($(this).attr('data-ajax-url')) {
            var multiple = $(this).attr('multiple') ? true : false;
            var dataName = $(this).data('name') ? $(this).data('name') : false;
            var dataValue = $(this).data('value') ? $(this).data('value') : false;
            var dataMax = $(this).data('max') ? $(this).data('max') : 0;
            var dataSelected = $(this).data('selected') ? $(this).data('selected') : false;
            var dataOld = $(this).data('old') ? $(this).data('old') : false;
            var $that = $(this);

            var $select2 = $(this).select2({
                placeholder: $(this).attr('placeholder'),
                multiple: multiple,
                maximumSelectionSize: dataMax,
                ajax: {
                    url: $(this).data('ajax-url'),
                    dataType: 'json',
                    data: function (term, page) {
                        return {
                            q: term,
                            page: page
                        };
                    },
                    results: function (data, page) {
                        return {
                            results: data.items,
                            more: page < data.meta.pagination.total_pages
                        };
                    },
                    cache: true
                },
                formatResult: function (item) {
                    return dataName !== false ? fetchFromObject(item, dataName) : item.name;
                },
                formatSelection: function (item) {
                    if (dataOld) {
                        var data = [];

                        if ($('#' + dataOld).val()) {
                            data = jQuery.parseJSON($('#' + dataOld).val());
                        }

                        if (multiple) {
                            data.push(item);
                        } else {
                            data = item;
                        }

                        $('#' + dataOld).val(JSON.stringify(data));
                    }

                    return dataName !== false ? fetchFromObject(item, dataName) : item.name;
                },
                escapeMarkup: function (m) {
                    return m;
                },
                initSelection: function (item, callback) {
                    var data = {};
                    data['id'] = item.val();
                    data[dataName !== false ? dataName : 'name'] = item.data('option');
                    callback(data);
                }
            });

            if (dataSelected) {
                $(this).select2('data', dataSelected);
            }
        }
    });
}

function fetchFromObject(obj, prop) {
    //property not found
    if (typeof obj === 'undefined') return false;

    //index of next property split
    var _index = prop.indexOf('.');

    //property split found; recursive call
    if (_index > -1) {
        //get object at property (before split), pass on remainder
        return fetchFromObject(obj[prop.substring(0, _index)], prop.substr(_index + 1));
    }

    //no split; get property
    return obj[prop];
}

/* CK Editor */
function ckeditor() {
    $('textarea.editor').each(function () {
        CKEDITOR.replace($(this).attr('id'), {
            skin: 'bootstrapck',
            language: LOCALE,
            allowedContent: true,
            enterMode: CKEDITOR.ENTER_BR,
            filebrowserBrowseUrl: BASE_URL + '/assets/js/libs/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: BASE_URL + '/assets/js/libs/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: BASE_URL + '/assets/js/libs/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: BASE_URL + '/assets/js/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: BASE_URL + '/assets/js/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: BASE_URL + '/assets/js/libs/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    });
}

/* CK Finder */
function ckfinder(element, element2) {
    var finder = new CKFinder();
    finder.selectActionFunction = function (fileUrl) {
        if (element[0].tagName.toLowerCase() == 'img') {
            element.attr('src', fileUrl);
            element2.val(fileUrl.replace(BASE_URL, ''));
        } else {
            element.val(fileUrl.replace(BASE_URL, ''));
        }
    };
    finder.SelectFunctionData = 'images';
    finder.language = LOCALE;
    finder.popup();
}