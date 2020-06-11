const Search = {
    init: function(){
        this.eventHandler();
    },
    eventHandler: function() {
        $(document).on('change', '.search-form', function() {
            Search.queryStringBuilder();
        })
    },

    queryStringBuilder: function() {

        const region = $('input[name=region]:checked').map(function () {
            return this.value;
        }).get();

        let regionString = region.join();
        let param = {
            tajegyseg: regionString,
        };


        if(region.length === 0 || region === '') { delete param['tajegyseg']; }

        let qs = $.param(param);
        console.log(qs);

        let locationWithParam = window.location.origin + window.location.pathname + '?' + qs;
        let location = window.location.origin + window.location.pathname;

        if(region.length !== 0) {
            window.location.href = locationWithParam;
        } else {
            window.location.href = location;
        }

    },
}

$(function() {
    Search.init();
})
