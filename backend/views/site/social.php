<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>


<script>
    $(document).ready(function() {
        $.ajaxSetup({ cache: true });
        $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
                appId: '824540648022199',
                version: 'v2.7' // or v2.1, v2.2, v2.3, ...
            });
            $('#loginbutton,#feedbutton').removeAttr('disabled');
            FB.getLoginStatus(updateStatusCallback);
        });

        function updateStatusCallback(response){
            console.log(response);
        }
    });

</script>

