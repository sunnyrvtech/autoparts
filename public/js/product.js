$(document).ready(function () {
    
    $(document).on('click', '#list', function (event) {
        event.preventDefault();
        $('#products-content-area .item').addClass('list-group-item');
    });

    $(document).on('click', '#grid', function (event) {
        event.preventDefault();
        $('#products-content-area .item').removeClass('list-group-item');
        $('#products-content-area .item').addClass('grid-group-item');
    });

    $(document).on('mouseenter', '#products-content-area .item', function () {
        $(this).find(".product-card__overlay").addClass("fadeInDown animated");
    });
    
    $(document).on('mouseleave', '#products-content-area .item', function () {
        $(this).find(".product-card__overlay").removeClass("fadeInDown");
    });
    
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();

        var qs = getQueryStrings();
        var URL = $(this).attr('href');
        if (qs['year'] != undefined) {
            URL =URL+'&year='+qs['year'];
        }
        if (qs['make_id'] != undefined) {
            URL =URL+'&make_id='+qs['make_id'];
        }
        if (qs['make_id'] != undefined) {
            URL =URL+'&model_id='+qs['model_id'];
        }
        
        angular.element(this).scope().getProductByPage(URL);
    });

    function getQueryStrings() {
        var assoc = {};
        var decode = function (s) {
            return decodeURIComponent(s.replace(/\+/g, " "));
        };
        var queryString = location.search.substring(1);
        var keyValues = queryString.split('&');

        for (var i in keyValues) {
            var key = keyValues[i].split('=');
            if (key.length > 1) {
                assoc[decode(key[0])] = decode(key[1]);
            }
        }

        return assoc;
    }

    $(document).on('click', '.checkbox-inline a', function (e) {
        $(this).parent().find('input:checkbox').click();
        if ($(this).parent().find('input:checkbox').is(':checked')) {
            $(this).addClass('filter-applied');
        } else {
            $(this).removeClass('filter-applied');
        }
    });
    
    $(document).on('click', '.checkbox-inline input:checkbox', function (e) {

        if ($(this).is(':checked')) {
            $(this).parent().find('a').addClass('filter-applied');
        } else {
            $(this).parent().find('a').removeClass('filter-applied');
        }
    });

});