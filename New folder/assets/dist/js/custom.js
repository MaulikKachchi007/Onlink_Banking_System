// $(document).ready(function(){
//     $('#loading_data').hide();
//     $('#trackbtn').click(async function(e){
//         if($('#tracknumber').val()){
//            $.ajax({
//                data: {loan_app_number:$('#tracknumber').val()},
//                method:'POST',
//                url:'ajaxloanstatus.php',
//                success: function(data){
//                    setTimeout(function(){
//                        $('#loading_data').hide();
//                            $('.table_data').html(data);
//                    },1000)
//                },
//                beforeSend: function(){
//                     $('#loading_data').show();
//                }
//            })
//         // }else{
//         }
//     })
// })