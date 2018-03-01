(function($){
    $(document).ready(function() {
        var connection = null;

        try{
            var token = $('#call_status').attr('data-token');
            if(token){
                Twilio.Device.setup(token);
            } else {
                return;
            }

        } catch(err){
            return;
        }

        $('.make-call').on('click', function() {
            console.log($.trim($(this).text()));
            var params = {"PhoneNumber": $.trim($(this).text())};
            Twilio.Device.connect(params);
        });

        Twilio.Device.ready(function (device) {
            $("#call_status").text("Client is ready");
        });

        Twilio.Device.error(function (error) {
            $("#call_status").text("Error: " + error.message);
        });

        Twilio.Device.connect(function (conn) {
            $("#call_status").text("Successfully established call");
        });

        Twilio.Device.disconnect(function (conn) {
            $("#call_status").hide();
            toggleCallStatus();
        });

        Twilio.Device.incoming(function (conn) {
            $("#call_status").text("Incoming connection from " + conn.parameters.From);
            connection=conn;
            conn.accept();
        });

        Twilio.Device.offline(function() {
            $("#call_status").text("Connection lost");
        });

        Twilio.Device.cancel(function(conn) {
            $("#call_status").text("Connection cancel");
        });

        $('.key').on('click',function(){
            connection.sendDigits('*')
        });

        $('.call').on('click',function(){
            $("#call_status").show();
            params = {"PhoneNumber": $(this).attr('data-number'), "Contact": $(this).attr('data-contact')};
            connection = Twilio.Device.connect(params);
            toggleCallStatus();
        });

        $('.hangup').on('click',function(){
            Twilio.Device.disconnectAll();
        });

        function toggleCallStatus(){
            $('.call').toggle();
            $('.hangup').toggle();
            $('.key').toggle();
        }
    });
})(jQuery);

