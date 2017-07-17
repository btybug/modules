
     $(document).ready(function () {
         $('.get-user-profile').on('click',function () {
             var url='/'+$('#mytplpath').val()+'/logic.php';
             $.ajax({
                 type: "post",
                 datatype: "json",
                 url:url,
                 data:{'function':'profile','test':'qus'},
                 headers: {
                     'X-CSRF-TOKEN': $("input[name='_token']").val()
                 },
                 success: function (data) {
                     if (!data) {
                         console.log(data);
                     }
                 }
             });
         })
     })
