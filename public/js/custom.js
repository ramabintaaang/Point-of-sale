function inputAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }


        // function printErrorMsg(msg) {
        //     $.each(msg, function(key, value) {
        //         console.log(msg,key,value);
        //         if(key){
        //             $('.' + key + '_err').text(value)
        //         } else if(key == !key){
        //             $('.' + key + '_err').text('woi');
        //         }
        //     });
        // }

        ///Kalau Unordered list
        ///1.Di controller error ditambah -> all()

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }