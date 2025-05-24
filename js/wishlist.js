$(document).ready(function(){

  $(".AddWishlist").click(function() {
      var pid, pname, pimage, pprice;

      pid = $(this).attr("id");
      pname = $("#name_" + pid ).text().trim();
      pimage = $("#image_" + pid).attr("src");
      pprice = $("#price_" + pid).text().trim();

      $.ajax({
          url: './requests/add_wishlist.php',
          method: 'POST',
          data: { pid: pid, pname: pname, pimage: pimage, pprice: pprice, action: "add_wishlist" },
          dataType: "json",
          success: function(response) {
            if (response.status === "success") {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 2000
              });
            }
            else {
              Swal.fire({
                icon: 'warning',
                title: 'Not Logged In',
                text: 'Please log in to use the wishlist!',
              });
            }
          }
        });
  });

  // Remove item from wishlist
  $(".fa-times").click(function() { 
      var pid = $(this).attr("id");

      Swal.fire({
          title: 'Remove from Wishlist?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: './requests/add_wishlist.php',
              method: 'POST',
              data: { product_id: pid, action: 'remove_wishlist' },
              dataType: "json",
              success: function(response) {
                if (response.status === "success") {
                  Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                  });
                  location.reload(); // Refresh wishlist
                }
              }
            });
          }
        });
  });
});
