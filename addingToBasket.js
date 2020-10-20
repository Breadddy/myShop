<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.addingToBasket').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'addingToBasket.php',
            data: $(this).serialize(),
            success: function(response)
            {
                var jsonData = JSON.parse(response);
                if (jsonData.success == "1")
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Товар добавлен в корзину',
                        showConfirmButton: false,
                        timer: 1500
                      })
                      $("#basket").load('inc/basketCount.html');
                    //location.href = 'my_profile.php';
                }
                else
                {
                    alert('Ошибка');
                }
           }
       });
     });
});
</script>
