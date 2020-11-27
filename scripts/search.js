const token = document.getElementsByClassName('token');
const qTable = document.getElementById('table');
const qHeading = document.getElementById('table-label');
var base_url = document.getElementById('base_url').innerHTML;

$(document).ready(function() {

    $('#search_data').tokenfield({
        autocomplete: {
            source: function(request, response) {
                jQuery.get(base_url + '/tags/search?term=' + request.term, {

                }, function(data) {
                    data = JSON.parse(data);
                    response(data);
                });
            },
            delay: 100
        }
    });

    $('#search').click(function() {
        var x = encodeURIComponent($('#search_data').val());
        window.location.replace(base_url + '/search/problems?tag=' + x)
    });
});