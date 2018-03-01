$(document).ready(function(){
    $('select[id$="per_page"]').change(function(e){
        var $_GET = {};

        document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
            function decode(s) {
                return decodeURIComponent(s.split("+").join(" "));
            }

            $_GET[decode(arguments[1])] = decode(arguments[2]);
        });

        activityId = $_GET["activityId"];
        if(activityId.length > 0){
            url =  $('select[id$="per_page"] :selected').val() + '&activityId='+activityId;
            window.location.replace(url);
        }

    });
});
